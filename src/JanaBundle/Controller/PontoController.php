<?php

namespace JanaBundle\Controller;

use JanaBundle\Entity\Ponto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Acl\Exception\Exception;

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
                return new JsonResponse(['response' => false, 'message' => utf8_encode('Error parsing DateTime')]);
            }
        }

        $em = $this->getDoctrine()->getManager();

        try{
            $tipo_entities = $em->getRepository('JanaBundle:TipoPonto')->findOneBy(array('id' => $tipo));
        }catch (Exception $e){
            return new JsonResponse(['response' => false, 'message' => utf8_encode($e->getMessage())]);
        }

        if($tipo_entities == null){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: not find Tipo')]);
        }

        $ponto = new Ponto();
        $ponto->setDtHrPonto($data);
        $ponto->setTpPonto($tipo_entities);

        try{
            $em->persist($ponto);
            $em->flush();
        }catch (Exception $e){
            return new JsonResponse(['response' => false, 'message' => utf8_encode($e->getMessage())]);
        }

        $logCreate = new LogController($em, $this->container);
        $retorno_log = $logCreate->createLogAction($ponto, 1);

        if(!$retorno_log){
            return new JsonResponse(['response' => 'false', 'message' => utf8_encode('Error: Log cant\'  be created' )]);
        }

        return new JsonResponse(['response' => 'true']);
    }
}
