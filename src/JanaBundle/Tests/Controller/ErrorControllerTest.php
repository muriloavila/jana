<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento
 * Date: 09/04/18
 * Time: 11:29
 */

namespace JanaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ErrorControllerTest extends WebTestCase
{
    public function testIndex(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }

    public function testErroDate(){
        $client = static::createClient();

        $client->request('POST',
            '/ponto/2018-04-01/type/1',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertSame(array('response' => false, 'message' => 'Error parsing DateTime'), $data);
    }

    public function testErroType(){
        $client = static::createClient();

        $client->request('POST',
            '/ponto/now/type/5',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertSame(array('response' => false, 'message' => 'Error: not find Tipo'), $data);

    }

    public function testErroDeletaPonto(){
        $client = static::createClient();

        $client->request('DELETE',
            '/ponto/delete/1',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => false, 'message' => 'Error: not find Ponto'), $response);
    }

    public function testErroDeletaPontonotPassId(){
        $client = static::createClient();

        $client->request('DELETE',
            '/ponto/delete/',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(null, $response);
    }

    public function testErrorAlteraPontoNotFound(){
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

        $this->assertSame(array('response' => false, 'message' => 'Error: not find Ponto'), $response);
    }

    public function testErrorAlteraPontoTipoNotFound(){
        $client = static::createClient();

        $client->request('PUT', '/ponto/update/37?date=now&tipo=10',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => false, 'message' => 'Error: not find Tipo'), $response);
    }

    public function testErrorAlteraPontoDateFormat(){
        $client = static::createClient();

        $client->request('PUT', '/ponto/update/37?date=2018-04-03%2010&tipo=10',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(array('response' => false, 'message' => 'Error parsing DateTime'), $response);
    }
}
