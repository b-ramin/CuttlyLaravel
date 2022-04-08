<?php

use Bramin\CuttlyPHP\Cuttly;
use Bramin\CuttlyPHP\CuttlyException;
use Illuminate\Http\Client\ConnectionException;

it('can ping cuttly', function () {
    $cuttly = new Cuttly();

    $response = $cuttly->ping();

    expect($response)->toBeTrue();
});

it('can recognize a bad key', function () {
    config(['cuttly.key' => 'bad-key']);

    $cuttly = new Cuttly();

    $cuttly->ping();
})->throws(CuttlyException::class, '401: Invalid API key');

it('can recognize a bad url', function () {
    config([
        'cuttly.key' => 'bad-key',
        'cuttly.url' => 'https://cutt.ly/api/broken-api.php',
    ]);

    $cuttly = new Cuttly();

    $cuttly->ping();
})->throws(ConnectionException::class);
