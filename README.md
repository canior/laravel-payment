# Moneris payment integration with Laravel and Doctrine 

build a small Larvel service for payment integration with Moneris.

for demo purpose 

a restful api is included:

```
curl --header "Content-Type: application/json" --request POST --data '{"customerId":"1","amount":"1.00"}' http://127.0.0.1:8000/api/customers/purchase
```

Assumptions:

```
- user has many gateway options, moneris is a valid option, user has many customers
- customer belongs to user
- customer makes purchase action and a transaction is created
```


## Getting Started

This project is for demo purpose, and technologies involve:

 ```
 php framework: laravel

 third party components: laravel-doctrine, moneris 

 orm framework: doctrine orm 

 phpunit: demonstrate functional test, web test with test database
 ```

## Design

Database design:

```
users: user info with payment gateway option and config (for now only moneris is supported)
customers: users' customers with credit card info (for now, each customer has one credit card)
transactions: customer payment transactions
```

Layer Pattern:

```
1. api requests bind in JsonRequest for data validation
2. controller: handles data validation and required service
3. service: handle business logic
4. repository: handle database related work 
5. entity: orm models
```

Payment gateway integration:

```
PaymentGatewayService: handle payment actions, for now only purchase action is supported
PaymentGatewayService: handle all third party payment gateway integration
GatewayPaymentRequest: dto for thirdparty payment action request (GatewayPurchaseRequest)
GatewayPaymentResponse: dto for thirdparty payment action response (GatewayPurchaseResponse)
```


## Implementation

Moneris integration for purchase action

```
MonerisPaymentServiceImpl (implements PaymentGatewayService): all payment service implementations (purchase, preauth, etc.)
MonerisPurchaseRequest (implements GatewayPaymentRequest): moneris purchase action request
MonerisPurchaseResponse (implements GatewayPaymentResponse): moneris purchase action response
```

New payment gateway integration:

ex. Stripe purchase
```
StripePaymentServiceImpl: implements PaymentGatewayService and handle the integation
StriipePurchaseRequest: implements GatewayPaymentRequest 
StriipePurchaseResponse: implements GatewayPaymentResponse
```

New payment action

ex. Pre-Auth
```
PaymentGatewayService: add new payment action to the inteface
PaymentGatewayServiceImpl: implements the new payment action logic
```


### Installing on unix (ubuntu, mac os, centos, etc.)

Prerequisites

```
php: 7.3 + 
mysql: 5.5+ or postgresql 9.0+
composer: 1.9+
apache: 2.0+
```

Quick run

```
1. cp .env.exmaple to .env
2. replace DATABASE_* to your local setup
3. composer install
4. create database from step 2
5. create data seeds:
   php artisan db:seed
6. create database tables
   php artisan doctrine:schema:create
7. php artisan serve
8. the api endpoint is http://127.0.0.1:8000/customers/purchase
```

## Running the tests

Phpunit is used for functional test and web test

### Unit Test

```
1. CustomerControllerTest: test api endpoints
2. MonerisPaymentServiceTest: test moneris integration
3. PaymentServiceTest: test payment  business logics

Optimization:
CustomerControllerTest is an integration test with database connection 
and it should use another database which can be updated in phpuit.xml

```

### Run Tests

```
php artisan test
```

Result

```
   PASS  Tests\Unit\CustomerControllerTest
  ✓ purchase

   PASS  Tests\Unit\MonerisPaymentServiceTest
  ✓ purchase

   PASS  Tests\Unit\PaymentServiceTest
  ✓ get payment gateway service with valid user
  ✓ get payment gateway service with invalid user
  ✓ process purchase approved
  ✓ process purchase declined
  ✓ process purchase error

   PASS  Tests\Feature\ExampleTest
  ✓ example

  Tests:  8 passed
  Time:   12.08s
```

