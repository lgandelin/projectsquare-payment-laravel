<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;

class LandingFreeTrialController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('projectsquare-payment::landing_free_trial.index');
    }
}