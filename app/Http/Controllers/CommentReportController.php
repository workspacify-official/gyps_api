<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommentReport;
use Illuminate\Support\Facades\Validator;
use Auth;


class CommentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $commentsreport = CommentReport::where('comment_reports.user_id', Auth::id())
                             ->leftjoin('comments', 'comments.id', '=',  'comment_reports.comment_id')
                             ->select('comments.*', 'comment_reports.report_date')
                             ->paginate(10);
        return response()->json($commentsreport, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alldata = $request->all();
            $rules = [
                'comment_id' => 'required|numeric'
            ];
             $customesmessge = [
                'comment_id.required' => 'Comment id is required',
                'comment_id.numeric' => 'Comment id is numeric value',
            ];

            $validations = Validator::make($alldata, $rules, $customesmessge);

            if($validations->fails()){
                return response()->json([$validations->errors()], 422);
            }

            $datasave                   = new CommentReport();
            $datasave->comment_id          = $request->comment_id;
            $datasave->user_id          = Auth::id();
            $datasave->report_date      = date('Y-m-d');
            $datasave->save();
            return response()->json(['message' => 'success'], 200);
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
