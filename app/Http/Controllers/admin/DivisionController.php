<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Division;


class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ismethod('post')){

            $data = $request->all();
            $rules = [
                'country_id'        => 'required|numeric',
                'division_name'     => 'required'
            ];

            $mesagescustom = [
                'country_id.required' => 'Country name is required',
                'country_id.numeric'  => 'Please enter country integer value',
                'division_name.required' => 'Division name is required'
            ];

            $validator = Validator::make($data, $rules, $mesagescustom);

            if($validator->fails()){
                return response()->json($validator->errors(), 201);
            }

            $division = new Division();
            $division->country_id       = $request->country_id;
            $division->division_name    = $request->division_name;
            $division->save();
            return response()->json(['success' => 'Data has been saved success'], 200);

        }
        return response()->json('Invalid requiest', 201);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
