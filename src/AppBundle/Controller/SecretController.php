<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecretController extends Controller
{
    /**
     * @Route("/secret", name="top secret")
     */
    public function secretAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/secret.html.twig');
    }
}
