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

 });

Route::get('/registro-participante', function () {
    return view('participant');
})->name('participant');

Route::post('/add-participant', 'ParticipantController@addParticipant')->name('addParticipant');

// api - routes
Route::get('all-quizes-act', 'QuizController@getQuizes');
Route::get('quiz/{slug}', 'QuizController@getQuiz');