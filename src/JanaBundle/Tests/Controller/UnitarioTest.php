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
//    public function testInsertNow(){
//        $client = static::createClient();
//
//        $client->request('POST',
//            '/ponto/now/type/1',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = $client->getResponse();
//        $data = json_decode($response->getContent(), true);
//
//        $this->assertSame(array('response' => true), $data);
//    }
//
//    public function testInsertDate(){
//        $client = static::createClient();
//
//        $client->request('POST',
//            '/ponto/2018-04-09%2012:10:05/type/2',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = $client->getResponse();
//        $data = json_decode($response->getContent(), true);
//
//        $this->assertSame(array('response' => true), $data);
//    }

//    public function testDeletaPonto(){
//        $client = static::createClient();
//
//        $client->request('DELETE',
//            '/ponto/delete/15',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        $this->assertSame(array('response' => true, 'id' => '15'), $response);
//    }


//    public function testAlteraPonto(){
//        $client = static::createClient();
//
//        $client->request('PUT', '/ponto/update/1?date=now&tipo=3',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        $this->assertSame(array('response' => true), $response);
//    }
//
//    public function testAlteraPontoDateCustom(){
//        $client = static::createClient();
//
//        $client->request('PUT', '/ponto/update/2?date=2018-04-09%2008:55:01&tipo=1',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        $this->assertSame(array('response' => true), $response);
//    }

//    public function testBuscaPorDia(){
//        $client = static::createClient();
//
//        $client->request('GET', '/ponto/2018-04-10',
//            array(),
//            array(),
//            array(
//                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'HTTP_ACCEPT'       => 'application/json'
//            )
//        );
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        $assert = array(
//            '2018-04-10' => array(
//                'ENTRADA'           =>  '10:11:24',
//                'ALMOCO_SAIDA'      =>  '10:15:07',
//                'ALMOCO_VOLTA'      =>  '10:23:52',
//                'SAIDA'             =>  '10:31:58'
//            )
//        );
//
//        $this->assertSame($assert, $response);
//    }

    public function testBuscaMesECalculo(){
        $client = static::createClient();

        $client->request('PUT', '/relatorio/1?mes=04&ano=2018',
            array(),
            array(),
            array(
                'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'HTTP_ACCEPT'       => 'application/json'
            )
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayNotHasKey('error', $response);
        $this->assertContains('2018-04-09 08:55:01', $response, 'Valores não condizem com o banco');
        $this->assertArrayHasKey('calc', $response);
        $this->assertArrayHasKey('sum', $response);
    }
}
