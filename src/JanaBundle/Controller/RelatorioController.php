<?php

namespace JanaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RelatorioController extends Controller
{
    public function indexAction($name)
    {
        var_dump($name);
        return true;
    }

    public function buscaAction(Request $request, $relatorio = null){
        if(empty($relatorio) || $relatorio == null){
            return new JsonResponse(['response' => false, 'message' => utf8_encode('Error: Relatorio is Empty')], 400);
        }

        $pontoService = $this->get('jana.ponto');

        switch ($relatorio){
            case 1://Relatorio Por Mes e Ano
                $mes = $request->query->get('mes');
                $ano = $request->query->get('ano');

                $retorno = $pontoService->relatorioMes($mes, $ano);

                if(isset($retorno['error'])){
                    return new JsonResponse($retorno, 400);
                }

                $relatorio = $retorno;
            break;
        }
        return new JsonResponse(["resposta" => $relatorio]);
    }
}
