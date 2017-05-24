<?php

// src/AppBundle/Security/ApiKeyUserProvider.php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\WebUser;

class ApiKeyUserProvider implements UserProviderInterface  {

    private $em;

    function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getUsernameForApiKey($cred) {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        $apikey = $cred['apikey'];
        $phone = $cred['phone'];
        $user = $this->em
                ->getRepository('AppBundle\\Entity\\WebUser')
                ->findOneBy(array('phone' => $phone));

        if (!$user) {
            throw new \InvalidArgumentException(
                    'No user found '
            );
        }
        $username = $user->getUsername();

        return $username;
    }

    public function loadUserByUsername($username) {
        $user = $this->em
                ->getRepository('AppBundle\\Entity\\WebUser')
                ->findOneBy(array('username' => $username));
        return $user;
    }

    public function refreshUser(UserInterface $user) {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        return $user;
    }

    public function supportsClass($class) {
        return WebUser::class === $class;
    }

}
