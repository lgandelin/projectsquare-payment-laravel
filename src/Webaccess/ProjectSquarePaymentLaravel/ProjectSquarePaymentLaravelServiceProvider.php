<?php

namespace Webaccess\ProjectSquarePaymentLaravel;

use Laravel\Cashier\Cashier;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use Webaccess\ProjectSquarePayment\Interactors\Administrators\UpdateAdministratorInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Payment\HandleBankCallInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Payment\InitTransactionInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\DebitPlatformsAccountsInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\GetPlatformUsageAmountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformUsersCountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformsStatusesInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\CheckPlatformSlugInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\SignupInteractor;
use Webaccess\ProjectSquarePaymentLaravel\Commands\DebitPlatformsAccounts;
use Webaccess\ProjectSquarePaymentLaravel\Commands\UpdatePlatformsStatuses;
use Webaccess\ProjectSquarePaymentLaravel\Commands\SetNodeAvailable;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentNodeRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Services\DigitalOceanService;
use Webaccess\ProjectSquarePaymentLaravel\Services\LaravelLoggerService;
use Webaccess\ProjectSquarePaymentLaravel\Services\MercanetService;

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

        Cashier::useCurrency('eur', '€');
    }

    public function register()
    {
        App::bind('SignupInteractor', function () {
             return new SignupInteractor(
                 new EloquentPlatformRepository(),
                 new EloquentAdministratorRepository(),
                 new EloquentNodeRepository(),
                 new DigitalOceanService(),
                 new LaravelLoggerService()
             );
        });

        App::bind('CheckPlatformSlugInteractor', function() {
            return new CheckPlatformSlugInteractor(
                new EloquentPlatformRepository(),
                new LaravelLoggerService()
            );
        });

        App::bind('GetPlatformUsageAmountInteractor', function() {
            return new GetPlatformUsageAmountInteractor(
                new EloquentPlatformRepository(),
                new LaravelLoggerService()
            );
        });

        App::bind('UpdatePlatformUsersCountInteractor', function() {
            return new UpdatePlatformUsersCountInteractor(
                new EloquentPlatformRepository(),
                new LaravelLoggerService()
            );
        });

        App::bind('DebitPlatformsAccountsInteractor', function() {
            return new DebitPlatformsAccountsInteractor(
                new EloquentPlatformRepository(),
                new LaravelLoggerService()
            );
        });

        App::bind('HandleBankCallInteractor', function() {
            return new HandleBankCallInteractor(
                new EloquentPlatformRepository(),
                new EloquentTransactionRepository(),
                new MercanetService(),
                new LaravelLoggerService()
            );
        });

        App::bind('UpdatePlatformsStatusesInteractor', function() {
            return new UpdatePlatformsStatusesInteractor(
                new EloquentPlatformRepository(),
                new LaravelLoggerService()
            );
        });

        App::bind('InitTransactionInteractor', function() {
            return new InitTransactionInteractor(
                new EloquentPlatformRepository(),
                new EloquentTransactionRepository(),
                new MercanetService(),
                new LaravelLoggerService()
            );
        });

        App::bind('LaravelLoggerService', function() {
            return new LaravelLoggerService();
        });

        App::bind('UpdateAdministratorInteractor', function() {
            return new UpdateAdministratorInteractor(
                new EloquentAdministratorRepository(),
                new LaravelLoggerService()
            );
        });

        $this->commands([
            SetNodeAvailable::class,
            DebitPlatformsAccounts::class,
            UpdatePlatformsStatuses::class,
        ]);

        App::register(\Barryvdh\DomPDF\ServiceProvider::class);
    }
}
