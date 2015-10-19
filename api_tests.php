<?php

require __DIR__.'/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8000',
    'defaults' => [
        'exceptions' => false,
    ]
]);

$book1 = array(
    'title' => 'title - test2 - '.rand(0, 999),
    'description' => 'description - test2 - '.rand(0, 999),
    'owner' => 1,
);

$book2 = array(
    'title' => 'edited 9',
    'description' => 'edited 9',
//    'owner' => 1,
);

$book3 = array(
    'title' => 'edited 10',
    'description' => 'edited 10',
//    'owner' => 1,
);

$response1 = $client->post('/api/book', [
    'body' => json_encode($book1)
]);

//$response2_1 = $client->get('/api/book/3');
//$response2_2 = $client->get('/api/book/16');
//$response3 = $client->get('/api/book');

$response4 = $client->put('/api/book/30', [
    'body' => json_encode($book2)
]);

$response5 = $client->delete('/api/book/33');

$response6 = $client->patch("/api/book/31", [
    'body' => json_encode($book3)
]);


echo $response1;
echo "\n\n";
//echo $response2_1;
//echo $response2_2;
//echo $response3;
echo $response4;
echo "\n\n";
echo $response5;
echo "\n\n";
echo $response6;
echo "\n\n";


