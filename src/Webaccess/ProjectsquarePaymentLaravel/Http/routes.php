<?php

Route::group(['middleware' => ['web']], function () {

    //SIGNUP
    Route::get('/inscription/{users_count?}', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

    Route::post('/inscription', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));

    Route::post('/signup_check_slug', array('as' => 'signup_check_slug', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@check_slug'));

    Route::get('/confirmation', array('as' => 'confirmation', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@confirmation'));

    Route::get('/signup_confirmation_check_platform_url', array('as' => 'signup_confirmation_check_platform_url', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@check_platform_url'));
});