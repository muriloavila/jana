<?php
namespace JanaBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;


class TipoPontoService
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

    public function getTipoById($id){
        if(empty($id)){
            return array('error' => true, 'message'=> utf8_encode('Empty PontoTipo Id'));
        }

        if(!is_numeric($id)){
            return array('error' => true, 'message'=> utf8_encode('PontoTipo ID needs to be a Number'));
        }

        $retorno = $this->entityManager->getRepository('JanaBundle:TipoPonto')->findOneById($id);

        return $retorno;
    }
}