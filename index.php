<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Pool;

$client = new Client();
$uri = 'https://jsonplaceholder.typicode.com/todos';
$total = 10;
$concurrency = 10;

$requests = function ($total) use ($client, $uri) {
    for ($i = 0; $i < $total; $i++) {
        yield function() use ($client, $uri) {
            return $client->getAsync($uri);
        };
    }
};

$pool = new Pool($client, $requests($total), [
    'concurrency' => $concurrency,
    'fulfilled' => function ($response, $index) {
        dump(date('H:i:s'));
    },
    'rejected' => function ($reason, $index) {
        dump($reason->getResponse()->getReasonPhrase());
    },
]);

$promise = $pool->promise();

$promise->wait();
