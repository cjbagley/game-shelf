<?php

namespace App\Http\Controllers;

use App\Api\GameLookupService;
use App\Http\Requests\SearchRequest;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index()
    {
        return Inertia::render('SearchPage');
    }

    public function search(SearchRequest $request)
    {
        $game_lookup_service = new GameLookupService;

        return $game_lookup_service->getGameDataFromSearch($request->get('query'));
    }
}
