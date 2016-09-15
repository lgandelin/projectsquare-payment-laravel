<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePayment\Requests\Platforms\CreatePlatformRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\CreatePlatformResponse;

class SignupController extends Controller
{
    public function index(Request $request)
    {
        return view('projectsquare-payment::signup.index', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
        ]);
    }

    public function handler(Request $request)
    {
        $request->flashExcept('administrator_password');

        try {
            $response = app()->make('CreatePlatformInteractor')->execute(new CreatePlatformRequest([
                'name' => $request->agency_name,
                'slug' => $request->url,
                'usersCount' => $request->users_count,
            ]));

            if ($response->success) {
                //Déclencher création plateforme

            } else {
                $request->session()->flash('error', $this->getErrorMessage($response->errorCode));

                //Add logs : all infos + errorCode + date
            }
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::signup.generic_error'));

            //Add logs : all infos + exception message + date
        }

        return redirect()->route('signup');
    }

    private function getErrorMessage($errorCode)
    {
        $errorMessage = null;

        switch ($errorCode) {
            case CreatePlatformResponse::REPOSITORY_CREATION_FAILED:
                $errorMessage = trans('projectsquare-payment::signup.generic_error');
                break;

            case CreatePlatformResponse::PLATFORM_NAME_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.platform_name_required_error');
                break;

            case CreatePlatformResponse::PLATFORM_SLUG_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.platform_slug_required_error');
                break;

            case CreatePlatformResponse::PLATFORM_SLUG_UNAVAILABLE:
                $errorMessage = trans('projectsquare-payment::signup.platform_slug_unavailable_error');
                break;

            case CreatePlatformResponse::PLATFORM_USERS_COUNT_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.platform_users_count_required_error');
                break;

            default:
                $errorMessage = trans('projectsquare-payment::signup.generic_error');
                break;
        }

        return $errorMessage;
    }
}