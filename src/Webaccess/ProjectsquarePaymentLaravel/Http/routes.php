<?php

Route::group(['middleware' => ['web']], function () {

    //SIGNUP
    Route::get('/inscription', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

    Route::post('/inscription', array('as' => 'signup_handler', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@handler'));
});