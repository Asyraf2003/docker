<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Ppdb;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.page.admin', function ($view) {
        $ppdbCount = Ppdb::where('status', 'baru')->count();
        Paginator::useBootstrapFive(); 
        $view->with('ppdbCount', $ppdbCount);
        });
    }
}
