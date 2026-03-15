<?php

namespace App\Providers;

use App\Interfaces\CompanyInterface;
use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
         $this->app->bind(
            CompanyInterface::class,
            CompanyRepository::class
        );
        
        // Services (sin interfaces, pero con binding name para Facades)
        $this->app->bind('company.service', function ($app) {
            return new CompanyService(
                $app->make(CompanyInterface::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
