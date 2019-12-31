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

// Route::get('/', function () {
//     print bcrypt('admin');
//     return view('welcome');
// });

//Route::any('about','Controller@index');
Route::any('/','Controller@index');
Route::any('/test','TestController@index');


Route::get('/admins','AdminController@index');
Route::get('/admins/login',['as' => 'admin.login','uses' => 'AuthAdmin\LoginController@showLoginForm']);
Route::post('/admins/login',['uses' => 'AuthAdmin\LoginController@login']);
Route::get('/admins/logout',['as' => 'admin.logout','uses' => 'AuthAdmin\LoginController@logout']);

//Route::any('admin','Admin\AdminController@index');

Route::group(['middleware' => 'auth'], function(){
	Route::prefix('admin')->group(function(){
		Route::get('/','Admin\AdminController@index');
		Route::prefix('items')->group(function(){
			Route::get('/','Admin\ItemsController@index');
			Route::post('/show','Admin\ItemsController@show');
			Route::post('/add','Admin\ItemsController@add');
			Route::post('/edit','Admin\ItemsController@edit');
			Route::post('/delete','Admin\ItemsController@delete');
			Route::post('/delete-all','Admin\ItemsController@deleteAll');
		});	
		Route::prefix('category')->group(function(){
			Route::get('/{section}','Admin\CategoryController@index');
			Route::post('/show/{section}','Admin\CategoryController@show');
			Route::post('/add/{section}','Admin\CategoryController@add');
			Route::post('/edit/{section}','Admin\CategoryController@edit');
			Route::post('/delete/{section}','Admin\CategoryController@delete');
			Route::post('/delete-all/{section}','Admin\CategoryController@deleteAll');
		});	
	});
});	

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout','Auth\LoginController@logout');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
