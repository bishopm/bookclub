<?php
Route::post('login', 'Bishopm\Bookclub\Http\Controllers\AuthController@login');
Route::post('/users/register', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@register','as' => 'api.users.register']);
Route::middleware(['handlecors','api','jwt.auth'])->group(function () {
    // Authentication
    Route::post('logout', 'Bishopm\Bookclub\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'Bishopm\Bookclub\Http\Controllers\AuthController@refresh');
    Route::post('me', 'Bishopm\Bookclub\Http\Controllers\AuthController@me');

    // Authors
    Route::get('/authors', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@index','as' => 'api.authors.index']);
    Route::post('/authors/search/{query?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@search','as' => 'api.authors.search']);
    Route::post('/authors', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@check','as' => 'api.authors.check']);
    Route::post('/authors/update/{author}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@update','as' => 'api.authors.update']);
    Route::post('/authors/delete/{author}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@delete','as' => 'api.authors.delete']);
    Route::get('/authors/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\AuthorsController@show','as' => 'api.authors.show']);

    // Books
    Route::get('/books', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@index','as' => 'api.books.index']);
    Route::post('/books/search/{query?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@search','as' => 'api.books.search']);
    Route::post('/books/add', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@store','as' => 'api.books.store']);
    Route::post('/books/update/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@update','as' => 'api.books.update']);
    Route::post('/books/delete/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@delete','as' => 'api.books.delete']);
    Route::post('/books/addcomment', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@addcomment','as' => 'api.books.addcomment']);
    Route::post('/books/deletecomment/{comment}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@deletecomment','as' => 'api.books.deletecomment']);
    Route::get('/books/alltags', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@alltags','as' => 'api.books.alltags']);
    Route::get('/books/{book}/{user?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@show','as' => 'api.books.show']);

    // Comments
    Route::get('/comments', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@comments','as' => 'api.comments.index']);

    // Genre
    Route::get('/genre/{genre}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@genre','as' => 'api.books.genre']);

    // Loans
    Route::get('/loans', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@index','as' => 'api.loans.index']);
    Route::post('/loans/add', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@store','as' => 'api.loans.store']);
    Route::post('/loans/update', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@update','as' => 'api.loans.update']);
    Route::get('/loans/{loan}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\LoansController@show','as' => 'api.loans.show']);

    // Users
    Route::get('/users', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@index','as' => 'api.users.index']);
    Route::get('/users/{user}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@show','as' => 'api.users.show']);
    Route::post('/users/authorise/{user}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@authorise','as' => 'api.users.authorise']);
    Route::get('/home/{user}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@home','as' => 'api.users.home']);
});
