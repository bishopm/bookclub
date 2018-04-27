<?php

Route::middleware(['handlecors'])->group(function () {
    
    // Authentication
    Route::post('/api/login', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@login','as'=>'api.login']);
    Route::post('/api/password/email', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\ApiAuthController@sendResetLinkEmail','as'=>'api.sendResetLinkEmail']);
    Route::get('/api/newuser/checkname/{username}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@checkname','as'=>'api.checkname']);
    Route::get('/api/getusername/{email}', ['uses'=>'Bishopm\Bookclub\Http\Controllers\WebController@getusername','as'=>'api.getusername']);
    Route::post('/api/checkmail', ['uses'=>'Bishopm\Bookclub\Http\Controllers\IndividualsController@checkEmail','as'=>'api.checkmail']);
    Route::post('/api/register', ['uses'=>'Bishopm\Bookclub\Http\Controllers\Auth\RegisterController@register','as'=>'api.register']);

    // Blogs
    Route::get('/api/blogs', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BlogsController@apiblogs','as' => 'api.blog']);
    Route::get('/api/blog/{blog}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BlogsController@apiblog','as' => 'api.currentblog']);

    // Books
    Route::get('/api/books', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@apibooks','as' => 'api.books']);
    Route::get('/api/books/{book}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@apibook','as' => 'api.books.show']);

    // Courses
    Route::get('/api/courses', ['uses' => 'Bishopm\Bookclub\Http\Controllers\CoursesController@api_courses','as' => 'api.courses']);
    Route::get('/api/courses/{course}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\CoursesController@api_course','as' => 'api.course']);

    // Groups
    Route::get('/api/groups', ['uses' => 'Bishopm\Bookclub\Http\Controllers\GroupsController@api_groups','as' => 'api.groups']);
    Route::get('/api/group/{group}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\GroupsController@api_group','as' => 'api.group']);

    // Sermons
    Route::get('/api/sermons/{sermon?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\SermonsController@sermonapi','as' => 'api.sermons']);
    Route::get('/api/series/{series?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\SeriesController@seriesapi','as' => 'api.series']);

    Route::get('/api/readings', ['uses' => 'Bishopm\Bookclub\Http\Controllers\WebController@lectionary','as' => 'api.lectionary']);
    Route::group(['middleware' => ['jwt.auth','handlecors']], function () {
        Route::post('/api/book/{book}/addcomment', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BooksController@apiaddcomment','as' => 'bookapi.add.comment']);
        Route::post('/api/blog/{blog}/addcomment', ['uses' => 'Bishopm\Bookclub\Http\Controllers\BlogsController@apiaddcomment','as' => 'blogapi.add.comment']);
        Route::get('/api/comments', ['uses' => 'Bishopm\Bookclub\Http\Controllers\WebController@api_comments','as' => 'api.comments']);
        Route::post('/api/course/{course}/addcomment', ['uses' => 'Bishopm\Bookclub\Http\Controllers\CoursesController@apiaddcomment','as' => 'courseapi.add.comment']);
        Route::get('/api/folders', ['uses' => 'Bishopm\Bookclub\Http\Controllers\FoldersController@api_folders','as' => 'api.folders']);
        Route::post('/api/households', ['uses' => 'Bishopm\Bookclub\Http\Controllers\HouseholdsController@api_households','as' => 'api.households']);
        Route::get('/api/household/{id}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\HouseholdsController@api_household','as' => 'api.household']);
        Route::post('/api/sermon/{sermon}/addcomment', ['uses' => 'Bishopm\Bookclub\Http\Controllers\SermonsController@apiaddcomment','as' => 'sermonapi.add.comment']);
        Route::get('/api/taskapi', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ActionsController@taskapi','as' => 'api.taskapi']);
        Route::get('/api/taskcompleted/{id}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ActionsController@togglecompleted','as' => 'api.taskcompleted']);
        Route::post('/api/newtask', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ActionsController@api_newtask','as' => 'api.task.create']);
        Route::get('/api/individual', ['uses' => 'Bishopm\Bookclub\Http\Controllers\IndividualsController@api_individual','as' => 'api.individual']);
        Route::get('/api/messages/{user}/{receiver}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\MessagesController@api_messagethread','as' => 'api.messagethread']);
        Route::get('/api/messages/{user}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\MessagesController@api_usermessages','as' => 'api.usermessages']);
        Route::get('/api/project/{project}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ProjectsController@api_project','as' => 'api.project']);
        Route::get('/api/projects/{indiv?}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ProjectsController@api_projects','as' => 'api.projects']);
        Route::get('/api/projectindivs', ['uses' => 'Bishopm\Bookclub\Http\Controllers\ActionsController@api_projectindivs','as' => 'api.projectindivs']);
        Route::post('/api/sendmessage', ['uses' => 'Bishopm\Bookclub\Http\Controllers\MessagesController@apisendmessage','as' => 'messageapi.send.comment']);
        Route::get('/api/subject/{tagname}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\WebController@apitag','as' => 'api.tag']);
        Route::get('/api/users', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@api_users','as' => 'api.users']);
        Route::get('/api/users/{id}', ['uses' => 'Bishopm\Bookclub\Http\Controllers\UsersController@api_user','as' => 'api.user']);
    });
});
