<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePayment\Repositories\PlatformRepository;
use Webaccess\ProjectSquarePayment\Requests\Platforms\UpdatePlatformUsersCountRequest;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;

class APIController extends Controller
{
    public function __construct()
    {
        $this->platformRepository = new EloquentPlatformRepository();
        $this->administratorRepository = new EloquentAdministratorRepository();
    }

    public function update_users_count(Request $request)
    {
        try {
            if ($request->token_api != env('API_TOKEN')) {
                app()->make('LaravelLoggerService')->error('Token API invalide', $request->all());
            }

            $platform = $this->platformRepository->getBySlug($request->platform_slug);
            $response = app()->make('UpdatePlatformUsersCountInteractor')->execute(new UpdatePlatformUsersCountRequest([
                'platformID' => $platform->getID(),
                'usersCount' => $request->users_count,
            ]));

            if ($response->success) {
                $user = $this->administratorRepository->getByPlatformID($platform->getID());

                //Si l'utilisateur est déjà inscrit, on met à jour son abonnement
                if ($user->subscription('user')) {
                    $user->subscription('user')->updateQuantity($request->users_count);
                }
            }

            app()->make('LaravelLoggerService')->info('Modification du nombre d\'utilisateurs effectuée avec succès', [
                'platformID' => $platform->getID(),
                'usersCount' => $request->users_count,
            ]);
        } catch (Exception $e) {
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all());
        }
    }
}
