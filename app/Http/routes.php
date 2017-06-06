<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//listening to sql
DB::enableQueryLog();


Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', ['as' => 'home', 'uses' => 'DisplayController@home']);
Route::get('/posts', ['as' => 'posts', 'uses' => 'DisplayController@posts']);
Route::get('/post/{id}/display', ['as' => 'post.display', 'uses' => 'DisplayController@postShow']);
Route::get('/images', ['as' => 'images.all', 'uses' => 'DisplayController@images']);
Route::get('/images/album-images', ['as' => 'images.album', 'uses' => 'DisplayController@albumImages']);
Route::get('/images/posts-images', ['as' => 'images.posts', 'uses' => 'DisplayController@postsImages']);
Route::get('/image/{id}/display', ['as' => 'image.display', 'uses' => 'DisplayController@imageShow']);

Route::get('/search', ['as' => 'search.find', 'uses' => 'SearchController@findForm']);
Route::post('/search/{place?}', ['as' => 'search.post', 'uses' => 'SearchController@find']);

get('auth/login', ['as' => 'loginRedirect', 'uses' => function () {
    return Redirect::route('loginForm');
}]);

// login form communication
Route::get('/login', ['as' => 'loginForm', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'middleware' => 'guest', 'uses' => 'Auth\AuthController@postLogin']);
// logout communication
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);


// register form communication
Route::get('/register', ['as' => 'registerForm', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);


//need authentication
Route::group(['middleware' => 'auth'], function () {

    Route::resource('user', 'UserController');
    Route::get('/user/{id}/deactivate', ['as' => 'user.deactivate', 'uses' => 'UserController@deactivate']);
    Route::get('/user/{id}/activate', ['as' => 'user.activate', 'uses' => 'UserController@activate']);
    Route::get('/user/{id}/disable', ['as' => 'user.disable', 'uses' => 'UserController@disable']);
    Route::get('/user/{id}/enable', ['as' => 'user.enable', 'uses' => 'UserController@enable']);

    Route::resource('image', 'ImageController');
    Route::delete('/image/{id}/permanent-delete', ['as' => 'image.permanentDelete', 'uses' => 'ImageController@permanentDelete']);
    Route::get('/image/{id}/restore', ['as' => 'image.restore', 'uses' => 'ImageController@restore']);


    Route::resource('post', 'PostController');
    Route::delete('/post/{id}/permanent-delete', ['as' => 'post.permanentDelete', 'uses' => 'PostController@permanentDelete']);
    Route::get('/post/{id}/restore', ['as' => 'post.restore', 'uses' => 'PostController@restore']);


    Route::get('/comment/type/{commentable}', ['as' => 'comment.typeSelect', 'uses' => 'CommentController@index']);
    Route::resource('comment', 'CommentController');
    Route::delete('/comment/{id}/permanent-delete', ['as' => 'comment.permanentDelete', 'uses' => 'CommentController@permanentDelete']);
    Route::get('/comment/{id}/restore', ['as' => 'comment.restore', 'uses' => 'CommentController@restore']);


    Route::resource('tag', 'TagController');
    Route::delete('/tag/{id}/permanent-delete', ['as' => 'tag.permanentDelete', 'uses' => 'TagController@permanentDelete']);
    Route::get('/tag/{id}/restore', ['as' => 'tag.restore', 'uses' => 'TagController@restore']);

    Route::get('/log/type/{logable}', ['as' => 'log.typeSelect', 'uses' => 'LogController@index']);
    Route::resource('log', 'LogController',['only'=>['destroy','index','show']]);
    Route::delete('/log/{id}/permanent-delete', ['as' => 'log.permanentDelete', 'uses' => 'LogController@permanentDelete']);
    Route::get('/log/{id}/restore', ['as' => 'log.restore', 'uses' => 'LogController@restore']);


    Route::get('/index', ['as' => 'post.indexAdmin', 'uses' => 'PostController@indexAdmin']);


    Route::resource('privilege', 'PrivilegeController');
    Route::resource('role', 'RoleController');
    Route::get('/administration-area', ['as' => 'administration.all', 'uses' => function () {
        return view('custom.administration');
    }]);

});
