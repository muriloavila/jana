<?php

namespace JanaBundle\Controller;

use JanaBundle\Entity\Ponto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $tipoServices = $this->get('jana.tipo_ponto');
        $tipo_entities = $tipoServices->getTipoById($tipo);

        $pontoService = $this->get('jana.ponto');
        $pontoNew = $pontoService->setNewPonto($data, $tipo_entities);

        if(is_array($pontoNew)){
            return new JsonResponse($pontoNew, 400);
        }

        return new JsonResponse(['response' => true], 200);
    }

    public function buscaAction($tipo = null, $data = null)
    {
        if($data == null){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Data Is Empty')], 400);
        }

        if($tipo ==  null){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Id is Empty')], 400);
        }

        $pontoService = $this->container->get('jana.ponto');

        if(strtoupper($tipo) == "ID"){
            $busca = $pontoService->getPontoById($data);

            return new JsonResponse($busca->toJson());
        }

        if(strtoupper($tipo) == "DAY"){
            $retorno = array();
            $busca = $pontoService->getPontoByDay($data);

            foreach ($busca as $item) {
                $retorno[] = $item->toJson();
            }
            return new JsonResponse($retorno);
        }

    }


    public function alteraAction(Request $request, $id = null)
    {
        if($id == null){
            if($id == null && empty($id)){
                return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Id is Empty')], 400);
            }
        }


        $pontoService = $this->get('jana.ponto');
        $ponto = $pontoService->getPontoById($id);

        if(!$ponto instanceof Ponto){
            return new JsonResponse($ponto, 400);
        }

        $date = $request->query->get('date');
        $tipo_id = $request->query->get('tipo');

        $retorno = $pontoService->altera($ponto, $date, $tipo_id);

        if(!$ponto instanceof Ponto){
            return new JsonResponse($ponto, 400);
        }
        return new JsonResponse(array('response' => true));
    }

    public function deletaAction($id = null)
    {
        if($id == null && empty($id)){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Id is Empty')], 400);
        }

        $pontoService = $this->get('jana.ponto');

        $ponto = $pontoService->getPontoById($id);

        if(!$ponto instanceof Ponto){
            return new JsonResponse($ponto, 400);
        }

        $remove = $pontoService->delete($ponto);

        if(is_array($remove)){
            return new JsonResponse($remove, 400);
        }

        return new JsonResponse(['response' => true, 'id' => $id], 200);
    }
}
