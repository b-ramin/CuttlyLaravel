<?php

use Bramin\CuttlyPHP\Cuttly;
use Bramin\CuttlyPHP\CuttlyException;
use Illuminate\Support\Carbon;

it('can get a links analytics', function () {
    $cuttly = new Cuttly();

    $url = $cuttly->create('https://google.com');

    $response = $cuttly->getAnalytics($url['shortLink']);

    expect($response)->toBeArray()->toMatchArray([
        'status' => 1,
        'clicks' => 0,
        'date' => Carbon::today()->toDateString(),
        'title' => 'Google',
        'fullLink' => 'https://google.com',
        'facebook' => 0,
        'twitter' => 0,
        'pinterest' => 0,
        'instagram' => 0,
        'googlePlus' => 0,
        'linkedin' => 0,
        'rest' => 0,
        'devices' => [],
        'refs' => [],
    ]);
});

it('throws an error when passing an invalid dateFrom', function () {
    $cuttly = new Cuttly();

    $cuttly->getAnalytics('https://cutt.ly/abcd', '1234-56-78');
})->throws(CuttlyException::class, 'dateFrom must match YYYY-MM-DD format');

it('throws an error when passing an invalid dateTo', function () {
    $cuttly = new Cuttly();

    $cuttly->getAnalytics('https://cutt.ly/abcd', '2022-04-08', '1234-56-78');
})->throws(CuttlyException::class, 'dateTo must match YYYY-MM-DD format');
