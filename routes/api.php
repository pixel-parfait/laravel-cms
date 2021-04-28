<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LibraryController;

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

Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('posts/{post}/translate/{locale}', [PostController::class, 'getTranslation']);
    Route::put('posts/{post}/translate/{locale}', [PostController::class, 'translate']);
    Route::apiResource('posts', PostController::class);

    Route::get('pages/{page}/translate/{locale}', [PageController::class, 'getTranslation']);
    Route::put('pages/{page}/translate/{locale}', [PageController::class, 'translate']);
    Route::apiResource('pages', PageController::class);

    Route::get('library', [LibraryController::class, 'index']);
    Route::post('library', [LibraryController::class, 'upload']);
    Route::put('library/{media}', [LibraryController::class, 'update']);

});
