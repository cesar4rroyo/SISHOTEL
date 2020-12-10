<?php

namespace App\Providers;

use App\Models\OpcionMenu;
use Doctrine\DBAL\Schema\View;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('theme.lte.aside', function ($view) {
            $menus = OpcionMenu::getMenu();
            $view->with('menus', $menus);
        });
        view()->share('theme', 'lte');
    }
}
