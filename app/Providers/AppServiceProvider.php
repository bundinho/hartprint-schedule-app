<?php

namespace App\Providers;

use App\Repositories\EloquentOrderRepository;
use App\Repositories\EloquentProductRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\Calculator\DefaultSortCalculator;
use App\Services\Contract\OrderService;
use App\Services\Contract\SchedulerService;
use App\Services\Contract\SortCalculator;
use App\Services\EloquentOrderService;
use App\Services\EloquentSchedulerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SchedulerService::class, EloquentSchedulerService::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderService::class, EloquentOrderService::class);
        $this->app
            ->when(EloquentSchedulerService::class)
            ->needs(SortCalculator::class)
            ->give(DefaultSortCalculator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
