<?php

Route::group(['middleware' => ['web']], function () {

    //SIGNUP
    Route::get('/signup', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

    Route::post('/signup', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));
});