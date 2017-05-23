<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
/**
 * Description of WebUserRepository
 *
 * @author ivanov-av
 */
class WebUserRepository extends EntityRepository implements UserLoaderInterface
{
        public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.phone = :phone')
            ->setParameter('username', $username)
            ->setParameter('phone', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
