<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emoji;

class EmojiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ismethod('post')){

            $data = $request->all();
            $rules = [
                'gift_file' => 'required'
            ];

            $custommessge = [
                'gift_file.required' => 'Gift file is required'
            ];

            $validations = Validator::make($data, $rules, $custommessge);
            if($validations->fails()){
                return response()->json($validations->errors(), 401);
            }

            $datasave = new Emoji();
            $datasave->emoji_title = $request->emoji_title;

            if($request->hasFile('gift_file')){
            $gift_file = time().$request->file('gift_file')->getClientOriginalName();
            $request->file('gift_file')->move(public_path('emoji'), $gift_file);
            $datasave->emoji_file_name = $gift_file;
            }

            $datasave->save();
            return response()->json(['status' => true, 'messages' => 'Data has been saved success'], 200); 
            //Validator
        }else{
            return response()->json(['status' => false, 'messages' => 'Invalid request'], 401); 
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
