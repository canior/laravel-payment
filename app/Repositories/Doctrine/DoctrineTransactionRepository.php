<?php


namespace App\Repositories\Doctrine;


use App\Repositories\TransactionRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineTransactionRepository extends EntityRepository implements TransactionRepository
{
}