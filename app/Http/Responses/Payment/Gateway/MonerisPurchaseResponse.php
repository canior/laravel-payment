<?php


namespace App\Http\Responses\Payment\Gateway;


class MonerisPurchaseResponse extends GatewayPurchaseResponse
{

    /**
     * @var string|null
     */
    private $cardType;

    /**
     * @var float|null
     */
    private $transAmount;

    /**
     * @var string|null
     */
    private $txnNumber;

    /**
     * @var string|null
     */
    private $receiptId;

    /**
     * @var string|null
     */
    private $transType;

    /**
     * @var string|null
     */
    private $referenceNumber;

    /**
     * @var string|null
     */
    private $responseCode;

    /**
     * @var string|null
     */
    private $iso;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $isVisaDebit;

    /**
     * @var string|null
     */
    private $authCode;

    /**
     * @var string|null
     */
    private $complete;

    /**
     * @var string|null
     */
    private $transDate;

    /**
     * @var string|null
     */
    private $transTime;

    /**
     * @var string|null
     */
    private $ticket;

    /**
     * @var boolean|null
     */
    private $timedOut;

    /**
     * @var string|null
     */
    private $statusCode;

    /**
     * @var string|null
     */
    private $statusMessage;

    /**
     * @var string|null
     */
    private $hostId;

    /**
     * @var string|null
     */
    private $issuerId;

    /**
     * @param \mpgResponse $mpgResponse
     */
    public function init(\mpgResponse $mpgResponse) {
        $this->setCardType($mpgResponse->getCardType());
        $this->setTransAmount($mpgResponse->getTransAmount());
        $this->setTxnNumber($mpgResponse->getTxnNumber());
        $this->setReceiptId($mpgResponse->getReceiptId());
        $this->setTransType($mpgResponse->getTransType());
        $this->setReferenceNumber($mpgResponse->getReferenceNum());
        $this->setResponseCode($mpgResponse->getResponseCode());
        $this->setIso($mpgResponse->getISO());
        $this->setMessage($mpgResponse->getMessage());
        $this->setIsVisaDebit($mpgResponse->getIsVisaDebit());
        $this->setAuthCode($mpgResponse->getAuthCode());
        $this->setComplete($mpgResponse->getComplete());
        $this->setTransDate($mpgResponse->getTransDate());
        $this->setTransTime($mpgResponse->getTransTime());
        $this->setTicket($mpgResponse->getTicket());
        $this->setTimedOut($mpgResponse->getTimedOut());
        $this->setStatusCode($mpgResponse->getStatusCode());
        $this->setStatusMessage($mpgResponse->getStatusMessage());
        $this->setHostId($mpgResponse->getHostId());
        $this->setIssuerId($mpgResponse->getIssuerId());
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
     * @return string|null
     */
    public function getAuthCode() {
        return $this->authCode;
    }

    /**
     * @param string|null $authCode
     */
    public function setAuthCode($authCode) {
        $this->authCode = $authCode;
    }

    /**
     * @return string|null
     */
    public function getComplete() {
        return $this->complete;
    }

    /**
     * @param string|null $complete
     */
    public function setComplete($complete) {
        $this->complete = $complete;
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

    public function isApproved() {
        return !empty($this->getResponseCode()) && (integer) $this->getResponseCode() < 50;
    }

    public function isPurchase() {
        return true;
    }
}