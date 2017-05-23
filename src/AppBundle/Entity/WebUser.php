<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of WebUser
 *
 * @author ivanov-av
 */
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="webuser")
 */
class WebUser implements UserInterface, EquatableInterface, \Serializable {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $salt;
    /**
     * @ORM\Column(type="string", unique=true )
     */
    private $phone;
    /**
     * @ORM\Column(type="string")
     */
    private $password;

    function __construct($username, $email, $phone, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getPassword() {
        return $this->password;
    }
    
    public function getSalt()
    {   
        return $this->salt;
    }
    public function eraseCredentials()
    {
    }
    public function getUsername()
    {
        return $this->username;
    }
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }
    
    function setSalt($salt) {
        $this->salt = $salt;
    }

        function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof WebUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->phone,
            $this->email,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->phone,
            $this->email,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
