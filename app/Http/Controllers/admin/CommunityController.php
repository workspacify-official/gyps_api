<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\Validator;


class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['communitys']       = Community::all();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $datall = $request->all();

            $rules = [
                'communities_name' => 'required|max:255',
                'photo'            => 'required|image|mimes:jpg,jpeg,png,gif|max:1024',
                'backgound_image'  => 'required|image|mimes:jpg,jpeg,png,gif|max:1024',
            ];

            $messages = [
                'communities_name.required' => 'Name is required',
                'communities_name.max'      => 'Name maximum 99 chartcharts',
                'photo.required'            => 'Photo is required',
                'photo.image'               => 'Photo allow only image',
                'photo.mimes'               => 'Photo allow only png,jpg,jpeg and gif',
                'photo.max'                 => 'Photo size maximum 1mb',
                'backgound_image.required'  => 'Background is required',
                'backgound_image.image'     => 'Background image allow only image',
                'backgound_image.mimes'     => 'Background image allow only png,jpg,jpeg and gif',
                'backgound_image.max'       => 'Background image size maximum 1mb',
            ];

            $validations = Validator::make($datall, $rules, $messages);
            if($validations->fails()){
                return response()->json($validations->errors(), 200);
            }

            $datasave                   = new Community();
            $datasave->communities_name = trim($request->communities_name);
            $datasave->note             = trim($request->note);

          
            if($request->hasFile('photo')){
            $photo_file = time().$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('communitys'), $photo_file);
            $datasave->photo = $photo_file;
            }

            // if($request->hasFile('photo')){
            // $file_name = time().$request->file('photo')->getClientOriginalName();
            // $request->file('photo')->move(public_path('community'), $file_name);
            // $datasave->photo        = $file_name;
            // }

            if($request->hasFile('backgound_image')){
            $background_name = time().$request->file('backgound_image')->getClientOriginalName();
            $request->file('backgound_image')->move(public_path('communitys'), $background_name);
            $datasave->backgound_image        = $background_name;
            }

            $datasave->save();
            return response()->json(['status' => 'success', 'messages' => 'Data has been saved success'], 200);

        }else{

            return response()->json(['status' => 'Invalid', 'message' => 'Invalid request'], 422);

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
