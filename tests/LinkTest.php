<?php

use Bramin\CuttlyPHP\Cuttly;
use Bramin\CuttlyPHP\CuttlyException;
use Illuminate\Support\Carbon;

it('can create a link', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->createShortLink('https://google.com');

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
    ]);
});

it('can create a link with a specific name', function () {
    $cuttly = new Cuttly();

    $name = 'title' . rand(1000, 999999);
    $response = $cuttly->createShortLink('https://google.com', $name);

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'shortLink' => 'https://cutt.ly/' . $name,
        'title' => 'Google',
    ]);
});

it('can create a link without a title', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->createShortLink('https://google.com', '', null, true);

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
    ]);
});

it('can recognize a bad url', function () {
    $cuttly = new Cuttly();

    $cuttly->createShortLink('not a valid url');
})->throws(CuttlyException::class, 'the entered link is not a link');

it('can update a link', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->createShortLink('https://google.com');

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
    ]);

    $cuttly->updateShortLink($response['shortLink']);
})->skip('updateShortLink not yet implemented');
