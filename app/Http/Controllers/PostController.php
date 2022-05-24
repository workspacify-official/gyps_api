<?php
namespace App\Http\Controllers;

use App\Models\MyPost;
use App\Models\PostImages;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $postdata = MyPost::leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($postdata, 200);

    }

    public function mypost()
    {
        $user_id = Auth::id();
        $postdata = MyPost::where('user_id', '=', $user_id)
            ->leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($postdata, 200);

    }

    public function post_delete($id)
    {

        $user_id = Auth::id();
        $images = PostImages::where('post_id', '=', $id)->get();
        $mypost = MyPost::find($id);
        if ($mypost->audio) {
            if (file_exists(public_path('audio/' . $mypost->audio))) {
                unlink(public_path('audio/' . $mypost->audio));
            }
        }

        if ($mypost->audio) {
            if (file_exists(public_path('audio/' . $mypost->audio))) {
                unlink(public_path('audio/' . $mypost->audio));
            }
        }

        if ($mypost->video) {
            if (file_exists(public_path('video/' . $mypost->video))) {
                unlink(public_path('video/' . $mypost->video));
            }
        }

        foreach ($images as $v) {
            if (file_exists(public_path('post_images/' . $v->file_name))) {
                unlink(public_path('post_images/' . $v->file_name));
            }
        }

        $mypost->delete();
        PostImages::where('post_id', $id)->delete();

        return response()->json(['success' => 'Data has been deleted success'], 200);

    }

    public function create()
    {

    }

    public function post_view($id)
    {
        MyPost::find($id)->increment('views');
        exit();
    }

    public function store(Request $request)
    {

        if ($request->ismethod('post')) {

            $data = $request->all();
            $rules = [
                'user_id' => 'required|numeric',
            ];

            $customesmessge = [
                'user_id.required' => 'User id is required',
                'user_id.numeric' => 'Please valid user id',
            ];

            $validations = Validator::make($data, $rules, $customesmessge);

            if ($validations->fails()) {
                return response()->json($validations->errors(), 201);
            }

            $mypost = new MyPost();

            $mypost->user_id = $request->user_id;
            $mypost->title = $request->post_title;
            $mypost->description = $request->description;
            $mypost->location_id = $request->location_id;

            if ($request->tag_freinds) {
                $mypost->tag_freinds = implode(',', json_decode($request->tag_freinds, true));
            }

            if ($request->hasFile('audio')) {
                $audio_name = time() . $request->file('audio')->getClientOriginalName();
                $request->file('audio')->move(public_path('audio'), $audio_name);
                $mypost->audio = $audio_name;
            }

            if ($request->hasFile('video')) {
                $video_name = time() . $request->file('video')->getClientOriginalName();
                $request->file('video')->move(public_path('video'), $video_name);
                $mypost->video = $video_name;
            }

            $mypost->post_ip = $request->ip();
            $mypost->input_date = date('Y-m-d');
            $mypost->save();
            $post_id = $mypost->id;

            $image_data = array();
            $images_names = array();

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($request->file('images') as $file) {

                    $imagessave = new PostImages();
                    $name = time() . $file->getClientOriginalName();
                    $file->move(public_path('post_images'), $name);
                    $imagessave->post_id = $post_id;
                    $imagessave->file_url = asset('public/post_images/' . $name);
                    $imagessave->file_name = $name;
                    $imagessave->save();
                }
            }
            $messages = "Data has been saved success";
            return response()->json(['success' => $messages], 200);

        }

        return response()->json(['Invalid requirest'], 201);

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
