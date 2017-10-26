<?php

Route::group(['middleware' => ['web']], function () {

    //LOGIN
    Route::get('/login', array('as' => 'login', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@login'));
    Route::post('/login', array('as' => 'login_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@authenticate'));
    Route::get('/logout', array('as' => 'logout', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@logout'));
    Route::get('/forgotten_password', array('as' => 'forgotten_password', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@forgotten_password'));
    Route::post('/forgotten_password_handler', array('as' => 'forgotten_password_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\LoginController@forgotten_password_handler'));

    //MY ACCOUNT
    Route::get('/', array('as' => 'my_account', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\MyAccountController@index'));
    Route::post('/update_administrator', array('as' => 'update_administrator', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\MyAccountController@update_administrator'));
    Route::get('/invoice/{invoiceID}', array('as' => 'payment_invoice', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\PaymentController@invoice'));

    //PAYMENT
    Route::get('/payment', array('as' => 'payment_index', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\PaymentController@index'));
    Route::post('/payment', array('as' => 'payment_action', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\PaymentController@pay'));
    Route::get('/cancel_subscription', array('as' => 'cancel_subscription', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\PaymentController@cancel_subscription'));

    //SIGNUP
    Route::get('/inscription/{users_count?}', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));
    Route::post('/inscription', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));
    Route::post('/signup_check_slug', array('as' => 'signup_check_slug', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@check_slug'));
    Route::get('/signup_confirmation', array('as' => 'signup_confirmation', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupConfirmationController@index'));
    Route::get('/signup_confirmation_check_platform_url', array('as' => 'signup_confirmation_check_platform_url', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupConfirmationController@check_platform_url'));

    //LANDING FREE TRIAL
    Route::get('/essai-gratuit-projectsquare-gestion-de-projet', array('as' => 'landing_free_trial', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@landing_free_trial'));
    Route::post('/essai-gratuit-projectsquare-gestion-de-projet/handler', array('as' => 'landing_free_trial_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));
});

Route::group(['middleware' => ['api']], function () {

   //API : UPDATE USERS COUNT
   Route::post('/update_users_count', array('as' => 'update_users_count', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\APIController@update_users_count'));
});
