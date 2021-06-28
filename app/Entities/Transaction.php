<?php


namespace App\Entities;


use App\Entities\Traits\CreatedAtTrait;
use App\Entities\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transactions")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"purchase" = "PurchaseTransaction"})
 */
abstract class Transaction
{
    const PENDING = 'PENDING';
    const APPROVED = 'APPROVED';
    const DECLINED = 'DECLINED';

    const PURCHASE = 'PURCHASE';

    use CreatedAtTrait;
    use UpdatedAtTrait;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="Customer", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;


    /**
     * @var string
     * @ORM\Column(name="order_id", type="string", nullable=false)
     */
    private $orderId;


    /**
     * @var float
     * @ORM\Column(name="amount", type="decimal", scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;

    /**
     * @var string|null
     * @ORM\Column(name="card_type", type="string", nullable=true)
     */
    private $cardType;

    /**
     * @var float|null
     * @ORM\Column(name="trans_amount", type="decimal", scale=2, nullable=true)
     */
    private $transAmount;

    /**
     * @var string|null
     * @ORM\Column(name="txn_number", type="string", nullable=true)
     */
    private $txnNumber;

    /**
     * @var string|null
     * @ORM\Column(name="receipt_id", type="string", nullable=true)
     */
    private $receiptId;

    /**
     * @var string|null
     * @ORM\Column(name="trans_type", type="string", nullable=true)
     */
    private $transType;

    /**
     * @var string|null
     * @ORM\Column(name="reference_number", type="string", nullable=true)
     */
    private $referenceNumber;

    /**
     * @var string|null
     * @ORM\Column(name="response_code", type="string", nullable=true)
     */
    private $responseCode;

    /**
     * @var string|null
     * @ORM\Column(name="iso", type="string", nullable=true)
     */
    private $iso;

    /**
     * @var string|null
     * @ORM\Column(name="message", type="string", nullable=true)
     */
    private $message;

    /**
     * @var boolean|null
     * @ORM\Column(name="is_visa_debit", type="boolean", nullable=true)
     */
    private $isVisaDebit;

    /**
     * @var integer|null
     * @ORM\Column(name="auth_code", type="string", nullable=true)
     */
    private $authCode;

    /**
     * @var boolean|null
     * @ORM\Column(name="is_complete", type="boolean", nullable=true)
     */
    private $isComplete;

    /**
     * @var string|null
     * @ORM\Column(name="trans_date", type="string", nullable=true)
     */
    private $transDate;

    /**
     * @var string|null
     * @ORM\Column(name="trans_time", type="string", nullable=true)
     */
    private $transTime;

    /**
     * @var string|null
     * @ORM\Column(name="ticket", type="string", nullable=true)
     */
    private $ticket;

    /**
     * @var boolean|null
     * @ORM\Column(name="time_out", type="boolean", nullable=true)
     */
    private $timedOut;

    /**
     * @var string|null
     * @ORM\Column(name="status_code", type="string", nullable=true)
     */
    private $statusCode;

    /**
     * @var string|null
     * @ORM\Column(name="status_message", type="string", nullable=true)
     */
    private $statusMessage;

    /**
     * @var string|null
     * @ORM\Column(name="host_id", type="string", nullable=true)
     */
    private $hostId;

    /**
     * @var string|null
     * @ORM\Column(name="isssuer_id", type="string", nullable=true)
     */
    private $issuerId;


