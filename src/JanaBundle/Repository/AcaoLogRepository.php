<?php
namespace JanaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Acl\Exception\Exception;


class AcaoLogRepository extends EntityRepository
{
    public function findOneById($id){
        return $this->getEntityManager()->getRepository('JanaBundle:AcaoLog')->findOneBy(array('id' => $id));
    }
}