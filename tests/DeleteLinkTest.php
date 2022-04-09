<?php

use Bramin\CuttlyLaravel\Facades\Cuttly;

it('can delete a link', function () {
    $url = Cuttly::create('https://google.com');

    expect(Cuttly::delete($url['shortLink']))->toBeTrue();
})->skip('Not available on free subscription');
