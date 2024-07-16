<?php

// use App\Http\Controllers\UserController;

use App\Http\Controllers\CyberController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Post
Route::post('/cybers', [CyberController::class, 'store']);
Route::post('/cybers/batch', [CyberController::class, 'storeBatch']);

// Get
Route::get('/cybers', [CyberController::class, 'index']);
Route::get('/cybers/{id}', [CyberController::class, 'show']);


// PUT

Route::put('/cybers/{id}', [CyberController::class, 'update']);


// DELETE

Route::delete('/cybers/{id}', [CyberController::class, 'destroy']);
 


