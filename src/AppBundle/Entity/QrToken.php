<?php

namespace AppBundle\Entity;

/**
 * Description of WebUser
 *
 * @author ivanov-av
 */
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Description of QrToken
 *
 * /**
 * @ORM\Entity
 * @ORM\Table(name="qrtoken")
 *
 * @author ivanov-av
 */
class QrToken {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", unique=true )
     */
    private $token;
    
    /**
     * @ORM\Column(type="string", unique=true, nullable=true )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true )
     */
    private $sessionid;
    
    /**
     * @ORM\Column(name="created_at", type="datetime",  nullable=true)
     */
    private $created_at;
    
    function getId() {
        return $this->id;
    }

    function getToken() {
        return $this->token;
    }

    function getPhone() {
        return $this->phone;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }
    function getSessionid() {
        return $this->sessionid;
    }

    function setSessionid($sessionid) {
        $this->sessionid = $sessionid;
    }

 }
