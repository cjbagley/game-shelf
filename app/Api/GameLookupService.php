<?php

namespace App\Api;

use Carbon\CarbonInterval;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GameLookupService
{
    final public const GENERIC_ERROR_MSG = 'Error loading Game Data';

    final public const EMPTY_ARRAY_MSG = 'Non Array response from getGameData API call';

    final protected const CACHE_KEY = 'game_lookup_access_token';

    private ?string $access_token;

    private readonly ?string $api_url;

    private readonly ?string $auth_url;

    public function __construct()
    {
        $this->api_url = config('igdb.api_url');
        $this->auth_url = config('igdb.auth_url');
        if (! $this->auth_url || ! $this->api_url) {
            Log::error('Missing IGDB details in .env file');
            abort(500, self::GENERIC_ERROR_MSG);
        }

        $this->access_token = $this->getAccessToken();
        if ($this->access_token === null) {
            Log::error('Empty IGDB access token');
            abort(500, self::GENERIC_ERROR_MSG);
        }
    }

    public function getGameDataFromSearch(string $search): array
    {
        $query = '
        search "%s";
        fields
            name,
            cover.url,
            total_rating,
            total_rating_count,
            category,
            first_release_date,
            platforms.name,
            platforms.abbreviation,
            summary,
            genres.name;
        where category = (0) & rating != null;
        limit 10;
        ';

        return $this->apiRequest('games', sprintf($query, $search));
    }

    private function getAccessToken(): ?string
    {
        $access_token = Cache::get(self::CACHE_KEY);

        if ($access_token !== null) {
            return $access_token;
        }

        try {
            $data = [
                'client_id' => config('igdb.client_id'),
                'client_secret' => config('igdb.client_secret'),
                'grant_type' => 'client_credentials',
            ];

            $r = Http::post($this->auth_url, $data)->throw()->json();
            if (is_array($r) && ! empty($r['access_token'])) {
                Cache::put(self::CACHE_KEY, $r['access_token'], CarbonInterval::week());

                return $r['access_token'];
            }
        } catch (Exception $exception) {
            Log::error(sprintf('Error obtaining key: %s', $exception->getMessage()));
        }

        return null;
    }

    private function apiRequest(string $endpoint, string $body): array
    {
        try {
            $r = Http::withHeader('Client-ID', config('igdb.client_id'))
                ->withToken($this->access_token)
                ->withBody($body, 'application/json')
                ->contentType('application/json')
                ->acceptJson()
                ->post($this->api_url . $endpoint)
                ->throw()
                ->json();
        } catch (Exception $exception) {
            if ($exception->getCode() === 401) { // Token expired or invalid
                $this->access_token = $this->getAccessToken();
                if ($this->access_token !== null) {
                    return $this->apiRequest($endpoint, $body); // Retry the request
                }
            }

            Log::error($exception->getMessage());
            if (defined('DEBUG_ERRORS')) {
                throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
            }

            throw new Exception(self::GENERIC_ERROR_MSG, $exception->getCode(), $exception);
        }

        if (! is_array($r)) {
            Log::error(self::EMPTY_ARRAY_MSG);
            throw new Exception(self::EMPTY_ARRAY_MSG);
        }

        return $r;
    }
}
