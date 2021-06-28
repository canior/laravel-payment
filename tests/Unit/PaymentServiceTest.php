<?php

namespace Tests\Unit;

use App\Commands\PurchaseCommand;
use App\Entities\Customer;
use App\Entities\Transaction;
use App\Entities\User;
use App\Exceptions\NotImplementException;
use App\Exceptions\PaymentGatewayException;
use App\Http\Responses\Payment\Gateway\MonerisPurchaseResponse;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\Implementations\MonerisPaymentServiceImpl;
use App\Services\Implementations\PaymentServiceImpl;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Log;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Services\Implementations\PaymentServiceTestImpl;

class PaymentServiceTest extends TestCase
{
    /**
     * @return void
     * @throws NotImplementException
     */
    public function testGetPaymentGatewayServiceWithValidUser()
    {
        Log::shouldReceive('info')->andReturnTrue();
        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);
        $user->setPaymentGateway(User::PAYMENT_GATEWAY_MONERIS);

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $paymentService = new PaymentServiceImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        $service = $paymentService->getPaymentGatewayService($userId);
        $this->assertTrue($service instanceof MonerisPaymentServiceImpl);
    }

    /**
     * @return void
     */
    public function testGetPaymentGatewayServiceWithInvalidUser()
    {
        Log::shouldReceive('info')->andReturnTrue();
        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);
        $user->setPaymentGateway('stripe');

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $paymentService = new PaymentServiceImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        try {
            $paymentService->getPaymentGatewayService($userId);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof NotImplementException);
        }

        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $paymentService = new PaymentServiceImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        try {
            $paymentService->getPaymentGatewayService($userId);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof NotImplementException);
        }
    }

    public function testProcessPurchaseApproved() {
        Log::shouldReceive('info')->andReturnTrue();
        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);
        $user->setPaymentGateway(User::PAYMENT_GATEWAY_MONERIS);

        $amount = 1.00;
        $customerId = 1;
        $customer  = new Customer();
        $customer->setId($customerId);
        $customer->setUser($user);

        $now = time();

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('persist')->once()->with(Transaction::class)->andReturnUsing(function(Transaction $transaction) {
                $this->assertEquals(Transaction::PENDING, $transaction->getStatus());
            });
            $mock->shouldReceive('persist')->once()->with(Transaction::class)->andReturnUsing(function(Transaction $transaction) {
                $this->assertEquals(Transaction::APPROVED, $transaction->getStatus());
            });
            $mock->shouldReceive('flush')->andReturnTrue();
            $mock->shouldReceive('refresh')->andReturnTrue();
            return $mock;
        });


        $gatewayPurchaseResponse = new MonerisPurchaseResponse();
        $gatewayPurchaseResponse->setResponseCode(49); //Approved

        $paymentService = new PaymentServiceTestImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        $paymentService->setMonerisPurchaseResponse($gatewayPurchaseResponse);

        $purchaseCommand = new PurchaseCommand($customer, $amount);
        $purchaseResponse = $paymentService->processPurchase($purchaseCommand);
        $this->assertEquals($customerId, $purchaseResponse->customerId);
        $this->assertEquals(Transaction::APPROVED, $purchaseResponse->status);
        $this->assertEmpty($purchaseResponse->transactionId);
        $this->assertEquals($now, $purchaseResponse->createdAt);
    }


    public function testProcessPurchaseDeclined() {
        Log::shouldReceive('info')->andReturnTrue();
        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);
        $user->setPaymentGateway(User::PAYMENT_GATEWAY_MONERIS);

        $amount = 1.00;
        $customerId = 1;
        $customer  = new Customer();
        $customer->setId($customerId);
        $customer->setUser($user);

        $now = time();

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('persist')->once()->with(Transaction::class)->andReturnUsing(function(Transaction $transaction) {
                $this->assertEquals(Transaction::PENDING, $transaction->getStatus());
            });
            $mock->shouldReceive('persist')->once()->with(Transaction::class)->andReturnUsing(function(Transaction $transaction) {
                $this->assertEquals(Transaction::DECLINED, $transaction->getStatus());
            });
            $mock->shouldReceive('flush')->andReturnTrue();
            $mock->shouldReceive('refresh')->andReturnTrue();
            return $mock;
        });


        $gatewayPurchaseResponse = new MonerisPurchaseResponse();
        $gatewayPurchaseResponse->setResponseCode(50); //Declined

        $paymentService = new PaymentServiceTestImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        $paymentService->setMonerisPurchaseResponse($gatewayPurchaseResponse);

        $purchaseCommand = new PurchaseCommand($customer, $amount);
        $purchaseResponse = $paymentService->processPurchase($purchaseCommand);
        $this->assertEquals($customerId, $purchaseResponse->customerId);
        $this->assertEquals(Transaction::DECLINED, $purchaseResponse->status);
        $this->assertEmpty($purchaseResponse->transactionId);
        $this->assertEquals($now, $purchaseResponse->createdAt);
    }


    public function testProcessPurchaseError() {
        Log::shouldReceive('info')->andReturnTrue();
        Log::shouldReceive('error')->andReturnTrue();
        $userId = 1;
        /**
         * @var User $user
         */
        $user = new User();
        $user->setId($userId);
        $user->setPaymentGateway(User::PAYMENT_GATEWAY_MONERIS);

        $amount = 1.00;
        $customerId = 1;
        $customer  = new Customer();
        $customer->setId($customerId);
        $customer->setUser($user);

        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = Mockery::mock(EntityManagerInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('persist')->once()->with(Transaction::class)->andReturnUsing(function(Transaction $transaction) {
                $this->assertEquals(Transaction::PENDING, $transaction->getStatus());
            });
            $mock->shouldReceive('flush')->andReturnTrue();
            $mock->shouldReceive('refresh')->andReturnTrue();
            return $mock;
        });


        $gatewayPurchaseResponse = new MonerisPurchaseResponse();

        $paymentService = new PaymentServiceTestImpl($entityManager, $this->mockUserRepository($user), $this->mockTransactionRepository());
        $paymentService->setMonerisPurchaseResponse($gatewayPurchaseResponse);
        $paymentService->setIsThrowException(true);

        $purchaseCommand = new PurchaseCommand($customer, $amount);
        try {
            $paymentService->processPurchase($purchaseCommand);
            $this->assertTrue(false);
        } catch (PaymentGatewayException $e) {
            $this->assertTrue(true);
        }
    }


    /**
     * @param User $user
     * @return UserRepository|MockInterface
     */
    private function mockUserRepository(User $user) {
        return Mockery::mock(UserRepository::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('find')->andReturn($user);
            return $mock;
        });
    }

    /**
     * @return TransactionRepository|MockInterface`
     */
    private function mockTransactionRepository() {
        return Mockery::mock(TransactionRepository::class);;
    }

}
