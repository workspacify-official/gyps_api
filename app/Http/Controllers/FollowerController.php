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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

  
    public function update(Request $request, $id)
    {
        
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