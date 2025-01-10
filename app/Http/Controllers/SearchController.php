<?php

namespace App\Http\Controllers;

use App\Api\GameLookupService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index()
    {
        return Inertia::render('SearchPage');
    }

    public function search(Request $request)
    {
        $game_lookup_service = new GameLookupService;

        return $game_lookup_service->getGameDataFromSearch('Sonic');
    }
}
