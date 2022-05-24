<?php

use App\Http\Controllers\admin\DivisionController;
use App\Http\Controllers\admin\EmojiController;
use App\Http\Controllers\admin\LanguageController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return Auth::user();
// });

Route::middleware(['auth:api'])->group(function () {

    Route::get('/user', [UserController::class, 'getuser']);

    Route::post('/my-post', [PostController::class, 'store']);
    Route::get('/get-post', [PostController::class, 'index']);
    Route::get('/mygetpost', [PostController::class, 'mypost']);

    Route::get('post-delete/{id}', [PostController::class, 'post_delete']);

    Route::post('/profile-update/{id}', [UserController::class, 'update']);
    Route::get('/post-view/{id}', [PostController::class, 'post_view']);

});
//PostController

Route::get('/getCountry', [CountryController::class, 'index']);
Route::get('/getdivision/{id}', [CountryController::class, 'getdivision']);
Route::get('/getlang', [PublicController::class, 'getlang']);

Route::get('/emoji', [PublicController::class, 'emoji']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/add-user', [LoginController::class, 'addUser']);
Route::post('/sendemail', [LoginController::class, 'email_send']);

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

});
