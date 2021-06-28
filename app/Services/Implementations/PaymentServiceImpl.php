<?php


namespace App\Services\Implementations;


use App\Commands\PurchaseCommand;
use App\Entities\PurchaseTransaction;
use App\Entities\User;
use App\Exceptions\NotImplementException;
use App\Exceptions\PaymentGatewayException;
use App\Http\Responses\Payment\PurchaseResponse;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Log;

class PaymentServiceImpl implements PaymentService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * PaymentServiceImpl constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                UserRepository $userRepository,
                                TransactionRepository $transactionRepository) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @inheritDoc
     * @throws NotImplementException
     */
    public function getPaymentGatewayService($userId) {
        /**
         * @var User $user
         */
        $user = $this->userRepository->find($userId);
        $paymentGateway = $user->getPaymentGateway();

        if ($paymentGateway == User::PAYMENT_GATEWAY_MONERIS) {
            return new MonerisPaymentServiceImpl($user->getMonerisStoreId(),
                $user->getMonerisApiToken(), $user->getMonerisCountryCode(), $user->getMonerisTestMode());
        }
        throw new NotImplementException();
    }

    /**
     * @inheritDoc
     * @throws PaymentGatewayException
     * @throws NotImplementException
     */
    public function processPurchase(PurchaseCommand $purchaseCommand) {

        $customer = $purchaseCommand->getCustomer();
        $amount = $purchaseCommand->getAmount();

        Log::info('process purchase  for customer ' . $customer->getId() . ' with amount ' . $amount);

        /**
         *  Create a new transaction with pending status
         */
        $transaction = new PurchaseTransaction();
        $transaction->setOrderId(time());
        $transaction->setCustomer($customer);
        $transaction->setAmount($amount);
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        Log::info('new transaction is created ' . $transaction->getId());

        $user = $purchaseCommand->getCustomer()->getUser();
        $userId = $user->getId();
        $paymentGatewayService = $this->getPaymentGatewayService($userId);

        Log::info('gateway used for user ' . $userId . ' is  ' . get_class($paymentGatewayService));


        /**
         *  Send purchase request to gateway
         */
        $purchaseRequest = $paymentGatewayService->createPurchaseRequest($transaction);
        $paymentGatewayResponse = null;
        try {
            $paymentGatewayResponse = $paymentGatewayService->purchase($purchaseRequest);
        } catch (\Exception $e) {
            Log::error('payment gateway has error', $e->getTrace());
            throw new PaymentGatewayException();
        }

        /**
         *  Update transaction with response from gateway
         */
        $this->entityManager->refresh($transaction);
        $transaction = $paymentGatewayService->updatePurchaseTransaction($transaction, $paymentGatewayResponse);
        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        Log::info('transaction is updated ' . $transaction->getId());

        /**
         * Bind transaction to API contract for frontend
         */
        $purchaseResponse = new PurchaseResponse();
        $purchaseResponse->transactionId = $transaction->getId();
        $purchaseResponse->amount = $transaction->getAmount();
        $purchaseResponse->transAmount = $transaction->getTransAmount();
        $purchaseResponse->customerId = $transaction->getCustomer()->getId();
        $purchaseResponse->message = $transaction->getMessage();
        $purchaseResponse->status = $transaction->getStatus();
        $purchaseResponse->createdAt = $transaction->getCreatedAt();
        $purchaseResponse->updatedAt = $transaction->getUpdatedAt();

        return $purchaseResponse;
    }

}