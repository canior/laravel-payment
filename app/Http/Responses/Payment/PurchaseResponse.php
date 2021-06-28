<?php


namespace App\Http\Responses\Payment;


use App\Http\Responses\JsonResponse;

class PurchaseResponse implements JsonResponse
{
    /**
     * @var integer
     */
    public $transactionId;

    /**
     * @var integer
     */
    public $customerId;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var float
     */
    public $transAmount;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $message;

    /**
     * @var integer
     */
    public $createdAt;

    /**
     * @var integer
     */
    public $updatedAt;
}