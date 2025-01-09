<?php

use App\Api\GameLookupService;

test('game service get game from search', function () {
    try {
        $game_lookup = new GameLookupService;
        $data = $game_lookup->getGameDataFromSearch('Halo 5');
        expect($data)->toBeArray()
            ->and($data)->not->toBeEmpty();

        $game = $data[0];
        assert(isset($game['name']));
    } catch (Exception $exception) {
        expect($exception->getMessage())->toBe('', 'Exception was given');
    }
});
