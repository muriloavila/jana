<?php

namespace JanaBundle\Entity;

/**
 * LogPonto
 */
class LogPonto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $logData;

    /**
     * @var string
     */
    private $logIp;

    /**
     * @var \JanaBundle\Entity\AcaoLog
     */
    private $idAcao;

    /**
     * @var \JanaBundle\Entity\Ponto
     */
    private $idPonto;


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
     * Set logData
     *
     * @param \DateTime $logData
     *
     * @return LogPonto
     */
    public function setLogData($logData)
    {
        $this->logData = $logData;

        return $this;
    }

    /**
     * Get logData
     *
     * @return \DateTime
     */
    public function getLogData()
    {
        return $this->logData;
    }

    /**
     * Set logIp
     *
     * @param string $logIp
     *
     * @return LogPonto
     */
    public function setLogIp($logIp)
    {
        $this->logIp = $logIp;

        return $this;
    }

    /**
     * Get logIp
     *
     * @return string
     */
    public function getLogIp()
    {
        return $this->logIp;
    }

    /**
     * Set idAcao
     *
     * @param \JanaBundle\Entity\AcaoLog $idAcao
     *
     * @return LogPonto
     */
    public function setIdAcao(\JanaBundle\Entity\AcaoLog $idAcao = null)
    {
        $this->idAcao = $idAcao;

        return $this;
    }

    /**
     * Get idAcao
     *
     * @return \JanaBundle\Entity\AcaoLog
     */
    public function getIdAcao()
    {
        return $this->idAcao;
    }

    /**
     * Set idPonto
     *
     * @param \JanaBundle\Entity\Ponto $idPonto
     *
     * @return LogPonto
     */
    public function setIdPonto(\JanaBundle\Entity\Ponto $idPonto = null)
    {
        $this->idPonto = $idPonto;

        return $this;
    }

    /**
     * Get idPonto
     *
     * @return \JanaBundle\Entity\Ponto
     */
    public function getIdPonto()
    {
        return $this->idPonto;
    }
}

