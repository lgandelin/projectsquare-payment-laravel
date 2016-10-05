<?php

namespace Webaccess\ProjectSquarePaymentLaravel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use Webaccess\ProjectSquarePayment\Context;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\DebitPlatformsAccountsInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\FundPlatformAccountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\GetPlatformUsageAmountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformUsersCountInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Platforms\UpdatePlatformsStatusesInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\CheckPlatformSlugInteractor;
use Webaccess\ProjectSquarePayment\Interactors\Signup\SignupInteractor;
use Webaccess\ProjectSquarePaymentLaravel\Commands\DebitPlatformsAccounts;
use Webaccess\ProjectSquarePaymentLaravel\Commands\UpdatePlatformsStatuses;
use Webaccess\ProjectSquarePaymentLaravel\Commands\SetNodeAvailable;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentNodeRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Guzzle\GuzzleRemotePlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Services\DigitalOceanService;

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
                 new EloquentAdministratorRepository(),
                 new EloquentNodeRepository(),
                 new DigitalOceanService()
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
                new EloquentPlatformRepository(),
                new GuzzleRemotePlatformRepository(env('API_TOKEN'))
            );
        });

        App::bind('DebitPlatformsAccountsInteractor', function() {
            return new DebitPlatformsAccountsInteractor(
                new EloquentPlatformRepository()
            );
        });

        App::bind('FundPlatformAccountInteractor', function() {
            return new FundPlatformAccountInteractor(
                new EloquentPlatformRepository()
            );
        });

        App::bind('UpdatePlatformsStatusesInteractor', function() {
            return new UpdatePlatformsStatusesInteractor(
                new EloquentPlatformRepository()
            );
        });

        $this->commands([
            SetNodeAvailable::class,
            DebitPlatformsAccounts::class,
            UpdatePlatformsStatuses::class,
        ]);
    }
}
