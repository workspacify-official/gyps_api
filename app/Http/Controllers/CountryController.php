<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Models\Country;
use App\Models\Division;

class CountryController extends Controller
{
  
    public function index()
    {
        $data = Country::all();
        return response()->json($data);
    }

   
    public function getdivision($id)
    {
        $datalist = Division::where('country_id', $id)->get();
        return response()->json(['data' => $datalist], 200);
    }



    public function create()
    {
        
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
                'country_name' => 'required',
                'iso_name' => 'required',
                'country_code' => 'required'
            ];

            $customMessage = [
                'country_name.required' => 'Country name is required',
                'iso_name.required'     => 'Iso name is required',
                'country_code.required' => 'Country code is required'
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(), 201);
            }

            $country = new Country();
            $country->country_name  = $request->country_name;
            $country->iso_name      = $request->iso_name;
            $country->country_code  = $request->country_code;
            $country->save();
            return response()->json(['success' => 'Data has been saved success'], 200);


        }
        return response()->json('Invalid request', 201);
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
