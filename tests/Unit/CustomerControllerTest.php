<?php


namespace Tests\Unit;


use App\Entities\Customer;
use App\Entities\Transaction;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    /**
     * Test with penny
     * https://developer.moneris.com/More/Testing/Penny%20Value%20Simulator
     */
    public function testPurchase() {
        Log::shouldReceive('info')->andReturnTrue();
        Log::shouldReceive('error')->andReturnTrue();
        Log::shouldReceive('warning')->andReturnTrue();

        $invalidCustomerId = $this->createInvalidCustomer();
        $amount = 1;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => $invalidCustomerId, 'amount' => $amount]);
        $responseArray = json_decode($response->getContent(), true);
        $response->assertStatus(500);
        $this->assertEquals('internal error', $responseArray['errors']);

        $amount = 1;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => -1, 'amount' => $amount]);
        $responseArray = json_decode($response->getContent(), true);
        $response->assertStatus(400);
        $this->assertEquals('The customer id must be greater than 0.', $responseArray['errors']['customerId'][0]);

        $customerId = $this->createCustomer();
        $amount = -1;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => $customerId, 'amount' => $amount]);
        $response->assertStatus(400);

        $amount = 1;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => $customerId, 'amount' => $amount]);
        $responseArray = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertEquals(Transaction::APPROVED, $responseArray['status']);
        $this->assertEquals($amount, $responseArray['amount']);
        $this->assertEquals('APPROVED           *                    =', $responseArray['message']);

        $amount = 0.05;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => $customerId, 'amount' => $amount]);
        $responseArray = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertEquals(Transaction::DECLINED, $responseArray['status']);
        $this->assertEquals($amount, $responseArray['amount']);
        $this->assertEquals('DECLINED           *                    =', $responseArray['message']);

        $amount = 0.07;
        $response = $this->postJson('/api/customers/purchase', ['customerId' => $customerId, 'amount' => $amount]);
        $responseArray = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertEquals(Transaction::DECLINED, $responseArray['status']);
        $this->assertEquals($amount, $responseArray['amount']);
        $this->assertEquals('HOLD CARD          * CALL               =', $responseArray['message']);
    }

    private function createCustomer() {
        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = app()->get('em');


        $user = new User();
        $user->setName('test');
        $user->setPaymentGateway('moneris');
        $user->setMonerisStoreId('store5');
        $user->setMonerisApiToken('yesguy');
        $user->setMonerisCountryCode('CA');
        $user->setMonerisTestMode(true);
        $entityManager->persist($user);
        $entityManager->flush();

        $customer = new Customer();
        $customer->setUser($user);
        $customer->setCardHolder('test');
        $customer->setCardNumber('4242424242424242');
        $customer->setCardExpiryYear(20);
        $customer->setCardExpiryMonth(11);
        $entityManager->persist($customer);
        $entityManager->flush();

        return $customer->getId();
    }

    private function createInvalidCustomer() {
        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = app()->get('em');


        $user = new User();
        $user->setName('test');
        $user->setPaymentGateway('moneris');
        $user->setMonerisStoreId('store5');
        $user->setMonerisApiToken('yesguy');
        $user->setMonerisCountryCode('CA');
        $user->setMonerisTestMode(true);
        $entityManager->persist($user);
        $entityManager->flush();

        $customer = new Customer();
        $customer->setUser($user);
        $customer->setCardHolder('test');
        $entityManager->persist($customer);
        $entityManager->flush();

        return $customer->getId();
    }
}