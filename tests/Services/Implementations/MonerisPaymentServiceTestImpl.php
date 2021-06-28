<?php


namespace Tests\Services\Implementations;


use App\Exceptions\MonerisPaymentException;
use App\Http\Requests\Payment\Gateway\GatewayPurchaseRequest;
use App\Http\Responses\Payment\Gateway\GatewayPurchaseResponse;
use App\Http\Responses\Payment\Gateway\MonerisPurchaseResponse;
use App\Services\Implementations\MonerisPaymentServiceImpl;

class MonerisPaymentServiceTestImpl extends MonerisPaymentServiceImpl
{
    /**
     * @var boolean $isThrowException
     */
    private $isThrowException;


    /**
     * @var MonerisPurchaseResponse
     */
    private $monerisPurchageRespose;

    /**
     * @param GatewayPurchaseRequest $paymentGatewayRequest
     * @return GatewayPurchaseResponse
     * @throws MonerisPaymentException
     */
    public function purchase(GatewayPurchaseRequest $paymentGatewayRequest) {
        if ($this->isThrowException) {
            throw new MonerisPaymentException();
        }
        return $this->getMonerisPurchageRespose();
    }

    /**
     * @return MonerisPurchaseResponse
     */
    public function getMonerisPurchageRespose() {
        return $this->monerisPurchageRespose;
    }

    /**
     * @param MonerisPurchaseResponse $monerisPurchageRespose
     */
    public function setMonerisPurchageRespose(MonerisPurchaseResponse $monerisPurchageRespose) {
        $this->monerisPurchageRespose = $monerisPurchageRespose;
    }

    /**
     * @return bool
     */
    public function isThrowException() {
        return $this->isThrowException;
    }

    /**
     * @param bool $isThrowException
     */
    public function setIsThrowException($isThrowException) {
        $this->isThrowException = $isThrowException;
    }
}