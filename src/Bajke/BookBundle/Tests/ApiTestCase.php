<?php

namespace Bajke\BookBundle\Tests;


use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiTestCase extends KernelTestCase {

    private static $staticClient;

    protected $client;

    public static function setUpBeforeClass(){
        self::$staticClient = new Client([
            'base_url' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false,
            ]
        ]);

        self::bootKernel();
    }

    protected function setUp(){
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }

    protected function tearDown(){

    }

    protected function getService($id){
        return self::$kernel->getContainer()->get($id);
    }

    private function purgeDatabase(){
        $em = $this->getService('doctrine')->getManager();
        $book = $em->getRepository('BookBundle:Book')->findOneBy(array('title' => 'Naslov', 'description' => 'Opis'));
        $em->remove($book);
        $em->flush();
    }
}