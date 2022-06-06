<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Validator;
use Auth;

class CommentController extends Controller
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
                'comment' => 'required'
            ];
            $customesmesg = [
                'post_id.required' => 'Post ID is required',
                'comment.required' => 'Comment is required',
            ];
             
            $validations  = Validator::make($datall, $rules, $customesmesg);
            if($validations->fails()){
                return response()->json($validations->errors(), 433);
            }

            $data = new Comments();
            $data->post_id = $request->post_id;
            $data->comment = $request->comment;
            $data->parent_id = $request->parent_id;
            $data->user_id = Auth::user()->id;
            $data->save();
            return response()->json(['status' => 'success', 'messages' => 'Data hass saved success!'], 200);


        }else{
            return response()->json(['status' => 'false', 'message' => 'Invalid request'], 200);
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
