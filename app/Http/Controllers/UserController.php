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


    public function profileimagedelete(Request $request)
    {

        $user_id = Auth::user()->id;
        $datasave = User::find($user_id);

        $position = $request->position;

        if($position == 0){

            if($datasave->photo){
                $destinationPath = public_path('/profile/'.$datasave->photo);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

            }  

            $datasave->photo = NULL;

        }else if($position == 1){
             if($datasave->photo1){

                $destinationPath   = public_path('/profile/'.$datasave->photo1);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo1);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

            }
        
        $datasave->photo1 = NULL;
        
        }else if($position == 2){
            if($datasave->photo2){
                $destinationPath   = public_path('/profile/'.$datasave->photo2);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo2);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

            } 
            
         $datasave->photo2 = NULL;

        }else if($position == 3){

             if($datasave->photo3){
                $destinationPath   = public_path('/profile/'.$datasave->photo3);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo3);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }

                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }    

            }

            $datasave->photo3 = NULL;

        }else if($position == 4){

            if($datasave->photo4){
                $destinationPath   = public_path('/profile/'.$datasave->photo4);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo4);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }

                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }
            }

            $datasave->photo4 = NULL;
        }
        

        $datasave->save();
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

    public function profilephotoupload(Request $request)
    {
       
        $user_id = Auth::user()->id;
        $datasave = User::find($user_id);

        if($request->isMethod('post')){

             $data = $request->all();
            $rules = [
                'photo'          => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'position'       => 'required|numeric|min:0|max:4',
            ];

             $cutomemesage = [
                'photo.required'          => 'Images is required',
                'photo.mimes'             => 'Image allowed only png,jpg,jpeg and gif',
                'photo.max'               => 'Image maximum size 1 mb',
                'photo.image'             => 'The must be image upload',
                'position.required'       => 'Position is required',
                'position.numeric'        => 'Position is numeric data',
                'position.min'            => 'Position is minimum 0',
                'position.max'            => 'Position is maximum 4',
            ];

            $validation = Validator::make($data, $rules, $cutomemesage);

            if($validation->fails()){
                return response()->json($validation->errors(), 422);
            }

            $position           = $request->position;

            $photo        = $request->file('photo');
            $destinationPath = public_path('/profile');
            $name       = time().$photo->getClientOriginalName();
            $imgFile = Image::make($photo->getRealPath());
            $imgFile->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            })->save($destinationPath.'/'.$name);
            $destinationPath = public_path('/profile/orginal/');
            $photo->move($destinationPath, $name);

            if($position == 0){

                $destinationPath   = public_path('/profile/'.$datasave->photo);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

                $datasave->photo = $name;


            }else if($position == 1){

                $destinationPath   = public_path('/profile/'.$datasave->photo1);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo1);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

                $datasave->photo1 = $name;


            }else if($position == 2){

                $destinationPath   = public_path('/profile/'.$datasave->photo2);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo2);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }
                $datasave->photo2 = $name;

            }else if($position == 3){

                $destinationPath   = public_path('/profile/'.$datasave->photo3);
                $thumbnailpath     = public_path('/profile/orginal/'.$datasave->photo3);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }

                $datasave->photo3 = $name;

            }else if($position == 4){

                 $destinationPath   = public_path('/profile/'.$datasave->photo4);
                 $thumbnailpath      = public_path('/profile/orginal/'.$datasave->photo4);
                if(file_exists($destinationPath)){
                    unlink($destinationPath);
                }
                if(file_exists($thumbnailpath)){
                    unlink($thumbnailpath);
                }
                $datasave->photo4 = $name;
            }

            $datasave->save();
            return response()->json(['status' => 'success', 'message' => 'Data has been upload success!'], 200);

        }else{
           return response()->json("Invalid url", 422); 
        }

    }
  

    public function profileimagemoving(Request $request)
    {
        if($request->isMethod('post')){

            $data = $request->all();

            $rules = [
                'from_position'       => 'required|numeric|min:0|max:4',
                'to_position'       => 'required|numeric|min:0|max:4',
            ];

            $custommgs = [
                'from_position.required' => 'From position is required',
                'to_position.required'   => 'To position is required',
                'from_position.numeric'  => 'From postion numeric value',
                'to_position.numeric'    => 'To postion numeric value',
                'from_position.min'  => 'From position minimum value 0',
                'to_position.min'    => 'To position minimum value 0',
                'from_position.max'  => 'From position maximum value 4',
                'to_position.max'    => 'To position maximum value 4',
            ];

            $validation = Validator::make($data, $rules, $custommgs);
            if($validation->fails()){
                return response()->json($validation->errors(), 422);
            }


        }else{
            return response()->json(['status' => 'False', 'message' => 'Invalid request'], 422);
        }
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
                $photo->move($destinationPath, $name);
            
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
                $photo1->move($destinationPath, $name1);
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
                $photo2->move($destinationPath, $name2);
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
                $photo3->move($destinationPath, $name3);
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
                $photo4->move($destinationPath, $name4);
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
