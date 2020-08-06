<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizes(){
        $quizes = Quiz::where('status', 'active')->get();
        return $quizes;
    }

    public function getQuiz($slug)
    {
        $quiz = Quiz::where('slug', $slug)->with('questions', 'questions.answer')->get();
        return $quiz;
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Quiz $quiz)
    {
        //
    }

    public function edit(Quiz $quiz)
    {
        //
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
