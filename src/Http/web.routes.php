<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/feed/{service?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\WebController@feed','as' => 'feed']);
    Route::get('login', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\LoginController@showLoginForm','as'=>'showlogin']);
    Route::post('login', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\LoginController@login','as'=>'login']);
    Route::get('/login/{social}', 'Bishopm\Bookclub\Http\Controllers\Auth\LoginController@socialLogin')->where('social', 'facebook|google');
    Route::get('/login/{social}/callback', 'Bishopm\Bookclub\Http\Controllers\Auth\LoginController@handleProviderCallback')->where('social', 'facebook|google');
    Route::post('password/email', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail','as'=>'sendResetLinkEmail']);
    Route::get('password/reset', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm','as'=>'showLinkRequestForm']);
    Route::post('password/reset', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ResetPasswordController@reset','as'=>'password.request']);
    Route::get('password/reset/{token}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ResetPasswordController@showResetForm','as'=>'showResetForm']);
});
