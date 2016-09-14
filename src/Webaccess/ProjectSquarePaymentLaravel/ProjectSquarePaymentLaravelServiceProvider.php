<?php

namespace Webaccess\ProjectSquarePaymentLaravel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ProjectSquarePaymentLaravelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $basePath = __DIR__.'/../../';

        include __DIR__.'/Http/routes.php';

        $this->loadViewsFrom($basePath.'resources/views/', 'projectsquare-payment');
        $this->loadTranslationsFrom($basePath.'resources/lang/', 'projectsquare-payment');

        /*$this->publishes([
            $basePath.'resources/assets/css' => base_path('public/css'),
            $basePath.'resources/assets/js' => base_path('public/js'),
            $basePath.'resources/assets/fonts' => base_path('public/fonts'),
            $basePath.'resources/assets/img' => base_path('public/img'),
        ], 'assets');

        $this->publishes([
            $basePath.'database/migrations' => database_path('migrations'),
        ], 'migrations');*/
    }

    public function register()
    {
        /*App::bind('GetClientsInteractor', function () {
             return new GetClientsInteractor(
                 new EloquentClientRepository()
             );
         });*/

        /*$this->commands([
            'Webaccess\ProjectSquareLaravel\Commands\CreateUserCommand',
        ]);*/
    }
}
