<?php


namespace JanaBundle\Repository;

use Doctrine\ORM\EntityRepository;


class TipoPontoRepository extends EntityRepository
{
    public function findOneById($id){
        return $this->getEntityManager()->getRepository('JanaBundle:TipoPonto')->findOneBy(array('id' => $id));
    }
}