<?php

use App\Http\Controllers\admin\DivisionController;
use App\Http\Controllers\admin\EmojiController;
use App\Http\Controllers\admin\LanguageController;
use App\Http\Controllers\admin\CommunityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PullController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LiveRoomController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\SocialMediaLoginController;
use App\Http\Controllers\LiveRoomChatController;
use App\Http\Controllers\UserProfileViewController;


Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserController::class, 'getuser']);
    Route::post('/my-post', [PostController::class, 'store']);
    Route::post('post-update/{id}', [PostController::class, 'update']);
    Route::get('/get-post', [PostController::class, 'index']);
    Route::get('/mygetpost', [PostController::class, 'mypost']);
    
    Route::get('/followingpost', [PostController::class, 'followingpost']);
    Route::get('/post-edit/{id}', [PostController::class, 'show']);
    Route::get('post-delete/{id}', [PostController::class, 'post_delete']);

    // community
    Route::get('community', [CommunityController::class, 'index']);
    Route::get('community-hot-post/{id}', [PostController::class, 'communityhost']);
    Route::get('community-new-post/{id}', [PostController::class, 'communitynew']);
    Route::get('community-allpost', [PostController::class, 'communityallpost']);


    Route::get('profileview/{id}', [UserProfileViewController::class, 'index']);


    //  live room create
    Route::post('live-room-create', [LiveRoomController::class, 'store']);
    Route::get('live-room', [LiveRoomController::class, 'index']);
    Route::post('live-room-join', [LiveRoomController::class, 'live_room_join']);
    Route::get('live-room-members/{id}', [LiveRoomController::class, 'members']);
    Route::get('live-room-member-leave/{id}', [LiveRoomController::class, 'memberleave']);
    Route::get('live-room-host-leave/{id}', [LiveRoomController::class, 'hostmemberleave']);
    // 
    
    Route::post('room-chat', [LiveRoomChatController::class, 'store']);
    Route::post('room-chat-data/{id}', [LiveRoomChatController::class, 'index']);

    Route::get('/post-view/{id}', [PostController::class, 'post_view']);
    Route::get('/post-share/{id}', [PostController::class, 'share_count']);

    Route::post('/profile-update/{id}', [UserController::class, 'update']);
    Route::post('profileimage-delete', [UserController::class, 'profileimagedelete']);
    Route::post('profile-photo-upload', [UserController::class, 'profilephotoupload']);
    Route::post('profile-image-moving', [UserController::class, 'profileimagemoving']);


    // searching user
    Route::get('search', [SearchController::class, 'index']);


    // post share
    Route::post('share', [ShareController::class, 'store']);



    Route::prefix('pull')->group(function () {
        Route::get('/', [PullController::class, 'index']);
        Route::post('/store', [PullController::class, 'store']);
        Route::get('/edit/{id}', [PullController::class, 'edit']);
        Route::post('/update/{id}', [PullController::class, 'update']);
        Route::get('/delete/{id}', [PullController::class, 'delete']);
    });

     Route::prefix('follower')->group(function () {
        Route::get('/', [FollowerController::class, 'index']);
        Route::post('/store', [FollowerController::class, 'store']);
        Route::post('/unfollowing', [FollowerController::class, 'unfollowing']);
        Route::post('/update/{id}', [FollowerController::class, 'update']);
        Route::get('/delete/{id}', [FollowerController::class, 'delete']);
        Route::get('/follow-list', [FollowerController::class, 'follow_list']);
        Route::get('/following-list', [FollowerController::class, 'following_list']);
    });
    


    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'index']);
        Route::post('/store', [CommentController::class, 'store']);
    });

    Route::prefix('like')->group(function () {
        Route::get('/', [LikeController::class, 'index']);
        Route::post('/store', [LikeController::class, 'store']);
        Route::post('/unlike', [LikeController::class, 'unlike']);
    });


});
//PostController
Route::get('/getCountry', [CountryController::class, 'index']);
Route::get('/getdivision/{id}', [CountryController::class, 'getdivision']);
Route::get('/getlang', [PublicController::class, 'getlang']);
Route::get('/emoji', [PublicController::class, 'emoji']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/add-user', [LoginController::class, 'addUser']);
Route::post('/sendemail', [LoginController::class, 'email_send']);

Route::post('/socail-login', [SocialMediaLoginController::class, 'login']);



// admin panel contrller

// admin controller

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::prefix('division')->group(function () {
        Route::get('/', [DivisionController::class, 'index']);
        Route::get('/form', [DivisionController::class, 'create']);
        Route::post('/store', [DivisionController::class, 'store']);
        Route::get('/edit/{id}', [DivisionController::class, 'edit']);
        Route::post('/update/{id}', [DivisionController::class, 'update']);
        Route::get('/delete/{id}', [DivisionController::class, 'delete']);
    });

    Route::prefix('country')->group(function () {
        Route::get('/', [CountryController::class, 'index']);
        Route::get('/form', [CountryController::class, 'create']);
        Route::post('/store', [CountryController::class, 'store']);
        Route::get('/edit/{id}', [CountryController::class, 'edit']);
        Route::post('/update/{id}', [CountryController::class, 'update']);
        Route::get('/delete/{id}', [CountryController::class, 'delete']);
    });

    Route::prefix('language')->group(function () {
        Route::get('/', [LanguageController::class, 'index']);
        Route::get('/form', [LanguageController::class, 'create']);
        Route::post('/store', [LanguageController::class, 'store']);
        Route::get('/edit/{id}', [LanguageController::class, 'edit']);
        Route::post('/update/{id}', [LanguageController::class, 'update']);
        Route::get('/delete/{id}', [LanguageController::class, 'delete']);
    });

    Route::prefix('emoji')->group(function () {
        Route::get('/', [EmojiController::class, 'index']);
        Route::get('/form', [EmojiController::class, 'create']);
        Route::post('/store', [EmojiController::class, 'store']);
        Route::get('/edit/{id}', [EmojiController::class, 'edit']);
        Route::post('/update/{id}', [EmojiController::class, 'update']);
        Route::get('/delete/{id}', [EmojiController::class, 'delete']);
    });


    Route::prefix('community')->group(function () {
        Route::get('/', [CommunityController::class, 'index']);
        Route::post('/store', [CommunityController::class, 'store']);
        Route::get('/edit/{id}', [CommunityController::class, 'edit']);
        Route::post('/update/{id}', [CommunityController::class, 'update']);
        Route::get('/delete/{id}', [CommunityController::class, 'delete']);
    });



});

