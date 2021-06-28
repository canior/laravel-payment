<?php


namespace App\Repositories\Doctrine;


use App\Repositories\CustomerRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineCustomerRepository extends EntityRepository implements CustomerRepository
{
}