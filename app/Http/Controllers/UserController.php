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
        //$data['profile_photos'] = ProfileImages::where('user_id', $user_id)->get();
        return response()->json($data, 200);
    }


    public function profileimagedelete($id)
    {
        $images = ProfileImages::find($id);
        if($images){
            $destinationPath = public_path('/profile/'.$images->pro_images);
            $thumbnailpath     = public_path('/profile/orginal/'.$images->pro_images);

            if(file_exists($destinationPath)){
                unlink($destinationPath);
                unlink($thumbnailpath);
            }
        }
      
        $images->delete();
        return response()->json(['status' => 'success', 'message' => 'Data has deleted success'], 200);

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

        if($request->hasFile('photo')){

                $photo           = $request->file('photo');
                $destinationPath = public_path('/profile');
                $name = time() . '.' . $photo->getClientOriginalName();
                $imgFile = Image::make($photo->getRealPath());
                $imgFile->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name);

                $datasave->photo = $name;

                $destinationPath = public_path('/profile/orginal/');
                $file->move($destinationPath, $name);
            
           }



           if($request->hasFile('photo1')){
                $photo1           = $request->file('photo1');
                $destinationPath = public_path('/profile');
                $name1 = time() . '.' . $photo1->getClientOriginalName();
                $imgFile1 = Image::make($photo1->getRealPath());
                $imgFile1->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name1);
                $datasave->photo1 = $name1;
                $destinationPath = public_path('/profile/orginal/');
                $file->move($destinationPath, $name1);
           }

           if($request->hasFile('photo2')){
                $photo2           = $request->file('photo2');
                $destinationPath = public_path('/profile');
                $name2 = time() . '.' . $photo2->getClientOriginalName();
                $imgFile2 = Image::make($photo2->getRealPath());
                $imgFile2->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name2);
                $datasave->photo2 = $name2;
                $destinationPath = public_path('/profile/orginal/');
                $file->move($destinationPath, $name2);
           }
            
            if($request->hasFile('photo3')){
                $photo3           = $request->file('photo3');
                $destinationPath = public_path('/profile');
                $name3 = time() . '.' . $photo3->getClientOriginalName();
                $imgFile3 = Image::make($photo3->getRealPath());
                $imgFile3->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name3);
                $datasave->photo3 = $name3;
                $destinationPath = public_path('/profile/orginal/');
                $file->move($destinationPath, $name3);
           }

           if($request->hasFile('photo4')){
                $photo4           = $request->file('photo4');
                $destinationPath = public_path('/profile');
                $name4 = time() . '.' . $photo4->getClientOriginalName();
                $imgFile4 = Image::make($photo4->getRealPath());
                $imgFile4->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name4);
                $datasave->photo4 = $name4;
                $destinationPath = public_path('/profile/orginal/');
                $file->move($destinationPath, $name4);
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
