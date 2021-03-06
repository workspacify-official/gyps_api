<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveRoom;
use App\Models\live_rooms_participant;
use App\Models\LiveRoomChat;
use App\Models\Follower;
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
        $roomlist = LiveRoom::leftJoin('users', 'users.id', '=', 'live_rooms.user_id')
                            ->select('live_rooms.*', 'users.name', 'users.email')
                            ->withCount(['followingcheck', 
                                'followingcheck' => function ($query) {
                                    $query->where('followers.user_id', Auth::id());
                             }])
                            ->paginate(10);
        return response()->json($roomlist, 200);
    }


    public function members($id)
    {
        $data['members'] = live_rooms_participant::where('room_id', $id)
                                        ->leftJoin('users', 'users.id', '=', 'live_rooms_participants.user_id')
                                        ->select('live_rooms_participants.*', 'users.name', 'users.email')
                                        ->withCount(['followingcheck', 
                                        'followingcheck' => function ($query) {
                                            $query->where('followers.user_id', Auth::id());
                                        }])
                                        ->get();

        $data['hostinfo']     = LiveRoom::leftJoin('users', 'users.id', '=', 'live_rooms.user_id')
                                        ->select('live_rooms.*', 'users.name')
                                        ->where('live_rooms.id', $id)->first();

        $data['chatsmgs']      = LiveRoomChat::leftJoin('users','users.id', '=', 'live_room_chats.sender_id')
                                             ->where('room_id', $id)
                                             ->select('live_room_chats.*', 'users.name')
                                             ->orderBy('id', 'DESC')
                                             ->get();               
        return response()->json($data, 200);
    }


    public function memberleave($id)
    {
        live_rooms_participant::where('room_id', $id)->where('live_rooms_participants.user_id', Auth::user()->id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Leave success'], 200);
    }


    public function hostmemberleave($id)
    {
        LiveRoom::find($id)->delete();
        live_rooms_participant::where('room_id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Leave success'], 200);
    }


    public function live_room_join(Request $request)
    {
        if ($request->ismethod('post')) {

            $data = $request->all();

            $rules = [
                'room_id' => 'required',
            ];

            $customMessage = [
                'room_id.required' => 'Room ID is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $listdata['hostinfo']     = LiveRoom::leftJoin('users', 'users.id', '=', 'live_rooms.user_id')
                                        ->select('live_rooms.*', 'users.name')
                                        ->where('live_rooms.id', $request->room_id)->first();

            $totaljoin = live_rooms_participant::where('room_id', $request->room_id)->count();
            if($totaljoin < $listdata['hostinfo']->seat_type){
                  $datasave          = new live_rooms_participant();
                  $datasave->room_id = $request->room_id;
                  $datasave->user_id = Auth::user()->id;
                  $datasave->save();
                $listdata['members'] = live_rooms_participant::where('room_id', $request->room_id)
                                        ->leftJoin('users', 'users.id', '=', 'live_rooms_participants.user_id')
                                        ->select('live_rooms_participants.*', 'users.name', 'users.email')
                                        ->withCount(['followingcheck', 
                                        'followingcheck' => function ($query) {
                                            $query->where('followers.user_id', Auth::id());
                                        }])
                                        ->get();
                return response()->json(['status' => 'success', 'exist_status' => 'false', 'datalist' => $listdata, 'messages' => 'Join success'], 200);

            }else{
                  $listdata['members'] = live_rooms_participant::where('room_id', $request->room_id)
                                        ->leftJoin('users', 'users.id', '=', 'live_rooms_participants.user_id')
                                        ->select('live_rooms_participants.*', 'users.name', 'users.email')
                                        ->withCount(['followingcheck', 
                                        'followingcheck' => function ($query) {
                                            $query->where('followers.user_id', Auth::id());
                                        }])
                                        ->get();
                    return response()->json(['status' => 'success', 'exist_status' => 'false', 'datalist' => $listdata, 'messages' => 'Join success'], 200);
            }
           



        }else{
            return response()->json(['message' => 'Invalid'], 201);
        }
    }


    public function store(Request $request)
    {
        if ($request->ismethod('post')) {

            $data = $request->all();

            $rules = [
                'seat_type' => 'required',
                'status'    => 'required',
            ];

            $customMessage = [
                'seat_type.required' => 'Seat type is required',
                'status.required' => 'Status is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $room = new LiveRoom();
            
            $room->user_id   = Auth::user()->id;
            $room->title     = trim($request->title);
            $room->seat_type = trim($request->seat_type);
            $room->status    = $request->status;
            if($request->tags){
                // $room->taxvalues =  implode(',', $request->tags);
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


            $listdata['hostinfo']     = LiveRoom::leftJoin('users', 'users.id', '=', 'live_rooms.user_id')
                                        ->select('live_rooms.*', 'users.name')
                                        ->where('live_rooms.id', $room->id)->first();

             $listdata['members'] = live_rooms_participant::where('room_id', $room->id)
                                        ->leftJoin('users', 'users.id', '=', 'live_rooms_participants.user_id')
                                        ->select('live_rooms_participants.*', 'users.name', 'users.email')
                                        ->withCount(['followingcheck', 
                                        'followingcheck' => function ($query) {
                                            $query->where('followers.user_id', Auth::id());
                                        }])
                                        ->get();
            $message = 'User Successfully registerd';
            return response()->json(['message' => $message, 'datalist' => $listdata], 200);

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
