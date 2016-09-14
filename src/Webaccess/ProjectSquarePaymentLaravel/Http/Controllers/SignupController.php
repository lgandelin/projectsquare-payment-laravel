<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Routing\Controller;

class SignupController extends Controller
{
    public function index()
    {
        return view('projectsquare-payment::signup.index');
    }
}