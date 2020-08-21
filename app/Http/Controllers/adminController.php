<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Quiz;
use App\Result;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function counts(){

        $users = User::where('role', 'user')->count();
        $questions = Question::all()->count();
        $quizes = Quiz::all()->count();
        $results = Result::all()->count();

        return [
            'users'     => $users,
            'questions' => $questions,
            'quizes'      => $quizes,
            'results'    => $results
        ];
    }

    public function lastUserAndResult(){
        $users = User::orderBy('created_at', 'desc')->limit(5)->get();
        $results = Result::orderby('created_at', 'desc')->with('user', 'quiz')->limit(5)->get();
        return [
            'lastUsers'     => $users,
            'lastResult'    => $results
        ];
    }

    public function allResults(){
        $results = Result::orderby('created_at', 'desc')->with('user', 'quiz')->paginate();
        return $results;
    }

    public function allQuizes(){
        $quizes = Quiz::orderBy('updated_at', 'DESC')->with('questions')->paginate();
        return $quizes;
    }

    public function deleteQuiz($id){
        $quiz = Quiz::destroy($id);
        return "Quiz eliminado";
    }
}
