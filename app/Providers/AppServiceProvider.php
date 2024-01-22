<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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

         # Register all model observers
         $filesInFolder = File::files(app_path('Observers'));

         foreach ($filesInFolder as $path) {
             $observerClassName = pathinfo($path)['filename'];
             $className = str_replace('Observer', '', $observerClassName);
             $observerClassName = 'App\\Observers\\' . $observerClassName;
             $className = 'App\\Models\\' . $className;
             $className::observe($observerClassName);
         }

        //
        // if(Auth::check() == true){
            View::share('loggedin', Auth::user());

        // }
    }
}
