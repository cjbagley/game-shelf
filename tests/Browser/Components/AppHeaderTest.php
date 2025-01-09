<?php

use Laravel\Dusk\Browser;

test('AppHeader shows', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(route('index'))
            ->assertSeeIn('header h1', 'Game Shelf');
    });
});
