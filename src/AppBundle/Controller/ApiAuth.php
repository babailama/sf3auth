<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Description of ApiAuth
 *
 * @author Администратор
 */
class ApiAuth extends Controller {

    //put your code here
    /**
     * @Route("/api", name="api auth")
     * @Route("/api/get", name="api auth get")
     */
    public function apiAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('apiAction');
        $tokenId = $request->query->get('tokenid');
        $phone = $request->query->get('phone');
        $sessionid = $request->cookies->get('PHPSESSID');
        $qr = $this->container->get('app.qrcode_routines');
        $qr->populateToken($tokenId,$phone,$sessionid);
        $response = new Response();
        //$cookie = new Cookie('PHPSESSID','5kelut2lsl8hvf7oac9n06njt1');
        //$response->headers->setCookie($cookie);
        return $this->render('default/api.get.html.twig',['phpsessid' => $sessionid,],$response);
    }
    
   /**
     * @Route("/qrcode", name="qrcode")
     */
    public function qrcodeAction(Request $request) {
        $tokenId = $request->query->get('tokenid');
        $response = new Response();
        $response->setContent(json_encode(array('auth' => 'OK',)));
        $response->headers->set('Content-Type', 'application/json');
        $qr = $this->container->get('app.qrcode_routines');
        $sessionid = $qr->getSessionid();
        $cookie = new Cookie('PHPSESSID',$sessionid);
        $response->headers->setCookie($cookie);
        return $response;
    }
}
