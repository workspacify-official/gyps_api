<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
class UserProfileViewController extends Controller
{
    
    public function index($id)
    {
       $data['user'] = User::find($id);
       $data['followlist']     = Follower::leftJoin('users', 'users.id', '=', 'followers.following_id')
                                ->where('user_id', $id)
                                ->select('followers.following_id', 'users.name', 'users.photo')
                                ->get();
      $data['following'] = Follower::leftJoin('users', 'users.id', '=', 'followers.user_id')
                                ->where('following_id', $id)
                                ->select('followers.user_id', 'users.name', 'users.photo')
                                ->get();
       return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
