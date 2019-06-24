<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => ['web']],function(){
	Route::get('/', function () {
		if(Auth::user() && Auth::check()){
			return view('dashboard',['posts' => App\Post::orderBy('created_at','DESC')->get()]);
		}
		else{
			return view('welcome');
		}
	})->name('welcome');
	
	Route::post('/signup',[
		'uses' => 'UserController@postSignUp',
		'as' => 'signup'
	]);
	
	Route::post('/signin',[
		'uses' => 'UserController@postSignIn',
		'as' => 'signin'
	]);
	
	Route::get('/logout',[
		'uses' => 'UserController@logOut',
		'as' => 'logout',
		'middleware' => 'auth'
	]);
	
	Route::get('/dashboard',[
		'uses' => 'PostController@getDashboard',
		'as' => 'dashboard',
		'middleware' => ['auth']
	]);
	
	Route::get('/account',[
		'uses' => 'UserController@getAccount',
		'as' => 'account',
		'middleware' => ['auth']
	]);
	
	Route::post('/editaccount',[
		'uses' => 'UserController@editAccount',
		'as' => 'editaccount',
		'middleware' => 'auth'
	]);
	
	Route::get('/accountimage{filename}',[
		'uses' => 'UserController@getAccountImage',
		'as' => 'account-image',
		'middleware' => 'auth'
	]);
	
	Route::post('/createpost',[
		'uses' => 'PostController@createPost',
		'as' => 'create-post',
		'middleware' => 'auth'
	]);
	
	Route::post('/deletepost',[
		'uses' => 'PostController@deletePost',
		'as' => 'delete-post',
		'middleware' => 'auth'
	]);
	
	Route::post('/editpost',[
		'uses' => 'PostController@editPost',
		'as' => 'edit-post',
		'middleware' => 'auth'
	]);
	
	
	Route::post('/like',[
		'uses' => 'PostController@likePost',
		'as' => 'like',
		'middleware' => 'auth'
	]);
});