    public function __construct() {
        $now = time();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->setStatus(self::PENDING);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return Customer
     */
    public function getCustomer() {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer) {
        $this->customer = $customer;
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
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getCardType() {
        return $this->cardType;
    }

    /**
     * @param string|null $cardType
     */
    public function setCardType($cardType) {
        $this->cardType = $cardType;
    }

    /**
     * @return float|null
     */
    public function getTransAmount() {
        return $this->transAmount;
    }

    /**
     * @param float|null $transAmount
     */
    public function setTransAmount($transAmount) {
        $this->transAmount = $transAmount;
    }

    /**
     * @return string|null
     */
    public function getTxnNumber() {
        return $this->txnNumber;
    }

    /**
     * @param string|null $txnNumber
     */
    public function setTxnNumber($txnNumber) {
        $this->txnNumber = $txnNumber;
    }

    /**
     * @return string|null
     */
    public function getReceiptId() {
        return $this->receiptId;
    }

    /**
     * @param string|null $receiptId
     */
    public function setReceiptId($receiptId) {
        $this->receiptId = $receiptId;
    }

    /**
     * @return string|null
     */
    public function getTransType() {
        return $this->transType;
    }

    /**
     * @param string|null $transType
     */
    public function setTransType($transType) {
        $this->transType = $transType;
    }

    /**
     * @return string|null
     */
    public function getReferenceNumber() {
        return $this->referenceNumber;
    }

    /**
     * @param string|null $referenceNumber
     */
    public function setReferenceNumber($referenceNumber) {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * @return string|null
     */
    public function getResponseCode() {
        return $this->responseCode;
    }

    /**
     * @param string|null $responseCode
     */
    public function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    /**
     * @return string|null
     */
    public function getIso() {
        return $this->iso;
    }

    /**
     * @param string|null $iso
     */
    public function setIso($iso) {
        $this->iso = $iso;
    }

    /**
     * @return string|null
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getIsVisaDebit() {
        return $this->isVisaDebit;
    }

    /**
     * @param string|null $isVisaDebit
     */
    public function setIsVisaDebit($isVisaDebit) {
        $this->isVisaDebit = $isVisaDebit;
    }

    /**
     * @return integer|null
     */
    public function getAuthCode() {
        return $this->authCode;
    }

    /**
     * @param integer|null $authCode
     */
    public function setAuthCode($authCode) {
        $this->authCode = $authCode;
    }

    /**
     * @return bool|null
     */
    public function getIsComplete() {
        return $this->isComplete;
    }

    /**
     * @param bool|null $isComplete
     */
    public function setIsComplete($isComplete) {
        $this->isComplete = $isComplete;
    }

    /**
     * @return string|null
     */
    public function getTransDate() {
        return $this->transDate;
    }

    /**
     * @param string|null $transDate
     */
    public function setTransDate($transDate) {
        $this->transDate = $transDate;
    }

    /**
     * @return string|null
     */
    public function getTransTime() {
        return $this->transTime;
    }

    /**
     * @param string|null $transTime
     */
    public function setTransTime($transTime) {
        $this->transTime = $transTime;
    }

    /**
     * @return string|null
     */
    public function getTicket() {
        return $this->ticket;
    }

    /**
     * @param string|null $ticket
     */
    public function setTicket($ticket) {
        $this->ticket = $ticket;
    }

    /**
     * @return bool|null
     */
    public function getTimedOut() {
        return $this->timedOut;
    }

    /**
     * @param bool|null $timedOut
     */
    public function setTimedOut($timedOut) {
        $this->timedOut = $timedOut;
    }

    /**
     * @return string|null
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param string|null $statusCode
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string|null
     */
    public function getStatusMessage() {
        return $this->statusMessage;
    }

    /**
     * @param string|null $statusMessage
     */
    public function setStatusMessage($statusMessage) {
        $this->statusMessage = $statusMessage;
    }

    /**
     * @return string|null
     */
    public function getHostId() {
        return $this->hostId;
    }

    /**
     * @param string|null $hostId
     */
    public function setHostId($hostId) {
        $this->hostId = $hostId;
    }

    /**
     * @return string|null
     */
    public function getIssuerId() {
        return $this->issuerId;
    }

    /**
     * @param string|null $issuerId
     */
    public function setIssuerId($issuerId) {
        $this->issuerId = $issuerId;
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
     * @return string
     */
    public abstract function getPaymentType();

}