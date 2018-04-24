<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento
 * Date: 24/04/18
 * Time: 10:47
 */
namespace JanaBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class PontoService
{
    /**
     * Container
     *
     */
    protected $container;

    /**
     * entityManager
     */
    protected $entityManager;

    /**
     *
     */
    public function __construct(Container $container, EntityManager $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function getPontoById($id){

        if(empty($id)){
            return array('error' => true, 'message'=> utf8_encode('Empty Id'));
        }

        if(!is_numeric($id)){
            return array('error' => true, 'message'=> utf8_encode('ID needs to be a Number'));
        }

        $retorno = $this->entityManager->getRepository('JanaBundle:Ponto')->findAllById($id);

        return $retorno->toJson();
    }

    public function getPontoByDay($day){
        $data_inicio    = $day." 00:00:00";
        $data_final     = $day." 23:59:59";

        $data_inicio = \DateTime::createFromFormat('Y-m-d H:i:s', $data_inicio);
        $data_final  = \DateTime::createFromFormat('Y-m-d H:i:s', $data_final);

        if($data_inicio == false || $data_final == false){
            return ['response' => false, 'message' => utf8_encode('Error parsing DateTime')];
        }

        $retorno = array();
        $pontos = $this->entityManager->getRepository('JanaBundle:Ponto')->findAllByDay($data_inicio, $data_final);
        foreach ($pontos as $ponto) {
            $retorno[] = $ponto->toJson();
        }


        return $retorno;
    }
}