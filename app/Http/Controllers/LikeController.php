<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function index()
    {
        
    }

    
    public function store(Request $request)
    {
         if($request->isMethod('post')){

            $datall = $request->all();
            $rules = [
                'post_id' => 'required',
            ];
            $customesmesg = [
                'post_id.required' => 'Post ID is required',
            ];
             
            $validations  = Validator::make($datall, $rules, $customesmesg);
            if($validations->fails()){
                return response()->json($validations->errors(), 433);
            }

            $data          = new Like();
            $data->post_id = $request->post_id;
            $data->user_id = Auth::user()->id;
            $data->save();
            return response()->json(['status' => 'success', 'messages' => 'Data hass saved success!'], 200);


        }else{
            return response()->json(['status' => 'false', 'message' => 'Invalid request'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
