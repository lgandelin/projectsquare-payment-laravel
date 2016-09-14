<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePayment\Requests\Platforms\CreatePlatformRequest;

class SignupController extends Controller
{
    public function index()
    {
        return view('projectsquare-payment::signup.index');
    }

    public function handler(Request $request)
    {
        $response = app()->make('CreatePlatformInteractor')->execute(new CreatePlatformRequest([
            'name' => $request->agency_name,
            'slug' => $request->url,
            'usersCount' => $request->users_count,
        ]));
    }
}