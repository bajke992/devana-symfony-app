<?php

require __DIR__.'/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8000',
    'defaults' => [
        'exceptions' => false,
    ]
]);

//$book1 = array(
//    'title' => 'title - '.rand(0, 999),
//    'description' => 'description - '.rand(0, 999),
//);

//$response1 = $client->post('/api/book', [
//    'body' => json_encode($book1)
//]);

//$response2_1 = $client->get('/api/book/3');
//$response2_2 = $client->get('/api/book/13');

$response3 = $client->get('/api/book');


//echo $response1;
//echo $response2_1;
//echo $response2_2;
echo $response3;
echo "\n\n";


