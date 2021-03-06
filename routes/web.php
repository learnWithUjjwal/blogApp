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

Route::get('/', 'PagesController@index');
Route::get('/services', 'PagesController@services');
Route::get('/about', 'PagesController@about');

// Route::get('/{id}', function($id){
//     return $id;
// });
Route::resource('comments', 'CommentsController');
Route::resource('posts', 'PostsController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::delete('/admin', 'HomeController@destroy')->name('home');
Route::post('/home', 'HomeController@addProfilePic')->name('home');
Route::get('/admin', 'HomeController@show');
