<?php

use App\Http\Controllers\VI\AlbumController;
use App\Http\Controllers\VI\ImageManipulationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function() {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('album', AlbumController::class);
        Route::get('image', [ImageManipulationController::class, 'index']);
        Route::get('image/by-album/{album}', [ImageManipulationController::class, 'getByAlbum']);
        Route::post('image/resize', [ImageManipulationController::class, 'resize']);
        Route::delete('image/{image}', [ImageManipulationController::class, 'destroy']);
    });
});
