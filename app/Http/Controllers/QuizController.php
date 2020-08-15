<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Result;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizes(){
        $quizes = Quiz::where('status', 'active')->get();
        return $quizes;
    }

    public function getQuiz($slug){
        $user = Auth::user();
        $quiz = Quiz::where('slug', $slug)->with('questions', 'questions.answers')->first();
        
        return [
            'quiz'  => $quiz,
            'user'  => $user
        ];
    }

    public function storeResult(Request $request){
        $quiz = $request->quizId;
        $user = $request->userId;
        $questionsCount = $request->questionsCount;
        $correctAnswers = $request->correctAnswers;

        $result = new Result([
            'user_id'           => $user,
            'quiz_id'           => $quiz,
            'correct_answers'   => $correctAnswers,
            'questions_count'   => $questionsCount
        ]);
        $result->save();

        return $result;
    }

    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    public function destroy(Quiz $quiz)
    {
        //
    }
}
