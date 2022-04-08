<?php

use Bramin\CuttlyPHP\Cuttly;

it('can add a tag to a link', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->create('https://google.com');

    expect($cuttly->addTag($response['shortLink'], 'test'))->toBeTrue();
})->skip('Not available on free subscription');

it('can update the source of a link', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->create('https://google.com');

    expect($cuttly->updateSource($response['shortLink'], 'http://google.com'))->toBeTrue();
})->skip('Not available on free subscription');

it('can update the title of a link', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->create('https://google.com');

    $name = 'title' . rand(1000, 999999);
    expect($cuttly->updateTitle($response['shortLink'], $name))->toBeTrue();
})->skip('Not available on free subscription');
