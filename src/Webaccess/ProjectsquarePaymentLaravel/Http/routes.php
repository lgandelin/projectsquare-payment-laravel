<?php

Route::group(['middleware' => ['web']], function () {

    //SIGNUP
    Route::get('/signup', array('as' => 'signup', 'uses' => 'Webaccess\ProjectSquarePaymentLaravel\Http\Controllers\SignupController@index'));

});