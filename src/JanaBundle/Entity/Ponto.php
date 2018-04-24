<?php

namespace JanaBundle\Entity;

/**
 * Ponto
 */
class Ponto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dtHrPonto;

    /**
     * @var \JanaBundle\Entity\TipoPonto
     */
    private $tpPonto;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dtHrPonto
     *
     * @param \DateTime $dtHrPonto
     *
     * @return Ponto
     */
    public function setDtHrPonto($dtHrPonto)
    {
        $this->dtHrPonto = $dtHrPonto;

        return $this;
    }

    /**
     * Get dtHrPonto
     *
     * @return \DateTime
     */
    public function getDtHrPonto()
    {
        return $this->dtHrPonto;
    }

    /**
     * Set tpPonto
     *
     * @param \JanaBundle\Entity\TipoPonto $tpPonto
     *
     * @return Ponto
     */
    public function setTpPonto(\JanaBundle\Entity\TipoPonto $tpPonto = null)
    {
        $this->tpPonto = $tpPonto;

        return $this;
    }

    /**
     * Get tpPonto
     *
     * @return \JanaBundle\Entity\TipoPonto
     */
    public function getTpPonto()
    {
        return $this->tpPonto;
    }
    /**
     * @var string
     */
    private $ativo;


    /**
     * Set ativo
     *
     * @param string $ativo
     *
     * @return Ponto
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return string
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    public function __toString() {
        return (string) $this->id;
    }

    public function toJson(){
        return array(
            'id' => $this->id,
            'tipo' => $this->getTpPonto()->getDescricao(),
            'DataHr' => $this->getDtHrPonto()->format('d/m/Y H:i:s')
        );
    }
}
