<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\QrToken;

/**
 * Description of QrCode RoutinesService
 *
 * @author ivanov-av
 */
class QrCodeRoutinesService extends Controller {

    private $em;

    function __construct(EntityManager $em) {
        $this->em = $em;
    }

    //delete all tokens, old than $secondsago seconds
    public function cleanUp($secondsago = 28800/* 8 hours */) {
        $query = 'DELETE FROM qrtoken WHERE created_at <= NOW() - INTERVAL ' . $secondsago . ' SECOND and phone is null';
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
    }

    public function generateToken() {
        $token = new QrToken();
        $token->setToken(uniqid('', true));
        $token->setCreated_at(new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME);
        //$this->em = $this->getDoctrine()->getManager();
        $this->em->persist($token);
        $this->em->flush();
        return $token;
    }

    public function populateToken($tokenid, $phone, $sessionid) {
        $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('phone' => $phone));
        if ($token) {
            $this->em->remove($token);
        }
        $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('token' => $tokenid));
        $token->setPhone($phone);
        $token->setSessionid($sessionid);
        $this->em->persist($token);
        $this->em->flush();
    }

    public function getSessionId($tokenid) {
        $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('token' => $tokenid));
        return $token->getSessionid();
    }

    public function deleteSession($tokenid) {
        $token = $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('token' => $tokenid));
        $this->em->remove($token);
        $this->em->flush();
    }

}
