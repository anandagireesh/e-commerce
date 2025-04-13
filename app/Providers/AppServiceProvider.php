<?php

namespace App\Providers;

use App\Interfaces\ProductInterface;
use App\Interfaces\Category\CategoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
