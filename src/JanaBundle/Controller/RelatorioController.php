<?php

namespace JanaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RelatorioController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function buscaAction($relatorio){
        
    }
}
