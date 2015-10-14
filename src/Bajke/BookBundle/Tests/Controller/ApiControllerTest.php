<?php

namespace Bajke\BookBundle\Tests\Controller;


use Bajke\BookBundle\Tests\ApiTestCase;

class ApiControllerTest extends ApiTestCase {

    public function testPOST(){
        $book = array(
            'title' => 'Naslov',
            'description' => 'Opis',
        );

//        $response = $this->client->
        $response = $this->client->post('/api/book', [
            'body' => json_encode($book)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $body = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('id', $body);
        $this->assertArrayHasKey('title', $body);
        $this->assertEquals('Naslov', $body['title']);
        $this->assertArrayHasKey('description', $body);
        $this->assertEquals('Opis', $body['description']);
    }

}