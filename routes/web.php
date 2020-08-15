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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/quiz/{slug}', function () {
        return view('quiz.show');
    })->name('show-quiz');

    // api - routes
    Route::get('all-quizes-act', 'QuizController@getQuizes');
    Route::get('show-quiz/{slug}', 'QuizController@getQuiz');
    
    Route::post('addResult', 'QuizController@storeResult')->name('result');
 });


