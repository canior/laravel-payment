<?php

namespace App\Http\Controllers;

use App\Commands\PurchaseCommand;
use App\Entities\Customer;
use App\Exceptions\IllegalArgumentException;
use App\Http\Requests\Payment\PurchaseRequest;
use App\Repositories\CustomerRepository;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{
    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepository
     * @param PaymentService $paymentService
     */
    public function __construct(CustomerRepository $customerRepository, PaymentService $paymentService) {
        $this->customerRepository = $customerRepository;
        $this->paymentService = $paymentService;
    }

    /**
     * @param PurchaseRequest $request
     * @return JsonResponse
     * @throws IllegalArgumentException
     */
    public function purchase(PurchaseRequest $request) {

        $customerId = $request->input('customerId');
        $amount = $request->input('amount');

        Log::info('received purchase request customer id ' . $customerId . ', amount ' . $amount);

        /**
         * @var Customer $customer
         */
        $customer = $this->customerRepository->find($customerId);

        if (is_null($customer)) {
            Log::warning('invalid customer ' . $customerId);
            throw new IllegalArgumentException();
        }

        if (is_null($customer->getCardNumber()) || is_null($customer->getCardHolder())
        || is_null($customer->getCardExpiryMonth()) || is_null($customer->getCardExpiryYear())) {
            Log::warning('invalid customer credit card info ' . $customerId);
            throw new IllegalArgumentException();
        }


        $purchaseResponse = $this->paymentService->processPurchase(new PurchaseCommand($customer, $amount));
        return response()->json((array)$purchaseResponse);
    }
}
