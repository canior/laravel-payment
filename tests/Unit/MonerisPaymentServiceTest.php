<?php


namespace Tests\Unit;


use App\Entities\Customer;
use App\Entities\PurchaseTransaction;
use App\Entities\User;
use App\Http\Responses\Payment\Gateway\MonerisPurchaseResponse;
use App\Services\Implementations\MonerisPaymentServiceImpl;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;

class MonerisPaymentServiceTest extends TestCase
{
    public function testPurchase() {
        Log::shouldReceive('info')->andReturnTrue();
        Log::shouldReceive('error')->andReturnTrue();

        $storeId = 'store5';
        $apiToken = 'yesguy';
        $countryCode = 'CA';
        $isTest = true;

        $now = time();

        $orderId = $now;
        $amount = '1.00';
        $cardNumber = '4242424242424242';
        $expiryMonth = 11;
        $expiryYear = 20;

        $userId = 1;
        $user = new User();
        $user->setId($userId);

        $customerId = 1;
        $customer = new Customer();
        $customer->setId($customerId);
        $customer->setUser($user);
        $customer->setCardNumber($cardNumber);
        $customer->setCardExpiryMonth($expiryMonth);
        $customer->setCardExpiryYear($expiryYear);


        $transactionId = 1;
        $transaction = new PurchaseTransaction();
        $transaction->setId($transactionId);
        $transaction->setCustomer($customer);
        $transaction->setAmount($amount);
        $transaction->setOrderId($orderId);

        $monerisPaymentService = new MonerisPaymentServiceImpl($storeId, $apiToken, $countryCode, $isTest);
        $paymentGatewayRequest = $monerisPaymentService->createPurchaseRequest($transaction);

        /**
         * @var MonerisPurchaseResponse $monerisPurchaseResponse
         */
        $monerisPurchaseResponse = $monerisPaymentService->purchase($paymentGatewayRequest);

        $this->assertEquals($amount, $monerisPurchaseResponse->getTransAmount());
        $this->assertEquals('false', $monerisPurchaseResponse->getIsVisaDebit());
        $this->assertEquals('true', $monerisPurchaseResponse->getComplete());
        $this->assertEquals('false', $monerisPurchaseResponse->getTimedOut());
        $this->assertEquals('027', $monerisPurchaseResponse->getResponseCode());
        $this->assertEquals('APPROVED           *                    =', $monerisPurchaseResponse->getMessage());
    }
}