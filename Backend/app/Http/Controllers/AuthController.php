<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ];

        $validation = Validator::make($request->all(), $rules);

        if($validation->fails()) return response()->json(['message' => 'Invalid fields', 'errors' => $validation->errors()], 400);

        $user = User::create($validation->validated());

        return response()->json(['message' => 'Register success']);
    }

    public function login(Request $request)
    {
        if(isset($request->token) && $request->token) {
            $user = $this->getLoggedUser($request);

            if($user) return response()->json(["message" => "You already logged in"], 400);
        }

        $user = User::where('email', $request->email)->where('password', $request->password)->first();

        if(!$user) return response()->json(['message' => 'Email or password incorrect'], 401);

        $token = md5($user->email);

        $user->login_tokens =  $token;
        $user->save();

        return response()->json([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function logout(Request $request)
    {
        if(!isset($request->token) || !$request->token) return response()->json(["message" => "Invalid token"], 401);

        $user = $this->getLoggedUser($request);

        if(!$user) return response()->json(["message" => "Invalid token"], 401);

        $user->login_tokens = null;
        $user->save();

        return response()->json(["message" => "Logout success"]);
    }

    public function me(Request $request)
    {
        $user = $this->getLoggedUser($request);
        return response()->json([
            "user" => $user,
            "token" => $request->token
        ]);
    }
}
