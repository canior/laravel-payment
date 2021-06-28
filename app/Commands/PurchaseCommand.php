<?php


namespace App\Commands;


use App\Entities\Customer;

class PurchaseCommand
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var float
     */
    private $amount;

    /**
     * PaymentCommand constructor.
     * @param Customer $customer
     * @param $amount
     */
    public function __construct(Customer $customer, $amount) {
        $this->customer = $customer;
        $this->amount = $amount;
    }

    /**
     * @return Customer
     */
    public function getCustomer() {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer) {
        $this->customer = $customer;
    }

    /**
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

}