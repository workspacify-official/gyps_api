<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follower;
use Illuminate\Support\Facades\Validator;
use Auth;

class FollowerController extends Controller
{
   
    public function index()
    {
        $user_id = Auth::user()->id;
        $data['following'] = Follower::where('user_id', $user_id)->count();
        $data['follome'] = Follower::where('following_id', $user_id)->count();
        return response()->json($data, 200);

    }
    
    public function create()
    {
        
    }


    public function store(Request $request)
    {
        if($request->isMethod('post')){
            
            $dataall = $request->all();
            $rules = ['following_id' => 'required|integer'];
            $messages = [
                'following_id.required' => 'Following id is required',
                'following_id.integer' => 'Following id is invalid',
            ];

            $validations  = Validator::make($dataall, $rules, $messages);

            if($validations->fails()){
                return response()->json($validations->errors(), 422);
            }

            $datasave = new Follower();
            $datasave->following_id = $request->following_id;
            $datasave->user_id      = Auth::user()->id;
            $datasave->save();
            return response()->json(['status' => 'success', 'messages' => 'Data has been saved success'], 200);

        }else{
            return response()->json(['messages' => 'Invalid request'], 422);
        }
    }

    public function show($id)
    {
        
    }

   
    public function edit($id)
    {
        
    }

  
    public function unfollowing(Request $request)
    {
        if($request->isMethod('post')){
            
            $user_id = Auth::user()->id;

            $dataall = $request->all();
            $rules = ['following_id' => 'required|integer'];
            $messages = [
                'following_id.required' => 'Following id is required',
                'following_id.integer' => 'Following id is invalid',
            ];

            $validations  = Validator::make($dataall, $rules, $messages);

            if($validations->fails()){
                return response()->json($validations->errors(), 422);
            }

            $following_id  = $request->following_id;
           
            Follower::where('user_id', $user_id)->where('following_id', $following_id)->delete();

            return response()->json(['status' => 'success', 'messages' => 'Unfollower success'], 200);

        }else{
            return response()->json(['messages' => 'Invalid request'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
