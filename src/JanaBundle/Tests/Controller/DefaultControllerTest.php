<?php

namespace JanaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }

    public function testInsertNow(){
        $client = static::createClient();

        $client->request('GET',
            '/ponto/now/type/1',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertSame(array('response' => 'true'), $data[0]);
    }
}


