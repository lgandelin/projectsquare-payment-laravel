<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SignupConfirmationController extends Controller
{
    public function index()
    {
        return view('projectsquare-payment::signup.confirmation');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function check_platform_url(Request $request)
    {
        $platformURL = '';
        if ($request->session()->has('platformID')) {
            $platformURL = app()->make('PlatformAPIGateway')->getPlatformURL($request->session()->get('platformID'));
        }

        return response()->json([
            'success' => $this->isURLAvailable($platformURL .'/config'),
            'url' => $platformURL
        ], 200);
    }

    /**
     * @param $platformURL
     * @return bool
     */
    private function isURLAvailable($platformURL)
    {
        if ($platformURL == NULL) return false;
        $ch = curl_init($platformURL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpcode >= 200 && $httpcode < 300) ? true : false;
    }
}