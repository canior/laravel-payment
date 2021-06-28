<?php


namespace App\Repositories\Doctrine;


use App\Repositories\UserRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
}