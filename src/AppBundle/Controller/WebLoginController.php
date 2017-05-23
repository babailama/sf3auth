<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class WebLoginController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     * 
     */
    public function loginAction(Request $request) {
        
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
        ));
    }
    
     /**
     * @Route("/login-image", name="login-image")
     */
    public function loginImageAction() {
        // we need to be sure ours script does not output anything!!!
        // otherwise it will break up PNG binary!

        ob_start();

        // here DB request or some processing
        $codeText = date('l jS \of F Y h:i:s A');

        // end of processing here
        $debugLog = ob_get_contents();
        ob_end_clean();
        return \PHPQRCode\QRcode::png($codeText);
    }

}
