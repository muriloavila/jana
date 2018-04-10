<?php

namespace JanaBundle\Controller;

use Doctrine\ORM\EntityManager;
use JanaBundle\Entity\Ponto;
use JanaBundle\Entity\TipoPonto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;


class PontoController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function gravaAction($data, $tipo)
    {
        if($data == 'now'){
            $data = new \DateTime();
        }else{
            $data = \DateTime::createFromFormat('Y-m-d H:i:s', $data);
            if($data == false){
                return new JsonResponse(['response' => false, 'message' => utf8_encode('Error parsing DateTime')], 400);
            }
        }

        $em = $this->getDoctrine()->getManager();


        $tipo_entities = $this->buscaTipo($tipo, $em);
        if(!$tipo_entities instanceof TipoPonto){
            return new JsonResponse($tipo_entities, 400);
        }

        $ponto = new Ponto();
        $ponto->setDtHrPonto($data);
        $ponto->setTpPonto($tipo_entities);
        $ponto->setAtivo('1');

        try{
            $em->persist($ponto);
            $em->flush();
        }catch (Exception $e){
            return new JsonResponse(['response' => false, 'message' => utf8_encode($e->getMessage())], 500);
        }

        $logCreate = new LogController($em, $this->container);
        $retorno_log = $logCreate->createLogAction($ponto, 1);

        if(!$retorno_log){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Log cant\'  be created' )], 500);
        }

        return new JsonResponse(['response' => true], 200);
    }


    public function deletaAction($id = null)
    {
        if($id == null && empty($id)){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Id is Empty')], 400);
        }

        $em = $this->getDoctrine()->getManager();

        $ponto = $this->buscaPonto($id, $em);

        if(!$ponto instanceof Ponto){
            return new JsonResponse($ponto, 400);
        }


        $em->remove($ponto);
        try{
            $log = new LogController($em, $this->container);
            $log->createLogAction($ponto, 3);

            $em->flush();
        }catch (\Exception $e){
            return new JsonResponse(['response' => false, 'message' => utf8_encode($e->getMessage())], 500);
        }

        return new JsonResponse(['response' => true, 'id' => $id], 200);
    }

    public function alteraAction(Request $request, $id = null)
    {
        if($id == null){
            if($id == null && empty($id)){
                return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Id is Empty')], 400);
            }
        }

        $em = $this->getDoctrine()->getManager();

        $ponto = $this->buscaPonto($id, $em);

        if(!$ponto instanceof Ponto){
            return new JsonResponse($ponto, 400);
        }

        $date = $request->query->get('date');
        $tipo_id = $request->query->get('tipo');


        if($date == 'now'){
            $date = new \DateTime();
        }else{
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
            if($date == false){
                return new JsonResponse(['response' => false, 'message' => utf8_encode('Error parsing DateTime')], 400);
            }
        }


        $tipo = $this->buscaTipo($tipo_id, $em);
        if(!$tipo instanceof TipoPonto){
            return new JsonResponse($tipo, 400);
        }

        $ponto->setDtHrPonto($date);
        $ponto->setTpPonto($tipo);

        $em->persist($ponto);
        $em->flush();

        try{
            $log = new LogController($em, $this->container);
            $log->createLogAction($ponto, 2);

            $em->flush();
        }catch (\Exception $e){
            return new JsonResponse(['response' => false, 'message' => utf8_encode($e->getMessage())], 500);
        }

        return new JsonResponse(array('response' => true));
    }

    public function buscaAction($data = null)
    {
        if($data == null){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Data Is Empty')], 400);
        }

        $data_inicio    = $data." 00:00:00";
        $data_final     = $data." 23:59:59";

        $data_inicio = \DateTime::createFromFormat('Y-m-d H:i:s', $data_inicio);
        $data_final  = \DateTime::createFromFormat('Y-m-d H:i:s', $data_final);

        if($data_inicio == false || $data_final == false){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error parsing DateTime')], 400);
        }

        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();

        $qb->select('c')->from('JanaBundle:Ponto', 'c')->where('c.dtHrPonto BETWEEN :data_inicio AND :data_final')->setParameter('data_inicio', $data_inicio)->setParameter('data_final', $data_final);
        $query = $qb->getQuery()->getScalarResult();


        return new JsonResponse($query);



    }


    private function buscaPonto($id, EntityManager $em){
        try{
            $ponto = $em->getRepository('JanaBundle:Ponto')->findOneBy(array('id' => $id));
        }catch (Exception $e){
            return ['response' => false, 'message' => utf8_encode($e->getMessage())];
        }

        if($ponto == null){
            return ['response' => false, 'message' => utf8_encode('Error: not find Ponto')];
        }

        return $ponto;
    }


    private function buscaTipo($tipo, EntityManager $em){
        try{
            $tipo_entities = $em->getRepository('JanaBundle:TipoPonto')->findOneBy(array('id' => $tipo));
        }catch (Exception $e){
            return ['response' => false, 'message' => utf8_encode($e->getMessage())];
        }

        if($tipo_entities == null){
            return ['response' => false, 'message' => utf8_encode('Error: not find Tipo')];
        }

        return $tipo_entities;
    }
}
