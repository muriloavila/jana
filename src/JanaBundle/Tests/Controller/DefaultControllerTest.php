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

        $client->request('POST',
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

        $this->assertSame(array('response' => true), $data);
    }

    public function testInsertDate(){
        $client = static::createClient();

        $client->request('POST',
            '/ponto/2018-04-09%2012:10:05/type/2',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertSame(array('response' => true), $data);
    }


    public function testDeletaPonto(){
        $client = static::createClient();

        $client->request('DELETE',
            '/ponto/delete/36',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => true, 'id' => '36'), $response);
    }

    public function testAlteraPonto(){
        $client = static::createClient();

        $client->request('PUT', '/ponto/update/36?date=now&tipo=3',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => true), $response);
    }

    public function testAlteraPontoDateCustom(){
        $client = static::createClient();

        $client->request('PUT', '/ponto/update/37?date=2018-04-09%2008:55:01&tipo=1',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => true), $response);
    }



}

?>


