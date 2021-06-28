<?php

namespace App\Providers;

use App\Entities\Customer;
use App\Entities\Transaction;
use App\Entities\User;
use App\Repositories\CustomerRepository;
use App\Repositories\Doctrine\DoctrineCustomerRepository;
use App\Repositories\Doctrine\DoctrineTransactionRepository;
use App\Repositories\Doctrine\DoctrineUserRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\Implementations\PaymentServiceImpl;
use App\Services\PaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function($app) {
            return new DoctrineUserRepository($app['em'], $app['em']->getClassMetaData(User::class));
        });

        $this->app->bind(CustomerRepository::class, function($app) {
            return new DoctrineCustomerRepository($app['em'], $app['em']->getClassMetaData(Customer::class));
        });

        $this->app->bind(TransactionRepository::class, function($app) {
            return new DoctrineTransactionRepository($app['em'], $app['em']->getClassMetaData(Transaction::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PaymentService::class, function ($app) {
            $doctrineUserRepository = new DoctrineUserRepository($app['em'], $app['em']->getClassMetaData(User::class));
            $doctrineTransactionRepository = new DoctrineTransactionRepository($app['em'], $app['em']->getClassMetaData(Transaction::class));
            return new PaymentServiceImpl($app['em'], $doctrineUserRepository, $doctrineTransactionRepository);
        });

    }
}
