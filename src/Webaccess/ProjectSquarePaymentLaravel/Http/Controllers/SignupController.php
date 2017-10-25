<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Webaccess\ProjectSquarePayment\Requests\Signup\SignupRequest;
use Webaccess\ProjectSquarePayment\Responses\Administrators\CreateAdministratorResponse;
use Webaccess\ProjectSquarePayment\Responses\Platforms\CreatePlatformResponse;
use Webaccess\ProjectSquarePayment\Responses\Signup\CheckPlatformSlugResponse;

class SignupController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('projectsquare-payment::signup.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function landing_free_trial(Request $request)
    {
        return view('projectsquare-payment::landing_free_trial.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request)
    {
        $request->flashExcept('administrator_password');

        $errorMessage = null;
        try {
            $response = app()->make('SignupInteractor')->execute(new SignupRequest([
                'platformSlug' => $request->url,
                'platformUsersCount' => 99,
                'platformPlatformMonthlyCost' => env('PLATFORM_MONTHLY_COST'),
                'platformUserMonthlyCost' => env('USER_MONTHLY_COST'),
                'administratorEmail' => $request->email,
                'administratorPassword' => $request->password ? Hash::make($request->password) : null,
            ]));

            if (!$response->success) {
                $errorMessage = $this->getErrorMessage($response->errorCode);
            }

            $request->session()->put('platformID', $response->platformID);
        } catch (Exception $e) {
            $errorMessage = trans('projectsquare-payment::signup.platform_generic_error');
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());
        }

        return response()->json([
            'success' => $response->success,
            'error' => $errorMessage,
            'redirection_url' => route('signup_confirmation')
        ], 200);
    }

    /**
     * @param $errorCode
     * @return string
     */
    private function getErrorMessage($errorCode)
    {
        $errorMessages = [
            CreatePlatformResponse::REPOSITORY_CREATION_FAILED => trans('projectsquare-payment::signup.generic_error'),
            CreatePlatformResponse::PLATFORM_NAME_REQUIRED => trans('projectsquare-payment::signup.platform_name_required_error'),
            CreatePlatformResponse::PLATFORM_SLUG_REQUIRED => trans('projectsquare-payment::signup.platform_slug_required_error'),
            CheckPlatformSlugResponse::PLATFORM_SLUG_UNAVAILABLE => trans('projectsquare-payment::signup.platform_slug_unavailable_error'),
            CheckPlatformSlugResponse::PLATFORM_SLUG_INVALID => trans('projectsquare-payment::signup.platform_slug_invalid_error'),
            CreatePlatformResponse::PLATFORM_USERS_COUNT_REQUIRED => trans('projectsquare-payment::signup.platform_users_count_required_error'),
            CreateAdministratorResponse::REPOSITORY_CREATION_FAILED => trans('projectsquare-payment::signup.generic_error'),
            CreateAdministratorResponse::ADMINISTRATOR_EMAIL_REQUIRED => trans('projectsquare-payment::signup.administrator_email_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_PASSWORD_REQUIRED => trans('projectsquare-payment::signup.administrator_password_required_error'),
            CreateAdministratorResponse::PLATFORM_ID_REQUIRED => trans('projectsquare-payment::signup.generic_error'),
        ];

        return (isset($errorMessages[$errorCode])) ? $errorMessages[$errorCode] :  trans('projectsquare-payment::signup.generic_error');
    }
}