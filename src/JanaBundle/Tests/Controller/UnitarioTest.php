<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento
 * Date: 24/04/18
 * Time: 13:44
 */

namespace JanaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;;


class UnitarioTest extends WebTestCase
{
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
}
