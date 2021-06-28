<?php


namespace App\Http\Responses\Payment\Gateway;


abstract class GatewayPurchaseResponse extends GatewayPaymentResponse
{
    /**
     * @return boolean
     */
    public abstract function isApproved();
}