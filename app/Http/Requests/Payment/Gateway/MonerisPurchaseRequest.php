<?php


namespace App\Http\Requests\Payment\Gateway;


class MonerisPurchaseRequest extends GatewayPurchaseRequest
{
    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var integer
     */
    private $cryptType;

    /**
     * @var string
     */
    private $dynamicDescriptor;

    /**
     * @var string
     */
    private $paymentIndicator;

    /**
     * @var string
     */
    private $paymentInformation;

    /**
     * @var string
     */
    private $issuerId;

    /**
     * @return string
     */
    public function getPaymentType() {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     */
    public function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }

    /**
     * @return int
     */
    public function getCryptType() {
        return $this->cryptType;
    }

    /**
     * @param int $cryptType
     */
    public function setCryptType($cryptType) {
        $this->cryptType = $cryptType;
    }

    /**
     * @return string
     */
    public function getDynamicDescriptor() {
        return $this->dynamicDescriptor;
    }

    /**
     * @param string $dynamicDescriptor
     */
    public function setDynamicDescriptor($dynamicDescriptor) {
        $this->dynamicDescriptor = $dynamicDescriptor;
    }

    /**
     * @return string
     */
    public function getPaymentIndicator() {
        return $this->paymentIndicator;
    }

    /**
     * @param string $paymentIndicator
     */
    public function setPaymentIndicator($paymentIndicator) {
        $this->paymentIndicator = $paymentIndicator;
    }

    /**
     * @return string
     */
    public function getPaymentInformation() {
        return $this->paymentInformation;
    }

    /**
     * @param string $paymentInformation
     */
    public function setPaymentInformation($paymentInformation) {
        $this->paymentInformation = $paymentInformation;
    }

    /**
     * @return string
     */
    public function getIssuerId() {
        return $this->issuerId;
    }

    /**
     * @param string $issuerId
     */
    public function setIssuerId($issuerId) {
        $this->issuerId = $issuerId;
    }

    /**
     * @return bool
     */
    public function isPurchase() {
        return true;
    }
}