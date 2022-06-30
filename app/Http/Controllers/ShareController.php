<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Share;
use App\Models\MyPost;
use Illuminate\Support\Facades\Validator;
use Auth;
class ShareController extends Controller
{
    
    public function index()
    {
        
    }

   
    public function store(Request $request)
    {
        if ($request->ismethod('post')) {

            $data = $request->all();



            $rules = [
                'post_id' => 'required|numeric',
            ];

            $customesmessge = [
                'post_id.required' => 'Post id is required',
                'post_id.numeric' => 'Please valid post id',
            ];

            $validations = Validator::make($data, $rules, $customesmessge);

            if ($validations->fails()) {
                return response()->json($validations->errors(), 201);
            }

            MyPost::find($request->post_id)->increment('share');
            $sharesave = new Share();
            $sharesave->post_id = $request->post_id;
            $sharesave->user_id = Auth::id();
            $sharesave->save();
        
            $messages = "Data has been updated success";
            return response()->json(['success' => $messages], 200);
        }

        return response()->json(['Invalid requirest'], 201);
    }

   
    public function show($id)
    {
        
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
