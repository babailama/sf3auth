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

/**
 * Description of ApiAuth
 *
 * @author Администратор
 */
class ApiAuth extends Controller {

    //put your code here
    /**
     * @Route("/api", name="api auth")
     */
    public function apiAction(Request $request) {
        //var_dump($request);
//        $response = new Response();
//        $response->setContent(json_encode(array(
//            'data' => 123,
//        )));
//        $response->headers->set('Content-Type', 'application/json');
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

}
