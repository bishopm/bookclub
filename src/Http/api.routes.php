<?php

Route::middleware(['handlecors'])->group(function () {
    
    // Authentication
    Route::post('/api/login', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);
    Route::post('/api/password/email', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@sendResetLinkEmail','as'=>'api.sendResetLinkEmail']);
    Route::get('/api/newuser/checkname/{username}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@checkname','as'=>'api.checkname']);
    Route::get('/api/getusername/{email}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@getusername','as'=>'api.getusername']);
    Route::post('/api/checkmail', ['uses'=>'Bishopm\Bookclub\Http\Controllers\IndividualsController@checkEmail','as'=>'api.checkmail']);
    Route::post('/api/register', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\RegisterController@register','as'=>'api.register']);

    // Books
    Route::get('/api/books', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@apibooks','as' => 'api.books']);
    Route::get('/api/books/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@apibook','as' => 'api.books.show']);
});
