<?php

namespace JanaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Acl\Exception\Exception;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JanaBundle:Default:index.html.twig', array('name' => $name));
    }

    public function gravaAction($data, $tipo)
    {
        if($data == 'now'){
            $data = new \DateTime();
        }else{
            $data = \DateTime::createFromFormat('Y-m-d H:i:s', $data);
            if($data == false){
                return new JsonResponse(['resposta' => false, 'message' => utf8_encode('Error parsing DateTime')]);
            }
        }



        return new JsonResponse(['resposta' => $data->format('Y-m-d H:i:s')]);
    }
}