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

        $client->request('GET',
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

        $client->request('GET',
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
}
