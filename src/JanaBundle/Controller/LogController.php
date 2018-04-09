<?php

namespace JanaBundle\Controller;

use Exception;
use JanaBundle\Entity\LogPonto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{
    protected  $entityManager;
    protected $container;

    public function __construct($entityManager, $container) {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function createLogAction($ponto, $idAcao)
    {
        $log_acao = $this->entityManager->getRepository('JanaBundle:AcaoLog')->findOneBy(array('id' => $idAcao));
        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $date_log = new \DateTime();

        $log = new LogPonto();
        $log->setIdAcao($log_acao);
        $log->setLogData($date_log);
        $log->setLogIp($ip);
        $log->setIdPonto($ponto);

        try{
            $this->entityManager->persist($log);
            $this->entityManager->flush();

            return true;
        }catch (Exception $e){
            throw new Exception(utf8_encode($e->getMessage()), 1);
        }
    }
}
