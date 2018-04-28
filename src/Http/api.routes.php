<?php

Route::middleware(['handlecors'])->group(function () {
    
    // Authentication
    Route::post('/api/login', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);
    Route::post('/api/password/email', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@sendResetLinkEmail','as'=>'api.sendResetLinkEmail']);
    Route::get('/api/newuser/checkname/{username}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@checkname','as'=>'api.checkname']);
    Route::get('/api/getusername/{email}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@getusername','as'=>'api.getusername']);
    Route::post('/api/checkmail', ['uses'=>'Bishopm\Bookclub\Http\Controllers\IndividualsController@checkEmail','as'=>'api.checkmail']);
    Route::post('/api/register', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\RegisterController@register','as'=>'api.register']);

    // Authors
    Route::get('/authors', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@index','as' => 'api.authors.index']);
    Route::get('/authors/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@show','as' => 'api.authors.show']);

    // Books
    Route::get('/books', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@index','as' => 'api.books.index']);
    Route::post('/books/add', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@store','as' => 'api.books.store']);
    Route::get('/books/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@show','as' => 'api.books.show']);

    // Loans
    Route::get('/loans', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@index','as' => 'api.loans.index']);
    Route::get('/loans/{loan}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@show','as' => 'api.loans.show']);

    // Users
    Route::get('/users', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@index','as' => 'api.users.index']);
    Route::get('/users/{user}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@show','as' => 'api.users.show']);
});
