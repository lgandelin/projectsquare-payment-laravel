<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Webaccess\ProjectSquarePayment\Requests\Signup\CheckPlatformSlugRequest;
use Webaccess\ProjectSquarePayment\Requests\Signup\SignupRequest;
use Webaccess\ProjectSquarePayment\Responses\Administrators\CreateAdministratorResponse;
use Webaccess\ProjectSquarePayment\Responses\Platforms\CreatePlatformResponse;
use Webaccess\ProjectSquarePayment\Responses\Signup\CheckPlatformSlugResponse;

class SignupController extends Controller
{
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

    public function handler(Request $request)
    {
        $request->flashExcept('administrator_password');

        try {
            $response = app()->make('SignupInteractor')->execute(new SignupRequest([
                'platformName' => $request->name,
                'platformSlug' => $request->slug,
                'platformUsersCount' => $request->users_count,
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

            $this->launchPlatformCreation($request->slug, $request->administrator_email);

        } catch (Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::signup.platform_generic_error'));
            $this->logErrorFromException($e, $request);
        }

        return redirect()->route('signup');
    }

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
            $this->logErrorFromException($e, $request);

            return response()->json([
                'error' => trans('projectsquare-payment::signup.platform_slug_verification_error'),
            ], 500);
        }
    }

    private function launchPlatformCreation($slug, $administratorEmail)
    {
        $fileName = env('ENV_FILES_FOLDER') . $slug . '.sh';
        $fileContent = 'DO_MACHINE_NAME=' . $slug . PHP_EOL . 'APP_NAME=' . $slug . PHP_EOL . 'EMAIL_ADDRESS=' . $administratorEmail . PHP_EOL;
        file_put_contents($fileName, $fileContent);
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

            case CheckPlatformSlugResponse::PLATFORM_SLUG_UNAVAILABLE:
                $errorMessage = trans('projectsquare-payment::signup.platform_slug_unavailable_error');
                break;

            case CheckPlatformSlugResponse::PLATFORM_SLUG_INVALID:
                $errorMessage = trans('projectsquare-payment::signup.platform_slug_invalid_error');
                break;

            case CreatePlatformResponse::PLATFORM_USERS_COUNT_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.platform_users_count_required_error');
                break;

            case CreateAdministratorResponse::REPOSITORY_CREATION_FAILED:
                $errorMessage = trans('projectsquare-payment::signup.generic_error');
                break;

            case CreateAdministratorResponse::ADMINISTRATOR_LAST_NAME_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.administrator_last_name_required_error');
                break;

            case CreateAdministratorResponse::ADMINISTRATOR_FIRST_NAME_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.administrator_first_name_required_error');
                break;

            case CreateAdministratorResponse::ADMINISTRATOR_EMAIL_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.administrator_email_required_error');
                break;

            case CreateAdministratorResponse::ADMINISTRATOR_PASSWORD_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.administrator_password_required_error');
                break;

            case CreateAdministratorResponse::PLATFORM_ID_REQUIRED:
                $errorMessage = trans('projectsquare-payment::signup.generic_error');
                break;

            default:
                $errorMessage = trans('projectsquare-payment::signup.generic_error');
                break;
        }

        return $errorMessage;
    }

    private function logErrorFromException(Exception $e, Request $request = null)
    {
        Log::error('Date : ' . (new DateTime())->format('Y-m-d H:i:s'));
        Log::error('Message : ' . $e->getMessage());
        Log::error('File : ' . $e->getFile());
        Log::error('Line : ' . $e->getLine());
        if ($request) Log::error('Parameters : ' . json_encode($request->all()));
        Log::error('--------------------------------------------------');
    }
}