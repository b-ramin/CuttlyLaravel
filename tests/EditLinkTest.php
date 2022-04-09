<?php

use Bramin\CuttlyPHP\Facades\Cuttly;

it('can add a tag to a link', function () {
    $response = Cuttly::create('https://google.com');

    expect(Cuttly::addTag($response['shortLink'], 'test'))->toBeTrue();
})->skip('Not available on free subscription');

it('can update the source of a link', function () {
    $response = Cuttly::create('https://google.com');

    expect(Cuttly::updateSource($response['shortLink'], 'http://google.com'))->toBeTrue();
})->skip('Not available on free subscription');

it('can update the title of a link', function () {
    $response = Cuttly::create('https://google.com');

    $name = 'title' . rand(1000, 999999);
    expect(Cuttly::updateTitle($response['shortLink'], $name))->toBeTrue();
})->skip('Not available on free subscription');
