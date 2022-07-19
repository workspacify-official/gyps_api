<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserReport;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = UserReport::where('user_id', Auth::id())
                             ->leftjoin('users', 'users.id', '=',  'user_reports.report_user_id')
                             ->select('users.name', 'users.photo', 'user_reports.report_date')
                             ->paginate(10);
        return response()->json($reports, 200);
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
                'report_id' => 'required|numeric'
            ];
             $customesmessge = [
                'report_id.required' => 'Report id is required',
                'report_id.numeric' => 'Report id is numeric value',
            ];

            $validations = Validator::make($alldata, $rules, $customesmessge);

            if($validations->fails()){
                return response()->json([$validations->errors()], 422);
            }

            $datasave                 = new UserReport();
            $datasave->report_user_id = $request->report_id;
            $datasave->user_id   = Auth::id();
            $datasave->report_date   = date('Y-m-d');
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
