<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pull_file;
use App\Models\Pull_table;
use Auth;
use Image;
use Illuminate\Support\Facades\Validator;


class PullController extends Controller
{
    
    protected $user_id = null;

    public function __construct()
    {
        $this->middleware('auth');
        //$this->user_id = Auth::user()->id;
    }

    public function index()
    {
        $data['pulldata'] = Pull_table::with('images')->get();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        if($request->isMethod('post')){
        
            $alldata = $request->all();
            $rules = [
                'pull_title' => 'required',
                 'files'   => 'required',
                 'files.*' => 'mimes:jpg,jpeg,png|max:20000',
            ];

            $messages = [
                'pull_title.required' => 'Ttitle is required',
                'files.required' => 'Please upload an image',
                'files.*.mimes' => 'Only jpeg and png file are allowed',
                'files.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ];

            $valiation = Validator::make($alldata, $rules, $messages);
            if($valiation->fails()){
                return response()->json($valiation->errors(), 422);
            }

        $datasave =         new Pull_table();
        $datasave->user_id = Auth::user()->id;
        $datasave->pull_title = trim($request->pull_title);
        if($request->date){
        $datasave->date = date('Y-m-d', strtotime($request->date));
        }
        
        if($request->time){
        $datasave->time = $request->time;
        }
        $datasave->save();

        $pull_id        = $datasave->id;

         if($request->hasFile('files')){

           // $photo_name        = time().$request->file('photo')->getClientOriginalName();
           // $request->file('photo')->move(public_path('profile'), $photo_name);
           // $datasave->photo   = $photo_name;
                $files           = $request->file('files');
                $destinationPath = public_path('/profile');

                foreach ($files as $file) {
                    $imagesave = new Pull_file();
                    $name = time() . '.' . $file->getClientOriginalExtension();
                
                    $imgFile = Image::make($file->getRealPath());
                    $imgFile->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $name);

                    $imagesave->extention = $file->getClientOriginalExtension();
                    $imagesave->file_name = $name;
                    $imagesave->pull_id    = $pull_id;
                    $imagesave->save();
                    $destinationPath = public_path('/profile/orginal/');
                    $file->move($destinationPath, $name);
                }


           }
           
           return response()->json(['success' => 'success', 'messages' => 'Data hass saved success'], 200);


        }else{
            return response()->json(['' => 'False', '' => 'Request Invalid'], 433);
        }
    }
   
    public function show($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        
    }

    
    public function destroy($id)
    {
        
    }
}
