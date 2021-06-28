<?php


namespace App\Http\Requests\Payment\Gateway;



abstract class GatewayPurchaseRequest extends GatewayPaymentRequest
{

    /**
     * @var integer
     */
    protected $customerId;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $cardNumber;

    /**
     * @var string
     */
    protected $expiryDate;


    /**
     * @return int
     */
    public function getCustomerId() {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getOrderId() {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
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

    /**
     * @return string
     */
    public function getCardNumber() {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     */
    public function setCardNumber($cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return string
     */
    public function getExpiryDate() {
        return $this->expiryDate;
    }

    /**
     * @param string $expiryDate
     */
    public function setExpiryDate($expiryDate) {
        $this->expiryDate = $expiryDate;
    }
}