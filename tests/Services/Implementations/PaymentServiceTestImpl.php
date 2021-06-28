<?php

namespace Tests\Services\Implementations;


use App\Http\Responses\Payment\Gateway\MonerisPurchaseResponse;
use App\Services\Implementations\PaymentServiceImpl;

class PaymentServiceTestImpl extends PaymentServiceImpl
{
    /**
     * @var MonerisPurchaseResponse
     */
    private $monerisPurchaseResponse;

    /**
     * @var boolean
     */
    private $isThrowException;

    /**
     * @inheritDoc
     */
    public function getPaymentGatewayService($userId) {
        $monerisPaymentService = new MonerisPaymentServiceTestImpl(null, null, null, null);
        $monerisPaymentService->setMonerisPurchageRespose($this->monerisPurchaseResponse);
        $monerisPaymentService->setIsThrowException($this->isThrowException);
        return $monerisPaymentService;
    }

    /**
     * @return MonerisPurchaseResponse
     */
    public function getMonerisPurchaseResponse() {
        return $this->monerisPurchaseResponse;
    }

    /**
     * @param MonerisPurchaseResponse $monerisPurchaseResponse
     */
    public function setMonerisPurchaseResponse($monerisPurchaseResponse) {
        $this->monerisPurchaseResponse = $monerisPurchaseResponse;
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