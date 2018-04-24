<?php
namespace JanaBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;


class AcaoLogService
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

    public function getAcaoPontoPorId($id){
        if(empty($id)){
            return array('error' => true, 'message'=> utf8_encode('Empty Id'));
        }

        if(!is_numeric($id)){
            return array('error' => true, 'message'=> utf8_encode('ID needs to be a Number'));
        }

        $retorno = $this->entityManager->getRepository('JanaBundle:AcaoLog')->findOneById($id);

        return $retorno;
    }
}