<?php

namespace Mrapps\MailBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/** @MongoDB\Document(collection="mrapps_mail_log_verifica") */
class LogVerifica
{
    /** @MongoDB\Id */
    protected $id;

    /** @MongoDB\Field(type="string") */
    protected $email;
    
    /** @MongoDB\Field(type="string") */
    protected $tipo;
    
    /** @MongoDB\Field(type="string") */
    protected $tipo_bounce;
    
    /** @MongoDB\Field(type="date") @MongoDB\Index(order="asc") */
    protected $created_at;
    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string $tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * Set tipo_bounce
     *
     * @param string $tipo_bounce
     * @return self
     */
    public function setTipoBounce($tipo_bounce)
    {
        $this->tipo_bounce = $tipo_bounce;
        return $this;
    }

    /**
     * Get tipo_bounce
     *
     * @return string $tipo_bounce
     */
    public function getTipoBounce()
    {
        return $this->tipo_bounce;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
