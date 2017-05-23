<?php

// src/AppBundle/Security/ApiKeyUserProvider.php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use AppBundle\Entity\WebUser;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $username = 'admin';

        return $username;
    }

    public function loadUserByUsername($username)
    {
        return new WebUser(
            'admin',
            'admin@ex.com',
            '222333222',
            '$2y$12$3k5gvGwQXF.cM01a8ijizO7oznS6AgK9aOprpLTq9OV5P0SoFDPbO'
        );
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return WebUser::class === $class;
    }
}