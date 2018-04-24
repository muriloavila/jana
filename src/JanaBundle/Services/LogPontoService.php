<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento
 * Date: 24/04/18
 * Time: 13:48
 */

namespace JanaBundle\Services;

use Doctrine\ORM\EntityManager;
use JanaBundle\Entity\LogPonto;
use Symfony\Component\DependencyInjection\Container;


class LogPontoService
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

    public function createLog($ponto, $idAcao)
    {
        $log_acao = $this->container->get('jana.acao_log')->getAcaoPontoPorId($idAcao);

        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $date_log = new \DateTime();
        $log = new LogPonto();
        $log->setIdAcao($log_acao);
        $log->setLogData($date_log);
        $log->setLogIp($ip);
        $log->setIdPonto($ponto);

        $retorno = $this->entityManager->getRepository('JanaBundle:LogPonto')->insertLog($log);

        if(!($retorno instanceof LogPonto)){
            return array('error' => true, 'message' => utf8_encode('Error in persist new Log'));
        }
        return $retorno;
    }
}