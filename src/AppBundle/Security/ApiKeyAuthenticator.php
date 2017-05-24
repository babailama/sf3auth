<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * Description of ApiKeyAuthenticator
 *
 * @author ivanov-av
 */
class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface {

    public function createToken(Request $request, $providerKey) {

        // look for an apikey query parameter
        $apiKey = $request->query->get('apikey');
        $phone = $request->query->get('phone');

        // or if you want to use an "apikey" header, then do something like this:
        // $apiKey = $request->headers->get('apikey');

        if (!$apiKey || !$phone) {
            throw new BadCredentialsException();

            // or to just skip api key authentication
            // return null;
        }

        return new PreAuthenticatedToken(
                'anon.',array('apiKey' => $apiKey, 'phone' => $phone), $providerKey
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey) {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
            sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).', get_class($userProvider)
            )
            );
        }

        $cred = $token->getCredentials();
        $username = $userProvider->getUsernameForApiKey($cred);

        // User is the Entity which represents your user
        $user = $token->getUser();
        if ($user instanceof User) {
            return new PreAuthenticatedToken(
                    $user, array('apiKey' => $cred['apiKey'], 'phone' => $cred['phone']), $providerKey, $user->getRoles()
            );
        }

        if (!$username) {
            // this message will be returned to the client
            throw new CustomUserMessageAuthenticationException(
            sprintf('API Key "%s" does not exist.', $apiKey)
            );
        }

        $user = $userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken(
                $user, array('apiKey' => $cred['apiKey'], 'phone' => $cred['phone']), $providerKey, $user->getRoles()
        );
    }

}
