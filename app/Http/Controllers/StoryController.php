<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\Validator;
use Auth;
use Image;

class StoryController extends Controller
{
    public function index()
    {
        
        $date = date("Y-m-d H:m:s", strtotime('-24 hours'));
        $storys = Story::leftJoin('users', 'users.id', '=', 'stories.user_id')
                    ->select('users.photo', 'users.name', 'stories.*')
                    ->where('stories.created_at', '>=', $date)
                    ->offset(0)->limit(50)->get();
        return response()->json($storys, 200);
    }

    public function store(Request $request)
    {
        if($request->isMethod('post')){

            $alldata = $request->all();
            $rules = [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif'
            ];
            $custmessge = [
                'image.required' => 'Image is required',
                'image.image' => 'Please upload images',
                'image.mimes' => 'Image allow only png,jpg,jpeg and gif',
            ];

            $validations = Validator::make($alldata, $rules, $custmessge);

            if($validations->fails()){
                return response()->json([$validations->errors()], 422);
            }

            $datasave = new Story();
            $datasave->visitor = $request->ip();
            $datasave->user_id = Auth::id();

            if ($request->hasFile('image')) {
                $photo           = $request->file('image');
                $destinationPath = public_path('/story/thumbanil');
                $name = time() . '.' . $photo->getClientOriginalName();
                $imgFile = Image::make($photo->getRealPath());
                $imgFile->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name);
                $datasave->file_name = $name;
                $datasave->extension = $photo->extension();
                $destinationPath = public_path('/story');
                $photo->move($destinationPath, $name);
            }
            $datasave->save();
            return response()->json(['message' => 'Data has saved success'], 200);



        }else{
            return response()->json(['status' => 'false', 'messages' => 'Request Invalid'], 500);
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
