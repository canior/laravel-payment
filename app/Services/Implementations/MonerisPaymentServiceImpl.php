<?php


namespace App\Services\Implementations;


use App\Entities\Transaction;
use App\Exceptions\MonerisPaymentException;
use App\Http\Requests\Payment\Gateway\GatewayPurchaseRequest;
use App\Http\Requests\Payment\Gateway\MonerisPurchaseRequest;
use App\Http\Responses\Payment\Gateway\GatewayPurchaseResponse;
use App\Http\Responses\Payment\Gateway\MonerisPurchaseResponse;
use App\Services\PaymentGatewayService;
use CofInfo;
use Illuminate\Support\Facades\Log;
use mpgHttpsPost;
use mpgRequest;
use mpgTransaction;

class MonerisPaymentServiceImpl implements PaymentGatewayService
{
    /**
     * @var string
     */
    private $storeId;

    /**
     * @var string
     */
    private $apiToken;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var boolean
     */
    private $isTest;


    /**
     * MonerisPaymentService constructor.
     * @param $storeId
     * @param $apiToken
     * @param $countryCode
     * @param $isTest
     */
    public function __construct($storeId, $apiToken, $countryCode, $isTest) {
        $this->storeId = $storeId;
        $this->apiToken = $apiToken;
        $this->countryCode = $countryCode;
        $this->isTest = $isTest;
    }


    /**
     * Send Moneris Purchase request and wrap to GatewayPurchasetResponse
     *
     * @param GatewayPurchaseRequest $paymentGatewayRequest
     * @return GatewayPurchaseResponse
     * @throws MonerisPaymentException
     */
    public function purchase(GatewayPurchaseRequest $paymentGatewayRequest) {
        /**
         * @var MonerisPurchaseRequest $monerisPurchaseRequest
         */
        $monerisPurchaseRequest = $paymentGatewayRequest;

        $txnArray = [
            'type' => 'purchase',
            'order_id' => $monerisPurchaseRequest->getOrderId(),
            'cust_id' => $monerisPurchaseRequest->getCustomerId(),
            'amount' => $monerisPurchaseRequest->getAmount(),
            'pan' => $monerisPurchaseRequest->getCardNumber(),
            'expdate' => $monerisPurchaseRequest->getExpiryDate(),
            'crypt_type' => $monerisPurchaseRequest->getCryptType(),
            'dynamic_descriptor' => $monerisPurchaseRequest->getDynamicDescriptor()
        ];

        $mpgTxn = new mpgTransaction($txnArray);
        $cof = new CofInfo();
        $cof->setPaymentIndicator($monerisPurchaseRequest->getPaymentIndicator());
        $cof->setPaymentInformation($monerisPurchaseRequest->getPaymentInformation());
        $cof->setIssuerId("168451306048014");
        $mpgTxn->setCofInfo($cof);

        $mpgRequest = new mpgRequest($mpgTxn);
        $mpgRequest->setProcCountryCode($this->countryCode);
        $mpgRequest->setTestMode((boolean)$this->isTest);

        try {
            $mpgHttpPost = new mpgHttpsPost($this->storeId, $this->apiToken, $mpgRequest);
            Log::info('sent moneris ' . $mpgHttpPost->toXML());

            $mpgResponse = $mpgHttpPost->getMpgResponse();
            Log::info('received moneris ' .  $mpgResponse->getResponseCode() . ' ' . $mpgResponse->getMessage());
        } catch (\Exception $e) {
            Log::error('moneris gateway error',  $e->getTrace());
            throw new MonerisPaymentException();
        }

        $monerisPurchaseResponse = new MonerisPurchaseResponse();
        $monerisPurchaseResponse->init($mpgResponse);
        return $monerisPurchaseResponse;
    }

    /**
     * @inheritDoc
     */
    public function createPurchaseRequest(Transaction $transaction) {

        Log::info('build purchase request for transaction ' . $transaction->getId());

        $customer = $transaction->getCustomer();

        $purchaseRequest = new MonerisPurchaseRequest();
        $purchaseRequest->setCustomerId($customer->getId());
        $purchaseRequest->setAmount(number_format((float)$transaction->getAmount(), 2, '.', ''));
        $purchaseRequest->setPaymentType($transaction->getPaymentType());
        $purchaseRequest->setOrderId($transaction->getOrderId());
        $purchaseRequest->setCardNumber($customer->getCardNumber());
        $purchaseRequest->setExpiryDate($customer->getCardExpiryYYMM());
        $purchaseRequest->setCryptType(7);
        $purchaseRequest->setDynamicDescriptor($customer->getUser()->getName() . '_' . $transaction->getId());
        $purchaseRequest->setPaymentIndicator("U");
        $purchaseRequest->setPaymentInformation($customer->getUser()->getMonerisStoreId());
        $purchaseRequest->setIssuerId($customer->getUser()->getId());

        Log::info ('purchase request is ' . $purchaseRequest->__toString());

        return $purchaseRequest;
    }

    /**
     * @inheritDoc
     */
    public function updatePurchaseTransaction(Transaction $transaction, GatewayPurchaseResponse $gatewayPurchaseResponse) {
        /**
         * @var MonerisPurchaseResponse $monerisPaymentGatewayResponse
         */
        $monerisPaymentGatewayResponse = $gatewayPurchaseResponse;

        $transaction->setUpdatedAt(time());
        $transaction->setStatus($monerisPaymentGatewayResponse->isApproved() ?
            Transaction::APPROVED : Transaction::DECLINED);
        $transaction->setTransAmount($monerisPaymentGatewayResponse->getTransAmount());
        $transaction->setTxnNumber($monerisPaymentGatewayResponse->getTxnNumber());
        $transaction->setReceiptId($monerisPaymentGatewayResponse->getReceiptId());
        $transaction->setTransType($monerisPaymentGatewayResponse->getTransType());
        $transaction->setReferenceNumber($monerisPaymentGatewayResponse->getReferenceNumber());
        $transaction->setResponseCode($monerisPaymentGatewayResponse->getResponseCode());
        $transaction->setIso($monerisPaymentGatewayResponse->getISO());
        $transaction->setMessage($monerisPaymentGatewayResponse->getMessage());
        $transaction->setIsVisaDebit((boolean)($monerisPaymentGatewayResponse->getIsVisaDebit() == 'true'));
        $transaction->setAuthCode($monerisPaymentGatewayResponse->getAuthCode());
        $transaction->setIsComplete($monerisPaymentGatewayResponse->getComplete());
        $transaction->setTransDate($monerisPaymentGatewayResponse->getTransDate());
        $transaction->setTransTime($monerisPaymentGatewayResponse->getTransTime());
        $transaction->setTicket($monerisPaymentGatewayResponse->getTicket());
        $transaction->setTimedOut((boolean)($monerisPaymentGatewayResponse->getTimedOut() == 'true'));
        $transaction->setStatusCode($monerisPaymentGatewayResponse->getStatusCode());
        $transaction->setStatusMessage($monerisPaymentGatewayResponse->getStatusMessage());
        $transaction->setHostId($monerisPaymentGatewayResponse->getHostId());
        $transaction->setIssuerId($monerisPaymentGatewayResponse->getIssuerId());

        return $transaction;
    }
}