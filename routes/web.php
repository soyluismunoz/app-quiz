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

 Route::group(['middleware' => ['admin']], function () {
    //views
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/all-results', function () {
        return view('quiz.auth.results');
    })->name('results');

    Route::get('/dashboard/edit-quiz/{id}', function () {
        return view('quiz.auth.updateQuiz');
    })->name('updateQuiz');

    Route::get('/dashboard/all-quizes', function () {
        return view('quiz.auth.allQuizes');
    })->name('allQuizes');

    //list and counters
    Route::get('counters', 'adminController@counts');
    Route::get('last-user-and-result', 'adminController@lastUserAndResult');

    Route::get('all-results-dash', 'adminController@allResults');
    Route::get('all-quizes-dash', 'adminController@allQuizes');

    //create update and delete Quiz
    Route::post('add-quiz', 'adminController@AddQuiz');
    Route::get('edit-quiz/{id}', 'adminController@editQuiz');
    Route::post('/update-quiz', 'adminController@updateQuiz');
    Route::delete('delete-quiz/{id}', 'adminController@deleteQuiz');

    //create update and delete Question
    Route::post('add-question', 'adminController@addQuestions');
    Route::post('update-question', 'adminController@updateQues');
    Route::delete('delete-question/{id}', 'adminController@deleteQuestion');

    //
    Route::post('add-answer', 'adminController@addAns');
    Route::delete('delete-answer/{id}', 'adminController@deleteAnswers');
    
    //usuarios
    Route::get('/dashboard/usuarios', 'UserController@index')->name('user.index');
    Route::get('/dashboard/nuevo-usuario', 'UserController@create')->name('user.create');
    Route::get('/dashboard/editar-usuario/{id}', 'UserController@edit')->name('user.edit');
    Route::get('/dashboard/mi-perfil', 'ProfileController@edit')->name('profile.edit');
    
    Route::put('dashboard/profile-password', 'ProfileController@password')->name('profile.password');
    Route::put('dashboard/user-password/{id}', 'UserController@password')->name('user.password');
    
    Route::post('dashboard/agregar-usuario', 'UserController@store')->name('user.store');
    Route::put('dashboard/actualizar-usuario/{id}', 'UserController@update')->name('user.update');
    Route::put('dashboard/editar-perfil', 'UserController@update')->name('profile.update');
    Route::delete('dashboard/borrar-usuario/{id}', 'UserController@destroy')->name('user.destroy');
 });

 


