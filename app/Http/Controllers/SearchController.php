<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LiveRoom;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search            = $request->search;

        if($request->type == 'user')
        {
            $users = User::orderBy('name','ASC')
                        ->where('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('id', 'LIKE', '%' . $search . '%')
                        ->paginate(20);
            $room       = array();
        }else if($request->type == 'username'){

            $users = User::orderBy('name','ASC')
                        ->where('email', 'LIKE', '%' . $search . '%')
                        ->paginate(20);
            $room       = array();

        }else if($request->type == 'id'){
            $users = User::orderBy('name','ASC')
                        ->where('id', 'LIKE', '%' . $search . '%')
                        ->paginate(20);
            $room       = array();
        }else if($request->type == 'room'){


        }else{
            $users = User::orderBy('name','ASC')
                        ->where('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('id', 'LIKE', '%' . $search . '%')
                        ->paginate(20);
            $room   = LiveRoom::orderBy('title', 'ASC')
                            ->where('title', 'LIKE', '%' . $search . '%')
                            ->paginate(10);
            
        }

        return response()->json(['users' => $users, 'rooms' => $room], 200);



    }

    
    public function store(Request $request)
    {
        



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
