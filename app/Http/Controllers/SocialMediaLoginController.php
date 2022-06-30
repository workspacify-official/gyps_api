<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;


class SocialMediaLoginController extends Controller
{
    
    public function login(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
            'firebase_token' => 'required',
        ];

        $customMessages = [
            'email.required' => 'E-mail is required',
            'email.email' => 'E-mail must be a valid email',
            'firebase_token.required' => 'Token is required',
        ];

        $validator = Validator::make($data, $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $users = User::where('firebase_auth_token', $request->firebase_token)->first();
        if(empty($users)){

            $userssave = new User();
            $userssave->email               = $request->email;
            $userssave->firebase_auth_token = $request->firebase_token;
            $userssave->save();
         $users = User::find($userssave->id);
        }
        Auth::login($users);
       $accessTotken = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
                'success' => true,
                'message' => 'Logged in successfully !!',
                'user' => Auth::User(),
                'access_token' => $accessTotken,
        ]);

    }
}
