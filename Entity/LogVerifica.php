<?php

namespace Mrapps\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogVerifica
 *
 * @ORM\Table(name="mrapps_mail_log_verifica")
 * @ORM\Entity(repositoryClass="Mrapps\MailBundle\Repository\LogVerificaRepository")
 */
class LogVerifica
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=1000)
     */
    protected $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=1000)
     */
    protected $tipo;
    
    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;


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
     * Set email
     *
     * @param string $email
     * @return LogVerifica
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set tipo
     *
     * @param string $tipo
     * @return LogVerifica
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return LogVerifica
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}