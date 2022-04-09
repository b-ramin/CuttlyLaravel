<?php

use Bramin\CuttlyPHP\CuttlyException;
use Bramin\CuttlyPHP\Facades\Cuttly;
use Illuminate\Support\Carbon;

it('can create a link', function () {
    $response = Cuttly::create('https://google.com');

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
    ]);
});

it('can create a link with a specific name', function () {
    $name = 'title' . rand(1000, 999999);
    $response = Cuttly::create('https://google.com', $name);

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'shortLink' => 'https://cutt.ly/' . $name,
        'title' => 'Google',
    ]);
});

it('can create a link without a title', function () {
    $response = Cuttly::create('https://google.com', '', null, true);

    expect($response)->toBeArray()->toMatchArray([
        'status' => 7,
        'fullLink' => 'https://google.com',
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
    ]);
});

it('can recognize a bad url', function () {
    Cuttly::create('not a valid url');
})->throws(CuttlyException::class, 'the entered link is not a link');
