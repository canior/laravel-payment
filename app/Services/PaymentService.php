<?php


namespace App\Services;


use App\Commands\PurchaseCommand;
use App\Http\Responses\Payment\PurchaseResponse;

/**
 * Interface PaymentService
 *
 * @package App\Services
 */
interface PaymentService
{
    /**
     * Get the payment gateway service for user
     *
     * @param integer $userId
     * @return PaymentGatewayService
     */
    function getPaymentGatewayService($userId);

    /**
     * process the purchase command
     *
     * @param PurchaseCommand $paymentCommand
     * @return PurchaseResponse
     */
    function processPurchase(PurchaseCommand $paymentCommand);
}