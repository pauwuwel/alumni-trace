<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        View::composer('layout.index', function ($view) {
            $userData = auth()->user();
            if($userData)
            {
                if ($userData->role == 'alumni')
                {
                    if ($userData->alumni->foto !== null)
                    {
                        $pfp = $userData->alumni->foto;
                        $view->with('pfp', $pfp);    
                    }
                    else
                    {
                        $view->with('pfp', null);
                    }
                }
                elseif ($userData->role == 'admin')
                {
                    if ($userData->admin->foto !== null)
                    {
                        $pfp = $userData->admin->foto;
                        $view->with('pfp', $pfp);    
                    }
                    else
                    {
                        $view->with('pfp', null);
                    }
                }
                elseif ($userData->role == 'superAdmin')
                {
                    if ($userData->superAdmin->foto !== null)
                    {
                        $pfp = $userData->superAdmin->foto;
                        $view->with('pfp', $pfp);    
                    }
                    else
                    {
                        $view->with('pfp', null);
                    }
                }
            }
        });
    }
}
