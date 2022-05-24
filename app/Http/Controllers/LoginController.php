<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerify;
use App\Models\Email_verfications;
use App\Models\User;
use Auth;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $data = $request->all();

        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => 'E-mail is required',
            'email.email' => 'E-mail must be a valid email',
            'email.exists' => 'E-mail does not exists',
            'password.required' => 'Password is required',
        ];

        $validator = Validator::make($data, $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            $user = Auth::user();
            $accessTotken = Auth::user()->createToken('authToken')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully !!',
                'user' => Auth::User(),
                'access_token' => $accessTotken,
            ]);

        } else {
            $message = 'Invalid email or password';
            return response()->json(['message' => $message], 422);
        }

    }

    public function addUser(Request $request)
    {
        if ($request->ismethod('post')) {

            $data = $request->all();

            $rules = [
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'country_id' => 'required',
                'usertype' => 'required',
                'gender' => 'required',
                'dob' => 'required|date|before:-13 years',
                'verifaction_code' => 'required|exists:email_verfications',
            ];

            $customMessage = [
                'username.required' => 'Username is required',
                'email.required' => 'E-mail is required',
                'email.email' => 'E-mail must be a valid email',
                'email.unique' => 'E-mail address already exists!',
                'password.required' => 'Password is required',
                'country_id.required' => 'Country name is required',
                'usertype.required' => 'Please select user type',
                'gender.required' => 'Please select gender',
                'dob.required' => 'Please enter date of birth',
                'dob.date' => 'Please enter valid date',
                'dob.before' => 'You need to be at least 13 years old',
                'verifaction_code.required' => 'Please enter verification code',
                'verifaction_code.exists' => 'Code is invalid',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = new User;
            $user->name = $request->username;
            $user->email = $request->email;
            $user->country_id = $request->country_id;
            $user->usertype = $request->usertype;
            $user->gender = $request->gender;
            $user->dob = date('Y-m-d', strtotime($request->dob));
            $user->input_date = date('Y-m-d');
            $user->password = Hash::make($request->password);
            $user->save();

            $message = 'User Successfully registerd';
            return response()->json(['message' => $message], 201);

        }

    }

    public function email_send(Request $request)
    {

        if ($request->ismethod('post')) {

            $data = $request->all();

            $rules = [
                'email' => 'required|email|unique:users',
            ];

            $customMesss = [
                'email.required' => 'Please enter email',
                'email.email' => 'Please valid email!',
            ];

            $validator = Validator::make($data, $rules, $customMesss);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $verfaiction_code = mt_rand(111111, 999999);

            Mail::to($request->email)->send(new EmailVerify($verfaiction_code));

            if (Mail::failures()) {
                $messages = 'Email not send!';
                return response()->json([$messages], 422);
            } else {

                $emailsave = new Email_verfications();
                $emailsave->email = $request->email;
                $emailsave->ip_address = $request->ip();
                $emailsave->verifaction_code = $verfaiction_code;
                $emailsave->input_date = date('Y-m-d');
                $emailsave->save();
                $messages = 'Email code send success';
                return response()->json([$messages], 201);
            }

        } else {
            $messages = 'Invlaid request';
            return response()->json(['message' => $message], 422);
        }

    }

    public function checkverifactioncode(Request $request)
    {

        if ($request->ismethod('post')) {
            $data = $request->all();
            $routes = [
                'email' => 'required|email',
                'verifaction_code' => 'required|exists:email_verfications',
            ];

            $customMessage = [
                'email.required' => 'Please enter email',
                'email.email' => 'Please valid email!',
                'verifaction_code.required' => 'Please enter code',
                'verifaction_code.exists' => 'Code is invalid',
            ];

            $validator = Validator::make($data, $routes, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $finddata = Email_verfications::where(array('email' => $request->email, 'verifaction_code' => $request->verifaction_code))->first();
            if ($finddata) {
                $messages = 'Verification success';
                return response()->json([$messages], 201);

                $now = Carbon::now();
                $startDate = Carbon::parse($finddata->created_at)->format('d.m.Y h:m:sa');
                $enddate = Carbon::parse($finddata->created_at)->subMinutes(100)->format('d.m.Y h:m:sa');

            } else {
                $messages = 'Code is invalid!';
                return response()->json(['messages' => $messages], 422);
            }

        }

    }

}
