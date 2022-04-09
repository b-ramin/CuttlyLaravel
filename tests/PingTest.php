<?php

use Bramin\CuttlyLaravel\CuttlyException;
use Bramin\CuttlyLaravel\Facades\Cuttly;
use Illuminate\Http\Client\ConnectionException;

it('can ping cuttly', function () {
    $response = Cuttly::ping();

    expect($response)->toBeTrue();
});

it('can recognize a bad key', function () {
    config(['cuttly.key' => 'bad-key']);

    Cuttly::ping();
})->throws(CuttlyException::class, '401: Invalid API key');

it('can recognize a bad url', function () {
    config([
        'cuttly.key' => 'bad-key',
        'cuttly.url' => 'https://cutt.ly/api/broken-api.php',
    ]);

    Cuttly::ping();
})->throws(ConnectionException::class);
