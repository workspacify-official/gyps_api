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
        $storys = Story::groupBy('user_id')
                    ->leftJoin('users', 'users.id', '=', 'stories.user_id')
                    ->select('users.photo', 'users.name', 'stories.user_id')
                    ->where('stories.created_at', '>=', $date)
                    ->with(['storys', 
                        'storys' => function ($query) {
                            $date = date("Y-m-d H:m:s", strtotime('-24 hours'));
                            $query->where('stories.created_at', '>=', $date);
                        }])
                    ->get();
        return response()->json($storys, 200);
    }

    public function store(Request $request)
    {
        if($request->isMethod('post')){

            $alldata = $request->all();
            $rules = [
                'image' => 'image|mimes:jpg,png,jpeg,gif',
                'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
            ];
            $custmessge = [
                'image.image' => 'Please upload images',
                'image.mimes' => 'Image allow only png,jpg,jpeg and gif',
                'video.mimes' => 'Image allow only mp4,ogx,ogv,ogg and webm',
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
                $datasave->image     = $name;
                $datasave->extension = $photo->extension();
                $destinationPath = public_path('/story');
                $photo->move($destinationPath, $name);
            }

            $datasave->text         = $request->text;
            $datasave->color        = $request->color;

            if($request->hasFile('video')){
                $file = $request->file('video');
                $filename =  time() . '.' .$file->getClientOriginalName();
                $path = public_path('/story/video');
                $file->move($path, $filename);
                $datasave->video     = $filename;
                $datasave->extension = $file->extension();
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
