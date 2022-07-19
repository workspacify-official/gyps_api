<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PostReport;
use Illuminate\Support\Facades\Validator;
use Auth;

class PostReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $porstreport = PostReport::where('post_reports.user_id', Auth::id())
                             ->leftjoin('my_posts', 'my_posts.id', '=',  'post_reports.post_id')
                             ->select('my_posts.*', 'post_reports.report_date')
                             ->paginate(10);
        return response()->json($porstreport, 200);
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
                'post_id' => 'required|numeric'
            ];
             $customesmessge = [
                'post_id.required' => 'Post id is required',
                'post_id.numeric' => 'Post id is numeric value',
            ];

            $validations = Validator::make($alldata, $rules, $customesmessge);

            if($validations->fails()){
                return response()->json([$validations->errors()], 422);
            }

            $datasave                   = new PostReport();
            $datasave->post_id          = $request->post_id;
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
