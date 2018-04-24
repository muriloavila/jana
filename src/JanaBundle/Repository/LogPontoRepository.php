<?php

namespace JanaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Acl\Exception\Exception;

class LogPontoRepository extends EntityRepository
{
    public function insertLog($log){
        try{
            $this->getEntityManager()->persist($log);
            $this->getEntityManager()->flush();
            return $log;
        }catch (Exception $e){
            return false;
        }
    }
}