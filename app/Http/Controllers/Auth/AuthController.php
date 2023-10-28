<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function register(Request $request) {


        if ($request->has('usertype')) {
            $usertype = $request->input('usertype');
        } else {
            return response()->json(['error' => 'Usertype is required'], 400);
        }

        if ($usertype == 'guest') {

            $fields = $request->validate([
                "name" => "required|string",
                "email" => "required|string",
                "phone" => "required|integer",
                'usertype' => 'required|string'
            ]);


            $user = User::create([
                "name" => $fields['name'],
                "email" => $fields['email'],
                "phone" => $fields['phone'],
                "usertype" => $usertype,
            ]);
            
            return response()->json($user, 201);
            
            } elseif($usertype == 'user') {
        
            $fields = $request->validate([
                "password" => 'required|string',
                "email" => "required|string|unique:users,email",
                "name" => "required|string",
                "phone" => "required|integer",
                'usertype' => 'required|string'

            ]);
            
            $user = User::create([
                "name" => $fields['name'],
                "email" => $fields['email'],
                "phone" => $fields['phone'],
                "usertype" => $usertype,
                "password" => bcrypt($fields['password'])
            ]);
            
            $token = $user->createToken('myapptoken')->plainTextToken;
            
            $response = [
                "user" => $user,
                "token" => $token
            ];
            return response()->json($response, 201);
        }
        else {
            return response()->json(['error' => 'invalid user type']);
        }
    }



    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => "logged out"
        ];
    }
    

    public function login(Request $request) {
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'Email not registered'], 404);
        }

        if ($user->usertype === 'guest') {
            return response()->json(['error' => 'Guest users cannot log in'], 403);
        } elseif ($user->usertype === 'user') {
            if (!Hash::check($fields['password'], $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                "user" => $user,
                "token" => $token
            ];

            return response($response, 201);
        } else {
            return response()->json(['error' => 'Invalid user'], 403);
        }
    }

    
}