<?php

namespace App\Providers;

use App\Repository\ApiTokenRepository;
use App\Repository\CategoryRepository;
use App\Repository\PeriodRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\CategoryRepositoryInterface;
use App\RepositoryInterface\PeriodRepositoryInterface;
use App\RepositoryInterface\TransactionRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ApiTokenRepositoryInterface::class, ApiTokenRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PeriodRepositoryInterface::class, PeriodRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
