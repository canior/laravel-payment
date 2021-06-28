<?php


namespace App\Http\Requests\Payment\Gateway;


abstract class GatewayPaymentRequest
{
    /**
     * @return boolean
     */
    public abstract function isPurchase();

    /**
     * @return string
     */
    public function __toString() {
        $stringArray = [];
        foreach (get_object_vars($this) as $prop => $value) {
            $stringArray[] = "$prop=$value";
        }
        return implode(' , ' , $stringArray);
    }
}