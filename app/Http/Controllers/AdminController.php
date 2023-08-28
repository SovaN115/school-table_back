<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminController extends Controller
{
    public function auth(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => ['required'],
            'password' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $admin = Admin::where('login', $validated['login'])->get();

        if(!isset($admin[0])){  
            return response()->json([
                'error' => 'Неверный логин или праоль'
            ], 200);
        }

        if($admin[0]['password'] == $validated['password']) {
            $token = Str::random(45);
            Admin::where('id', $admin[0]['id'])->update([
                'token' => $token
            ]);
            return response()->json([
                'token' => $token,
                'user' => $admin
            ], 200);
        } else {
            return response()->json([
                'error' => 'Неверный логин или праоль'
            ], 200);
        }

    }
}
