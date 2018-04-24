<?php

namespace JanaBundle\Controller;

use Exception;
use JanaBundle\Entity\LogPonto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{
    protected  $entityManager;
    protected $container;

    public function __construct($entityManager, $container) {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


}
