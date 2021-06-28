<?php


namespace App\Http\Responses\Payment\Gateway;


abstract class GatewayPaymentResponse
{
    /**
     * @return boolean
     */
    public abstract function isPurchase();
}