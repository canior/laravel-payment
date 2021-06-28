<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PurchaseTransaction
 * @package App\Entities
 * @ORM\Entity
 */
class PurchaseTransaction extends Transaction
{
    public function getPaymentType() {
        return Transaction::PURCHASE;
    }
}