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

		
Route::group([], function () {
		//Authentication Route
		Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogIn']);
		Route::post('auth/login', 'Auth\AuthController@postLogIn');
		Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

		//Registration Route
		Route::get('auth/register', 'Auth\AuthController@getRegister');
		Route::post('auth/register', 'Auth\AuthController@postRegister');

		//Password reset Route				
		Route::auth();
		Route::get('/home', 'HomeController@index');

		//Category
		Route::resource('categories','CategoryController',['except'=> ['create']]);
		//Tags
		Route::resource('tags', 'TagController', ['except' => ['create']]);

		//Comments
		Route::post('comments/{post_id}',['as' => 'comments.store','uses' =>'CommentsController@store']);
		Route::get('comments/{id}/edit',[ 'as' => 'comments.edit','uses' => 'CommentsController@edit']);
		Route::put('comments/{id}',[ 'as' => 'comments.update','uses' => 'CommentsController@update']);
		Route::delete('comments/{id}',[ 'as' => 'comments.destroy','uses' => 'CommentsController@destroy']);
		Route::get('comments/{id}/delete',[ 'as' => 'comments.delete','uses' => 'CommentsController@delete']);


		Route::get('blog/{slug}', ['as' => 'blog.single','uses' => 'BlogController@getSingle'])
		           ->where('slug','[\w\d\-\_]+');


		Route::get('blog', ['as'=>'blog.index', 'uses' => 'BlogController@getIndex']);

		Route::get('/', 'PagesController@getIndex');

		Route::get('/about', 'PagesController@getAbout');

		Route::get('/contact', 'PagesController@getContact');
		
		Route::post('/contact', 'PagesController@postContact');

		Route::resource('posts', 'PostController');


});



	

