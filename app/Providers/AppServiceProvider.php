<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\Farmer_register;
use App\Models\user_register;

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
        View::composer('buyer.*', function ($view) {
            $c_username = Session::get('c_username');
            $user = null;
            if ($c_username) {
                $user = user_register::where('username', $c_username)->first();
            }
            $view->with('user', $user);
        });

        view()->composer('farmer.*', function ($view) {
            $username = Session::get('f_username');
            $user = Farmer_register::where('username', $username)->first();
            $view->with('user', $user);
        });
    }
}
