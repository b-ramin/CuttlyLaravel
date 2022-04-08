<?php

use Bramin\CuttlyPHP\Cuttly;

it('can delete a link', function () {
    $cuttly = new Cuttly();

    $url = $cuttly->create('https://google.com');

    expect($cuttly->delete($url['shortLink']))->toBeTrue();
})->skip('Not available on free subscription');
