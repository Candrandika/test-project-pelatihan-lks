<?php

namespace App\Http\Controllers;

use App\Models\{Response, Answer, Form};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public function createResponse(Request $request)
    {
        $user = $this->getLoggedUser($request);

        $rules = [
            "form_id" => "required|numeric",
            "responses" => "required|array",
            "responses.*" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) return response()->json(['message' => 'Invalid fields', 'errors' => $validator->errors()], 400);

        $form = Form::where('id', $request->form_id)->first();

        if(!$form) return response()->json(["message" => "Form not found"], 404);

        if($form->creator_id != $user->id) {
            $expired_date = Carbon::parse($form->expired);
            $now_date = Carbon::now();
            if($now_date->gt($expired_date)) return response()->json(["message" => "Form is already expired"], 400);
            
            if($form->type == 'private') {
                $can_access = false;
                foreach($form->domain as $dom) {
                    if($dom->domain == explode('@', $user->email)[1]) $can_access = true;
                }
    
                if(!$can_access) return response()->json(["message" => "You don't have any access to this form"], 400);
            }
        }

        try {
            DB::beginTransaction();

            $response = new Response();
            $response->user_id = $user->id;
            $response->form_id = $request->form_id;
            $response->save();

            foreach($request->responses as $key => $res) {
                Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $key,
                    'answer' => $res
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Answer successfully created']);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getResponseUser(Request $request)
    {
        $user = $this->getLoggedUser($request);

        $response = Response::where('form_id', $request->form_id)->where('user_id', $request->user_id)->first();

        if(!$response) return response()->json(["message" => "Form not found"]);

        if($response->form->creator_id != $user->id) return response()->json(["message" => "You don't have access to this form"], 400);

        $data = [];
        
        foreach($response->answer as $answer) {
            $data[$answer->question->question] = $answer->answer;

            if($answer->question->type == 'checkbox') {
                $data[$answer->question->question] = explode(',', $answer->answer);
            }
        }

        return response()->json(['responses' => $data]);
    }

    public function getAllMyResponse(Request $request)
    {
        $user = $this->getLoggedUser($request);

        $responses = Response::where('user_id', $user->id)->with(['form'])->get();
        
        foreach($responses as $response) {
            $dataResponse = [];
            foreach($response->answer as $answer) {
                $dataReponse[$answer->question->question] = $answer->answer;
            }
            $response->answers = $dataReponse;
            unset($response->answer);
        }


        return response()->json(['responses' => $responses]);
    }
}