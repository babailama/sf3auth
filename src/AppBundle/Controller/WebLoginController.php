<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;



class WebLoginController extends Controller {

    /**
     * @Route("/login", name="login")
     * 
     */
    public function loginAction(Request $request) {

        $authenticationUtils = $this->get('security.authentication_utils');
        $qr = $this->container->get('app.qrcode_routines');
        $token = $qr->generateToken();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $tokenId = $token->getToken();
        return $this->render('default/login.html.twig', array(
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'tokenid' => $tokenId,
                    'url' => 'https://sf3auth-babailama.c9users.io/api?apikey='.$tokenId.'&phone=333222333',
        ));
    }

    /**
     * @Route("/login-image", name="login-image")
     */
    public function loginImageAction(Request $request) {
        // we need to be sure ours script does not output anything!!!
        // otherwise it will break up PNG binary!
        ob_start();
        $tokenId = $request->query->get('tokenid');
        // end of processing here
        $debugLog = ob_get_contents();
        ob_end_clean();
        return \PHPQRCode\QRcode::png($tokenId);
    }

}
