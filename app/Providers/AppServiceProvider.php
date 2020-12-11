<?php

namespace App\Providers;

use App\Models\GrupoMenu;
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
            $opciones = OpcionMenu::getMenu();
            $view->with('opciones', $opciones);
        });
        view()->composer('theme.lte.aside', function ($view) {
            $grupos = GrupoMenu::get()->toArray();
            $view->with('grupos', $grupos);
        });
        view()->share('theme', 'lte');
    }
}
