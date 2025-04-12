<?php

namespace App\Providers;

use App\Interfaces\ProductInterface;
use App\Interfaces\Interfaces\Category\CategoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Category\CategoryRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
