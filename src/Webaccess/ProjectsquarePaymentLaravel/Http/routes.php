<?php

Route::group(['middleware' => ['web']], function () {

    //LOGIN
    Route::get('/login', array('as' => 'login', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@login'));
    Route::post('/login', array('as' => 'login_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@authenticate'));
    Route::get('/logout', array('as' => 'logout', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@logout'));
    Route::get('/forgotten_password', array('as' => 'forgotten_password', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@forgotten_password'));
    Route::post('/forgotten_password_handler', array('as' => 'forgotten_password_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@forgotten_password_handler'));

    //MON COMPTE
    Route::get('/', array('as' => 'my_account', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\MyAccountController@index'));

    //SIGNUP
    Route::get('/inscription/{users_count?}', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

    Route::post('/inscription', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));

    Route::post('/signup_check_slug', array('as' => 'signup_check_slug', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@check_slug'));

    Route::get('/confirmation', array('as' => 'confirmation', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupConfirmationController@index'));

    Route::get('/signup_confirmation_check_platform_url', array('as' => 'signup_confirmation_check_platform_url', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupConfirmationController@check_platform_url'));
});