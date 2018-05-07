<?php

namespace JanaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RelatorioController extends Controller
{
    public function indexAction($name)
    {
        var_dump($name);
        return true;
    }

    public function buscaAction($relatorio = null){
        return new JsonResponse(["resposta" => $relatorio]);
    }
}
