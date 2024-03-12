<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getDetailQuestion(Request $request, $id)
    {
        $question = Question::where('id', $id)->with('answers')->first();
        $responses = [];
        foreach($question->answers as $answer) {
            $responses[$answer->response->user->email] = $answer->answer;
        }

        unset($question->answers);


        return response()->json(['question' => $question, 'responses' => $responses]);
    }
}
