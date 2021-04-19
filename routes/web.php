<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'FrontEndController@index');
Route::get('quiz/{slug}', 'FrontEndController@quiz');

Route::group(['prefix' => 'imports'], function () {
   
	Route::get('categories/{sector_id}/','ImportsController@categories');
	Route::get('questions/{category_id}/{slug}','ImportsController@importFromIm');
	Route::get('quizzes/{category_id}/{slug}','ImportsController@quizzes');
	Route::get('quizzes','ImportsController@quizzesCron');
	Route::get('examveda','ImportsController@examvedaCron');
	Route::get('mcqlearn','ImportsController@mcqlearnCron');
	Route::get('electrical4u','ImportsController@electrical4uCron');

});



Route::group(['prefix' => 'admin'], function () {

	
    
    Voyager::routes();

   
});
