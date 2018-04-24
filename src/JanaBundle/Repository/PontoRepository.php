<?php

namespace JanaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PontoRepository extends EntityRepository
{
    public function findAllById($id){
        return $this->getEntityManager()->getRepository('JanaBundle:Ponto')->findOneBy(array('id' => $id));
    }

    public function findAllByDay($data_ini, $data_end){

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c')->from('JanaBundle:Ponto', 'c')->where('c.dtHrPonto BETWEEN :data_inicio AND :data_final')->setParameter('data_inicio', $data_ini)->setParameter('data_final', $data_end);
        return $qb->getQuery()->getResult();
    }
}