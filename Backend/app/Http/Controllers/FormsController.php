<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormDomain;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FormsController extends Controller
{
    public function createForm(Request $request)
    {
        $rules = [
            "name" => "required",
            "description" => "required",
            "type" => "required|in:public,private",
            "domains" => "required_if:type,private|array",
            "expired" => "required|date",
            "questions" => "required|array",
            "questions.*.question" => "required",
            "questions.*.description" => "required",
            "questions.*.type" => "required|string|in:text,number,checkbox,select,textarea",
            "questions.*.is_required" => "required|boolean",
            "questions.*.options" => "required_if:questions.*.type,checkbox,select"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) return response()->json([
            'message' => 'Invalid fields',
            'errors' => $validator->errors()
        ], 400);

        $user = $this->getLoggedUser($request);

        try {
            DB::beginTransaction();

            $form = new Form();
            $form->creator_id = $user->id;
            $form->name = $request->name;
            $form->description = $request->description;
            $form->type = $request->type;
            $form->expired = $request->expired;
            $form->save();

            if($form->type == 'private') {
                foreach($request['domains'] as $dom) {
                    FormDomain::create([
                        'form_id' => $form->id,
                        'domain' => $dom
                    ]);
                }
            }

            foreach($request['questions'] as $q) {
                $question = new Question();
                $question->form_id = $form->id;
                $question->question = $q['question'];
                $question->description = $q['description'];
                $question->type = $q['type'];
                $question->is_required = $q['is_required'];
                $question->save();

                if($question->type == "checkbox" || $question->type == "select") {
                    $options = explode(",", $q['options']);
                    foreach($options as $opt) {
                        $option = new Option();
                        $option->question_id = $question->id;
                        $option->option = $opt;
                        $option->save();
                    }
                }
            }

            DB::commit();
            return response()->json(["message" => "Form successfully created"]);
        } catch(\Exception $e) {
            DB::rollBack();

            return response()->json(["message" => $e->getMessage()], 500);
        }

        
    }

    public function getAllForms(Request $request)
    {
        $user = $this->getLoggedUser($request);

        $forms = Form::withCount('respondens')->get();

        return response()->json(['forms' => $forms]);
    }

    public function getMyCreatedForms(Request $request)
    {
        $user = $this->getLoggedUser($request);

        $forms = Form::withCount('respondens')->where('creator_id', $user->id)->get();

        return response()->json(['forms' => $forms]);
    }

    public function getDetailForm(Request $request, $id)
    {

        $user = $this->getLoggedUser($request);

        $form = Form::with([
            'respondens',
            'questions' => function($q) {
                $q->with('options');
            }
        ])->where('id', $id)->first();

        $form->is_creator = true;
        if($form->creator_id != $user->id) {
            $form->is_creator = false;
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
        unset($form->creator_id);
        foreach($form->questions as $q) unset($q->form_id);

        $domains = [];
        foreach($form->domain as $dom) {
            $domains[] = $dom->domain;
        }
        $form->domains = $domains;
        unset($form->domain);

        $new_respondens = [];
        foreach($form->respondens as $res) {
            $new_respondens[] = [
                "name" => $res->user->name,
                "email" => $res->user->email,
                "user_id" => $res->user->id
            ];
        }
        unset($form->respondens);
        $form->respondens = $new_respondens;

        return response()->json(['form' => $form]);
    }
}
