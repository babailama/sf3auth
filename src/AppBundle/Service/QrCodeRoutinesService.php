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
        //$em = $this->get('doctrine.orm.default_entity_manager');
        $qb = $this->em->createQueryBuilder();
        $qb->delete('QrToken', 'q');
        $qb->where('q.create_at = :create_at');
        $qb->setParameter('create_at', new \DateTime('-' . $secondsago . ' second'), \Doctrine\DBAL\Types\Type::DATETIME);
        $qb->execute();
        $$this->em->flush();
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
    
    public function populateToken($tokenId, $phone, $sessionid) {
        $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('token' => $tokenId));
        $token->setPhone($phone);
        $token->setSessionid($sessionid);
        $this->em->persist($token);
        $this->em->flush();
    }
    
    public function getSessionId($tokenid) {
        $token = $this->em->getRepository('AppBundle\\Entity\\QrToken')->findOneBy(array('token' => $tokenId));
        return $token->getSessionid();
    }
        

}
