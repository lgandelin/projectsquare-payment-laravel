<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Webaccess\ProjectSquarePayment\Requests\Signup\CheckPlatformSlugRequest;
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
        $users_count = ($request->users_count) ? $request->users_count : 1;
        $users_count = (old('users_count')) ? old('users_count') : $users_count;

        return view('projectsquare-payment::signup.index', [
            'platform_monthly_cost' => env('PLATFORM_MONTHLY_COST'),
            'user_monthly_cost' => env('USER_MONTHLY_COST'),
            'total_monthly_cost' => env('PLATFORM_MONTHLY_COST') + $users_count * env('USER_MONTHLY_COST'),
            'users_count' => $users_count,
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request)
    {
        $request->flashExcept('administrator_password');

        try {
            $response = app()->make('SignupInteractor')->execute(new SignupRequest([
                'platformName' => $request->name,
                'platformSlug' => $request->slug,
                'platformUsersCount' => $request->users_count,
                'platformPlatformMonthlyCost' => env('PLATFORM_MONTHLY_COST'),
                'platformUserMonthlyCost' => env('USER_MONTHLY_COST'),
                'administratorEmail' => $request->administrator_email,
                'administratorPassword' => Hash::make($request->administrator_password),
                'administratorLastName' => $request->administrator_last_name,
                'administratorFirstName' => $request->administrator_first_name,
                'administratorBillingAddress' => $request->administrator_billing_address,
                'administratorZipcode' => $request->administrator_zipcode,
                'administratorCity' => $request->administrator_city,
            ]));

            if (!$response->success) {
                $request->session()->flash('error', $this->getErrorMessage($response->errorCode));
                return redirect()->route('signup');
            }

            $request->session()->put('platformID', $response->platformID);

            return redirect()->route('signup_confirmation');
        } catch (Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::signup.platform_generic_error'));
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());
        }

        return redirect()->route('signup');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function check_slug(Request $request)
    {
        try {
            $response = app()->make('CheckPlatformSlugInteractor')->execute(new CheckPlatformSlugRequest([
                'slug' => $request->slug
            ]));

            return response()->json([
                'success' => $response->success,
                'error' => $response->errorCode
            ], 200);
        } catch (Exception $e) {
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());

            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::signup.platform_slug_verification_error'),
            ], 500);
        }
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
            CreateAdministratorResponse::ADMINISTRATOR_LAST_NAME_REQUIRED => trans('projectsquare-payment::signup.administrator_last_name_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_FIRST_NAME_REQUIRED => trans('projectsquare-payment::signup.administrator_first_name_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_EMAIL_REQUIRED => trans('projectsquare-payment::signup.administrator_email_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_PASSWORD_REQUIRED => trans('projectsquare-payment::signup.administrator_password_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_CITY_REQUIRED => trans('projectsquare-payment::signup.administrator_city_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_BILLING_ADDRESS_REQUIRED => trans('projectsquare-payment::signup.administrator_billing_address_required_error'),
            CreateAdministratorResponse::ADMINISTRATOR_ZIPCODE_REQUIRED => trans('projectsquare-payment::signup.administrator_zipcode_required_error'),
            CreateAdministratorResponse::PLATFORM_ID_REQUIRED => $errorMessage = trans('projectsquare-payment::signup.generic_error'),
        ];

        return (isset($errorMessages[$errorCode])) ? $errorMessages[$errorCode] :  trans('projectsquare-payment::signup.generic_error');
    }
}