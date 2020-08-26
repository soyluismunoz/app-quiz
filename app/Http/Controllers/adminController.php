<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Quiz;
use App\Result;
use App\Answer;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    //quiz
    public function allQuizes(){
        $quizes = Quiz::orderBy('updated_at', 'DESC')->with('questions')->paginate();
        return $quizes;
    }
    public function editQuiz($id){
        $quiz = Quiz::where('id', $id)->with('questions', 'questions.answers')->first();
        return  $quiz;
    }
    public function AddQuiz(Request $request){

        $quiz = new Quiz([
            'title'         => $request->title, 
            'description'   => $request->description,
            'approve_with'  => $request->approve_with,
            'if_approve'    => $request->if_approve,
            'if_fail'       => $request->if_fail,
            'slug'          => Str::slug($request->title), 
            'hour'          => $request->hour, 
            'min'           => $request->min, 
            'seg'           => $request->seg, 
            'status'        => $request->status
        ]);

        $quiz->save();
        return $quiz;
    }
    public function updateQuiz(Request $request){
        $quiz = Quiz::find($request->id);
        $quiz->update([
            'title'         => $request->title, 
            'description'   => $request->description,
            'approve_with'  => $request->approve_with,
            'if_approve'    => $request->if_approve,
            'if_fail'       => $request->if_fail,
            'slug'          => Str::slug($request->title), 
            'hour'          => $request->hour, 
            'min'           => $request->min, 
            'seg'           => $request->seg, 
            'status'        => $request->status
        ]);
        return $quiz;
    }
    public function deleteQuiz($id){
        $quiz = Quiz::destroy($id);
        return "Quiz eliminado";
    }

    //Questions
    public function addQuestions(Request $request){
        $question = new Question([
            'quiz_id'   => $request->quiz_id,
            'title'     => $request->title
        ]);

        $question->save();
        return $question;
    }
    public function updateQues(Request $request){
        $ques = Question::find($request->id);
        $ques->update([
            'title'     => $request->title
        ]);
        return $ques;
    }
    public function deleteQuestion($id){
        $question = Question::destroy($id);
        return "Pregunta eliminada";
    }

    //Answers
    public function addAns(Request $request){
        $ans = new Answer([
            'question_id'   => $request->question_id,
            'answer'        => $request->answer,
            'correct'       => $request->correct
        ]);

        $ans->save();
        return $ans;
    }
    public function deleteAnswers($id){
        $answer = Answer::destroy($id);
        return "Respuesta eliminada";
    }

}
