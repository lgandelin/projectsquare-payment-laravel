<?php

Route::group(['middleware' => ['web']], function () {

    //SIGNUP
    Route::get('/inscription/{users_count?}', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

    Route::post('/inscription', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));

    Route::post('/inscription_verification_url', array('as' => 'signup_check_slug', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@check_slug'));
});