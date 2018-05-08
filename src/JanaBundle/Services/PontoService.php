<?php
namespace JanaBundle\Services;

use Doctrine\ORM\EntityManager;
use JanaBundle\Entity\LogPonto;
use Symfony\Component\DependencyInjection\Container;
use JanaBundle\Entity\Ponto;

class PontoService
{
    /**
     * Container
     *
     */
    protected $container;

    /**
     * entityManager
     */
    protected $entityManager;

    /**
     *
     */
    public function __construct(Container $container, EntityManager $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function getPontoById($id){

        if(empty($id)){
            return array('error' => true, 'message'=> utf8_encode('Empty Id'));
        }

        if(!is_numeric($id)){
            return array('error' => true, 'message'=> utf8_encode('ID needs to be a Number'));
        }

        $retorno = $this->entityManager->getRepository('JanaBundle:Ponto')->findAllById($id);

        return $retorno;
    }

    public function getPontoByDay($day){
        $data_inicio    = $day." 00:00:00";
        $data_final     = $day." 23:59:59";

        $data_inicio = \DateTime::createFromFormat('Y-m-d H:i:s', $data_inicio);
        $data_final  = \DateTime::createFromFormat('Y-m-d H:i:s', $data_final);

        if($data_inicio == false || $data_final == false){
            return ['response' => false, 'message' => utf8_encode('Error parsing DateTime')];
        }

        $pontos = $this->entityManager->getRepository('JanaBundle:Ponto')->findAllByDay($data_inicio, $data_final);

        return $pontos;
    }

    public function setNewPonto($data, $tipo){
        $ponto = new Ponto();
        $ponto->setDtHrPonto($data);
        $ponto->setTpPonto($tipo);


        $retorno = $this->entityManager->getRepository('JanaBundle:Ponto')->insertPonto($ponto);

        if(!($retorno instanceof Ponto)){
            return array('error' => true, 'message' => utf8_encode('Error in persist new Ponto'));
        }


        $log = $this->container->get('jana.log_ponto')->createLog($ponto, 1);

        if(!($log instanceof LogPonto)){
            return array('error' => true, 'message' => utf8_encode('Error in create Log'));
        }
        return true;
    }

    public function delete($ponto){
        if(!($ponto instanceof Ponto)){
            return array('error' => true, 'message' => utf8_encode('Ponto has no value'));
        }

        $retorno = $this->entityManager->getRepository('JanaBundle:Ponto')->removePonto($ponto);

        if(!($retorno instanceof Ponto)){
            return array('error' => true, 'message' => utf8_encode('Error in remove Ponto'));
        }

        $log = $this->container->get('jana.log_ponto')->createLog($ponto, 3);

        if(!($log instanceof LogPonto)){
            return array('error' => true, 'message' => utf8_encode('Error in create Log'));
        }
        return true;
    }

    public function altera(Ponto $ponto, $date, $tipo_id){
        if($date == 'now'){
            $date = new \DateTime();
        }else{
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
            if($date == false){
                return ['response' => false, 'message' => utf8_encode('Error parsing DateTime')];
            }
        }

        $tipo = $this->container->get('jana.tipo_ponto')->getTipoById($tipo_id);

        if(is_array($tipo)){
            return $tipo;
        }

        $ponto->setTpPonto($tipo);
        $ponto->setDtHrPonto($date);

        $retorno = $this->entityManager->getRepository('JanaBundle:Ponto')->updatePonto($ponto);

        if(!($retorno instanceof Ponto)){
            return array('error' => true, 'message' => utf8_encode('Error on Ponto update'));
        }

        $log = $this->container->get('jana.log_ponto')->createLog($ponto, 2);

        if(!($log instanceof LogPonto)){
            return array('error' => true, 'message' => utf8_encode('Error in create Log'));
        }
        return $ponto;
    }

    public function relatorioMes($mes, $ano){
        if(empty($mes) || $mes == null){
            return ['error' => true, 'message' => utf8_encode('Month can\'t be null')];
        }

        if(empty($ano) || $ano == null){
            return ['error' => true, 'message' => utf8_encode('Year can\'t be null')];
        }

        $data_ini = \DateTime::createFromFormat('Y-m-d H:i:s', $ano. '-'. $mes.'-01 00:00:00');
        $data_fim = \DateTime::createFromFormat('Y-m-d H:i:s', $ano.'-'.$mes.'-'.cal_days_in_month(CAL_GREGORIAN, $mes, $ano).' 23:59:59');

        if(!$data_ini || !$data_fim){
            return ['error' => true, 'message' => utf8_encode('Parsing Date Error')];
        }

        $pontos = $this->entityManager->getRepository('JanaBundle:Ponto')->findAllByDay($data_ini, $data_fim);
        $retorno = [];

        $dia = $pontos[0]->getDtHrPonto()->format('Y-m-d');
        foreach ($pontos as $ponto) {
            if($dia != $ponto->getDtHrPonto()->format('Y-m-d')){
                $retorno[$dia]['total'] = $this->calculaTotalDia($dia, $retorno[$dia]);
                $dia = $ponto->getDtHrPonto()->format('Y-m-d');
            }

            $retorno[$dia][$ponto->getTpPonto()->getDescricao()] = $ponto->getDtHrPonto()->format('H:i:s');
        }
        $retorno[$dia]['total_trabalhadas'] = $this->calculaTotalDia($dia, $retorno[$dia]);
        return $retorno;
    }

    public function calculaTotalDia($dia, $pontosDia){
        $retorno = array();
        $horas_necessarias = '08:00:00';

        if(date('w', strtotime($dia)) == 0 || date('w', strtotime($dia)) == 6){
            $horas_necessarias = '00:00:00';
        }

        if(!isset($pontosDia['ENTRADA'])){
            $pontosDia['ENTRADA'] = '00:00:00';
        }

        if(!isset($pontosDia['ALMOCO_IN'])){
            $pontosDia['ALMOCO_IN'] = '00:00:00';
        }

        if(!isset($pontosDia['ALMOCO_OUT'])){
            $pontosDia['ALMOCO_OUT'] = '00:00:00';
        }

        if(!isset($pontosDia['SAIDA'])){
            $pontosDia['SAIDA'] = '00:00:00';
        }
        $entrada_almoco = \DateTime::createFromFormat('H:i:s', $pontosDia['ALMOCO_IN'])->diff(\DateTime::createFromFormat('H:i:s', $pontosDia['ENTRADA']));
        $almoco_saida = \DateTime::createFromFormat('H:i:s', $pontosDia['ALMOCO_OUT'])->diff(\DateTime::createFromFormat('H:i:s', $pontosDia['SAIDA']));


        $horas_trab = \DateTime::createFromFormat('H:i:s', $entrada_almoco->format('%H:%I:%S'))->add($almoco_saida);

        $horas_necessarias = \DateTime::createFromFormat('H:i:s', $horas_necessarias);

        $total_dia = $horas_necessarias->diff($horas_trab)->format('%r%H:%I:%S');

        $retorno['horas_trabalhadas'] = $horas_trab->format('H:i:s');
        $retorno['horas_necessarias'] = $horas_necessarias->format('H:i:s');
        $retorno['total_dia'] = $total_dia;

        return $retorno;
    }
}