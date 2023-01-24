<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\Answer;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    use ResponseTrait;

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required|string|unique:answers,answers',
            'question_id' => 'required|exists:questions,id'
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $answer = Answer::create([
            'answers' => $request->answer,
            'question_id' => $request->question_id
        ]);

        return $this->okResponse('Answer Saved', $answer);
    }
}
