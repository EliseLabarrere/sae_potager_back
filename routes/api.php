<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::get('/login', [AuthController::class, 'loginUser']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'user'])->name('user');
         Route::post('/updateGarden', [AuthController::class, 'updateUserGarden']);
         Route::get('/logout', [AuthController::class, 'signOut']);
    });
});


