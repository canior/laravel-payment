<?php


namespace App\Services;




use App\Entities\Transaction;
use App\Http\Requests\Payment\Gateway\GatewayPurchaseRequest;
use App\Http\Responses\Payment\Gateway\GatewayPurchaseResponse;


/**
 * Interface PaymentGatewayService
 *
 * When adding a new payment gateway, we need to implement this interface
 *
 * @package App\Services
 */
interface PaymentGatewayService
{
    /**
     * @param Transaction $transaction
     * @return GatewayPurchaseRequest
     */
    function createPurchaseRequest(Transaction $transaction);

    /**
     * @param GatewayPurchaseRequest $paymentGatewayRequest
     * @return GatewayPurchaseResponse
     */
    function purchase(GatewayPurchaseRequest $paymentGatewayRequest);

    /**
     * @param Transaction $transaction
     * @param GatewayPurchaseResponse $gatewayPurchaseResponse
     * @return Transaction
     */
    function updatePurchaseTransaction(Transaction $transaction, GatewayPurchaseResponse $gatewayPurchaseResponse);
}