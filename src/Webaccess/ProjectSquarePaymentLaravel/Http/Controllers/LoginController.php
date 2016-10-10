<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webaccess\ProjectSquareLaravel\Models\Administrator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('projectsquare-payment::auth.login', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
        ]);
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->intended('/');
        }

        return redirect()->route('login')->with([
            'error' => trans('projectsquare-payment::login.error_login_or_password'),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function forgotten_password(Request $request)
    {
        return view('projectsquare-payment::auth.forgotten_password', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'message' => ($request->session()->has('message')) ? $request->session()->get('message') : null,
        ]);
    }

    public function forgotten_password_handler(Request $request)
    {
        $userEmail = $request->email;

        try {
            $newPassword = $this->generateNewPassword();
            if ($user = Administrator::where('email', '=', $userEmail)->first()) {
                $user->password = bcrypt($newPassword);
                $user->save();
                $this->sendNewPasswordToUser($newPassword, $userEmail);
                $request->session()->flash('message', 'Un email contenant votre nouveau mot de passe vous a été envoyé sur votre adresse.');
            } else {
                throw new \Exception('Aucun compte trouvé avec cette adresse');
            }
        } catch (\Exception $e) {
            $request->session()->flash('error', $e->getMessage());
        }

        return redirect()->route('forgotten_password');
    }

    private function sendNewPasswordToUser($newPassword, $userEmail)
    {
        Mail::send('projectsquare-payment::emails.password', array('password' => $newPassword), function ($message) use ($userEmail) {

            $message->to($userEmail)
                ->from('no-reply@projectsquare.fr')
                ->subject('[projectsquare] Votre nouveau mot de passe');
        });
    }

    private function generateNewPassword($length = 8)
    {
        $chars = 'abcdefghkmnpqrstuvwxyz23456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; ++$i) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
}