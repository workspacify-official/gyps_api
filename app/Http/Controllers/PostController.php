<?php
namespace App\Http\Controllers;

use App\Models\MyPost;
use App\Models\PostImages;
use App\Models\Follower;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $postdata = MyPost::leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title',
             'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                        'followingcheck' => function ($query) {
                            $query->where('followers.user_id', Auth::id());
                        }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(5);
           return response()->json($postdata, 200);

    }

    public function post_draflist()
    {
         $user_id = Auth::id();
         $postdata = MyPost::leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title',
             'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->where('post_status', 0)
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                        'followingcheck' => function ($query) {
                            $query->where('followers.user_id', Auth::id());
                        }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
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
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                'followingcheck' => function ($query) {
                    $query->where('followers.user_id', Auth::id());
                }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($postdata, 200);
    }


    public function followingpost()
    {
        $user_id      = Auth::id();
        $followersids      = Follower::where('user_id', $user_id)->pluck('following_id');
      $postdata = MyPost::whereIn("my_posts.user_id", $followersids)
            ->leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                'followingcheck' => function ($query) {
                    $query->where('followers.user_id', Auth::id());
                }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(5);
    return response()->json($postdata, 200);

    }

    public function communityhost($id)
    {
        $postdata = MyPost::where("my_posts.community_id", $id)
            ->leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                        'followingcheck' => function ($query) {
                            $query->where('followers.user_id', Auth::id());
                        }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->skip(10)->paginate(5);
        return response()->json($postdata, 200);
    }

    public function communitynew($id)
    {
            $postdata = MyPost::where("my_posts.community_id", $id)
            ->leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
            'followingcheck' => function ($query) {
                $query->where('followers.user_id', Auth::id());
            }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->offset(0)->limit(10)->paginate(5);
        return response()->json($postdata, 200);
    }

    public function communityallpost()
    {
            $postdata = MyPost::whereNotNull("my_posts.community_id")
            ->leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                'followingcheck' => function ($query) {
                    $query->where('followers.user_id', Auth::id());
                }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(10);
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
            if (file_exists(public_path('post_images/orginal/' . $v->file_name))) {
                    unlink(public_path('post_images/orginal/' . $v->file_name));
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

    public function share_count($id)
    {
        MyPost::find($id)->increment('share');
        exit();
    }


    public function store(Request $request)
    {

        if ($request->ismethod('post')) {

            $data = $request->all();
            $rules = [
                'user_id' => 'required|numeric',
                'post_status' => 'required|numeric',
            ];

            $customesmessge = [
                'user_id.required' => 'User id is required',
                'user_id.numeric' => 'Please valid user id',
                'post_status.required' => 'Post status is required',
                'post_status.numeric' => 'Post status is numeric value',
            ];

            $validations = Validator::make($data, $rules, $customesmessge);

            if ($validations->fails()) {
                return response()->json($validations->errors(), 201);
            }

            $mypost = new MyPost();

            $mypost->user_id = Auth::id();
            $mypost->title = $request->post_title;
            $mypost->description  = $request->description;
            $mypost->location_id  = $request->location_id;
            $mypost->community_id = $request->community_id;

            if ($request->tag_freinds) {
                $mypost->tag_freinds = implode(',', json_decode($request->tag_freinds));
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

            $destinationPath = public_path('/post_images');

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($request->file('images') as $file) {

                    $imagessave = new PostImages();
                    $name = time() . $file->getClientOriginalName();

                    $imgFile = Image::make($file->getRealPath());
                    $imgFile->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $name);


                    $file->move(public_path('post_images/orginal'), $name);
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

    
    public function show($id)
    {
        $data['post']   = MyPost::find($id);
        $data['images'] = PostImages::where('post_id', $id)->get();
        return response()->json($data, 200);
    }

    public function edit($id)
    {
        
    }


    public function postmytagslist()
    {
        $user_id = Auth::id();
        $postdata = MyPost::leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->whereRaw("find_in_set('".$user_id."',my_posts.tag_freinds)")
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                'followingcheck' => function ($query) {
                    $query->where('followers.user_id', Auth::id());
                }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($postdata, 200);
    }

    public function postlikemylist()
    {
        $user_id = Auth::id();
        $postdata = MyPost::leftjoin('users', 'users.id', '=', 'my_posts.user_id')
            ->leftjoin('divisions', 'divisions.id', '=', 'my_posts.location_id')
            ->leftjoin('likes', 'likes.post_id', '=', 'my_posts.id')
            ->select('my_posts.id', 'my_posts.user_id', 'my_posts.title', 'my_posts.audio', 'my_posts.location_id', 'my_posts.video', 'my_posts.views', 'my_posts.share', 'my_posts.heart', 'my_posts.diamond', 'my_posts.description', 'my_posts.created_at', 'users.name', 'users.photo', 'divisions.division_name')
            ->where('likes.user_id', $user_id)
            ->with('images')
            ->withCount('comments_count')
            ->withCount('like_count')
            ->with('comments.user:id,name','comments.replies.user:id,name', 'comments.replies.replies.user:id,name','comments.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.user:id,name', 'comments.replies.replies.replies.replies.replies.replies.replies.user:id,name')
            ->withCount(['followingcheck', 
                'followingcheck' => function ($query) {
                    $query->where('followers.user_id', Auth::id());
                }])
            ->withCount(['likecheck', 'likecheck' => function($query){
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json($postdata, 200);
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
        if ($request->ismethod('post')) {

            $data = $request->all();

            $mypost = MyPost::find($id);

    
            $mypost->title        = $request->post_title;
            $mypost->description  = $request->description;
            $mypost->location_id  = $request->location_id;
            $mypost->community_id = $request->community_id;
            $mypost->post_status  = $request->post_status;

            if ($request->tag_freinds) {
                $mypost->tag_freinds = implode(',', json_decode($request->tag_freinds));
            }
            
            $mypost->save();
           
        
            $messages = "Data has been updated success";
            return response()->json(['success' => $messages], 200);
        }

        return response()->json(['Invalid requirest'], 201);
    }


    public function post_public(Request $request, $id)
    {
        if($request->isMethod('post')){

            $data = $request->all();
            $rules = [
                'post_status' => 'required|numeric',
            ];

            $customesmessge = [
                'post_status.required' => 'Post status is required',
                'post_status.numeric' => 'Post status is numeric value',
            ];
            $validations = Validator::make($data, $rules, $customesmessge);
            if ($validations->fails()) {
                return response()->json($validations->errors(), 201);
            }
            $mypost = MyPost::find($id);
            $mypost->post_status = $request->post_status;
            $mypost->save();
            return response()->json(['message' => 'Post public success'], 200);

        }else{
            return response()->json(['messages' => 'Invalid request'], 500);
        }
    }

    
    public function destroy($id)
    {
        //
    }
}
