<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\Medication\MedicationRepository;
use App\Repositories\Medication\MedicationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class); // 1. bind only abstract class(interface) and concert class
        $this->app->bind(MedicationRepositoryInterface::class,MedicationRepository::class);
        // $this->app->bind(CustomerRepository::class); // 2. bind only concert class
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
