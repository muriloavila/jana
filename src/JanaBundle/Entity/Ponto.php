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
}

