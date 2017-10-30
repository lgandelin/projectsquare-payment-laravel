<?php

namespace Webaccess\ProjectSquarePaymentLaravel;

use Illuminate\Routing\Router;
use Laravel\Cashier\Cashier;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use Webaccess\ProjectSquarePayment\Interactors\Administrators\UpdateAdministratorInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\GetPlatformUsageAmountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformUsersCountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\CheckPlatformSlugInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\SignupInteractor;
use Webaccess\ProjectSquarePaymentLaravel\Commands\DebitPlatformsAccounts;
use Webaccess\ProjectSquarePaymentLaravel\Commands\UpdatePlatformsStatuses;
use Webaccess\ProjectSquarePaymentLaravel\Commands\SetNodeAvailable;
use Webaccess\ProjectSquarePaymentLaravel\Http\Middlewares\AdministratorMiddleware;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentNodeRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Services\DigitalOceanService;
use Webaccess\ProjectSquarePaymentLaravel\Services\LaravelLoggerService;

class ProjectSquarePaymentLaravelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot(Router $router)
    {
        setlocale(LC_TIME, 'fr_FR.utf8');

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

        $router->aliasMiddleware('administrator', AdministratorMiddleware::class);
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
