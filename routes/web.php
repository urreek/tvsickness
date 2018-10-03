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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/movies', 'MovieController@index');
Route::get('/movies/{id}', 'MovieController@details');
Route::get('/tvshows', 'TVShowController@index');
Route::get('/tvshows/{id}', 'TVShowController@details');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::post('/contact/submit', 'ContactController@submit');