<?php

<<<<<<< Updated upstream
=======
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
=======

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::get('/login', [AuthController::class, 'loginUser']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'user'])->name('user');
         Route::post('/updateGarden', [AuthController::class, 'updateUserGarden']);
         Route::get('/logout', [AuthController::class, 'signOut']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/task'], function () {
        Route::get('/valid', [TaskController::class, 'doTasks']);
        Route::post('/completed', [TaskController::class, 'completedTasks']);
        Route::post('/one', [TaskController::class, 'haveTasks']);
    });
});


>>>>>>> Stashed changes
