<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;

class SignupConfirmationController extends Controller
{
    public function index()
    {
        return view('projectsquare-payment::signup.confirmation');
    }

    public function check_platform_url(Request $request)
    {
        $platformURL = '';
        if ($request->session()->has('platformID')) {
            if ($platform = Platform::find($request->session()->get('platformID'))) {
                $platformURL = 'http://' . $platform->slug . '.projectsquare.io';
            }
        }

        return response()->json([
            'success' => $this->isURLAvailable($platformURL .'/install'),
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