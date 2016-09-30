<?php

namespace Webaccess\ProjectSquarePaymentLaravel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use Webaccess\ProjectSquarePayment\Interactors\Platforms\DebitPlatformsAccountsInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\GetPlatformUsageAmountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformUsersCountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\CheckPlatformSlugInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\SignupInteractor;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\EloquentPlatformRepository;

class ProjectSquarePaymentLaravelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $basePath = __DIR__.'/../../';

        include __DIR__.'/Http/routes.php';

        $this->loadViewsFrom($basePath.'resources/views/', 'projectsquare-payment');
        $this->loadTranslationsFrom($basePath.'resources/lang/', 'projectsquare-payment');

        $this->publishes([
            $basePath.'resources/assets/css' => base_path('public/css'),
            $basePath.'resources/assets/js' => base_path('public/js'),
            $basePath.'resources/assets/fonts' => base_path('public/fonts'),
            $basePath.'resources/assets/img' => base_path('public/img'),
        ], 'assets');

        $this->publishes([
            $basePath.'database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    public function register()
    {
        App::bind('SignupInteractor', function () {
             return new SignupInteractor(
                 new EloquentPlatformRepository(),
                 new EloquentAdministratorRepository()
             );
        });

        App::bind('CheckPlatformSlugInteractor', function() {
            return new CheckPlatformSlugInteractor(
                new EloquentPlatformRepository()
            );
        });

        App::bind('GetPlatformUsageAmountInteractor', function() {
            return new GetPlatformUsageAmountInteractor(
                new EloquentPlatformRepository()
            );
        });

        App::bind('UpdatePlatformUsersCountInteractor', function() {
            return new UpdatePlatformUsersCountInteractor(
                new EloquentPlatformRepository()
            );
        });

        App::bind('DebitPlatformsAccountsInteractor', function() {
            return new DebitPlatformsAccountsInteractor(
                new EloquentPlatformRepository()
            );
        });

        $this->commands([
            'Webaccess\ProjectSquarePaymentLaravel\Commands\SetNodeAvailable',
            'Webaccess\ProjectSquarePaymentLaravel\Commands\DebitPlatformsAccounts',
        ]);
    }
}
