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
