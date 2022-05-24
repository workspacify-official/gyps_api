<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ProfileImages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Image;
class UserController extends Controller
{

    public function getuser()
    {
        $user_id =  Auth::user()->id;
        $data['userinfo'] = Auth::user();
        $data['profile_photos'] = ProfileImages::where('user_id', $user_id)->get();
        return response()->json($data, 200);
    }


    public function index()
    {
        
    }
   
    public function create()
    {
       
    }

    public function store(Request $request)
    {
       
    }

   
    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

  
    public function update(Request $request, $id)
    {
        if($request->ismethod('post')){

        

            $data = $request->all();

            $rules = [
                'name'          => 'required',
                //'division_id'   => 'required',
                //'gender'        => 'required',
                ///'dob'           => 'required',
                //'language'      => 'required',
                //'privacy_emoji' => 'required',
                
            ];

            $cutomemesage = [
                'name.required'          => 'Name is required',
                //'division_id.required'   => 'Hometown is required',
                //'gender.required'        => 'Gender is required',
                //'dob.required'           => 'Date of birth is required',
                //'language.required'      => 'Language is required',
                //'privacy_emoji.required' => 'Privacy emoji is required',
            ];

            $validator = Validator::make($data, $rules, $cutomemesage);
            if($validator->fails()){
                return response()->json($validator->errors(), 201);
            }

           $datasave                = User::find($id);
           $datasave->name          = $request->name;

           $datasave->division_id   = $request->division_id;

           $datasave->gender        = $request->gender;

           if(!empty($request->dob)){
            $datasave->dob           = date('Y-m-d', strtotime($request->dob));
           }

           //ProfileImages

        if($request->hasFile('photos')){

           // $photo_name        = time().$request->file('photo')->getClientOriginalName();
           // $request->file('photo')->move(public_path('profile'), $photo_name);
           // $datasave->photo   = $photo_name;
                $files = $request->file('photos');
                $destinationPath = public_path('/profile');
                foreach ($files as $file) {
                    $imagesave = new ProfileImages();
                    $name = time() . '.' . $file->getClientOriginalExtension();
                
                    $imgFile = Image::make($file->getRealPath());
                    $imgFile->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $name);

                    $imagesave->pro_images = $name;
                    $imagesave->user_id    = $id;
                    $imagesave->save();
                    $destinationPath = public_path('/profile/orginal/');
                    $file->move($destinationPath, $name);
                }


           }

              
           
            if($request->emoji){
                $datasave->emoji         = implode(',', json_decode($request->emoji, true));
            }
           

           if($request->privacy_emoji){
            $datasave->privacy_emoji = $request->privacy_emoji;
           }

    
           if($request->language){
            $datasave->language      = implode(',', json_decode($request->language, true));
           }
          

           $datasave->save();





           return response()->json(['success'=> 'Profile has been updated success'], 200);
           
        }

        return response()->json("Invalid url", 201);
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
