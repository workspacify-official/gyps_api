<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\LiveRoomChat;



class LiveRoomChatController extends Controller
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
        if($request->isMethod('post')){

            $datall = $request->all();
            $rules = [
                'room_id' => 'required',
                'messages' => 'required',
            ];
            $customesmesg = [
                'room_id.required' => 'Room ID is required',
                'messages.required' => 'Message is required',
            ];
             
            $validations  = Validator::make($datall, $rules, $customesmesg);
            if($validations->fails()){
                return response()->json($validations->errors(), 433);
            }
            
            $datasave = new LiveRoomChat();
            $datasave->room_id   = $request->room_id;
            $datasave->messages  = $request->messages;
            $datasave->sender_id = Auth::id();
            $datasave->save();
            
            $chatsmgs     = LiveRoomChat::leftJoin('users','users.id', '=', 'live_room_chats.sender_id')
                                        ->where('room_id', $request->room_id)
                                        ->select('live_room_chats.*', 'users.name')
                                        ->orderBy('id', 'DESC')
                                        ->get();
            return response()->json(['status' => 'success', 'chatsmgs' => $chatsmgs], 200);


        }else{
            return response()->json(['status' => 'false', 'message' => 'Invalid request'], 422);
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
