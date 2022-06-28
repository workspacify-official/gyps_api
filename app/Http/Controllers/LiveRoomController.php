<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveRoom;
use App\Models\live_rooms_participant;
use Illuminate\Support\Facades\Validator;
use Auth;
use Image;

class LiveRoomController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ismethod('post')) {

            $data = $request->all();

            $rules = [
                'seat_type' => 'required',
            ];

            $customMessage = [
                'seat_type.required' => 'Seat type is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $room = new LiveRoom();
            
            $room->user_id = Auth::user()->id;
            $room->title = trim($request->title);
            $room->seat_type = trim($request->seat_type);
            if($request->tags){
                 $room->taxvalues =  implode(',', $request->tags);
            }
            $room->visitor      = $request->ip();
           

            if ($request->hasFile('picture')) {
                $photo           = $request->file('picture');
                $destinationPath = public_path('/live_room');
                $name = time() . '.' . $photo->getClientOriginalName();
                $imgFile = Image::make($photo->getRealPath());
                $imgFile->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                })->save($destinationPath . '/' . $name);
                $room->picture = $name;
                $destinationPath = public_path('/live_room_orginal');
                $photo->move($destinationPath, $name);
            }

            $room->save();
           
            $room_partici = new live_rooms_participant();
            $room_partici->room_id = $room->id;
            $room_partici->user_id = Auth::user()->id;
            $room_partici->save();
            $message = 'User Successfully registerd';
            return response()->json(['message' => $message, 'room_information' => $room], 200);

        }else{
             return response()->json(['message' => 'Invalid'], 201);
        }
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
