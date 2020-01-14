<?php
namespace App\Tests;
use GuzzleHttp;
use PHPUnit\Framework\TestCase;

// ./vendor/bin/phpunit  tests/
class ProjectTest extends  TestCase
{

    private $client;
    private $urlPath="http://web";
    public function setUp()
    {
        parent::setUp();

        $this->client = new \GuzzleHttp\Client();



    }
    public function testGetData()
    {

        $response =  $this->client->request('POST', $this->urlPath.'/getdata/',
            [
                'form_params' => [
                    'em_name' => 'r',
                    'ev_name' => 'p',
                ]
            ]
            );

        $this->assertEquals(200,$response->getStatusCode());
        //dd($response->getBody()->getContents());
        $this->assertEquals('[{"id":"1","employee_name":"Reto Fanzen","employee_mail":"reto.fanzen@no-reply.rexx-systems.com","event_name":"PHP 7 crash course","participation_fee":"0","version":"1.0.17+42","event_date":"2019-09-04 08:00:00"}]',$response->getBody()->getContents());
    }



    public function tearDown()
    {
        parent::tearDown();


    }



}
