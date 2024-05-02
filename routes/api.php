<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TipController;
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
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'user'])->name('user');
         Route::post('/updateGarden', [AuthController::class, 'updateUserGarden']);
         Route::get('/logout', [AuthController::class, 'signOut']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => '/task'], function () {
        Route::get('/valid', [TaskController::class, 'doWateringTasks']);
        Route::post('/completed', [TaskController::class, 'completedTasks']);
        Route::post('/one', [TaskController::class, 'haveTasks']);
    });

    Route::group(['prefix' => 'plants'], function ($router){
        $router->get('/', [PlantController::class, 'getCategPlant'])->name('get.categPlant');
        $router->get('/{id}', [PlantController::class, 'getCategPlantById'])->name('get.categPlant.by.id');
    });

    Route::group(['prefix' => 'plant'], function ($router){
        $router->get('/month', [PlantController::class, 'getPlantSeason'])->name('get.plant');
        $router->get('/{id}', [PlantController::class, 'getPlantById'])->name('get.plant.by.id');
    });

    Route::group(['prefix' => 'tips'], function ($router){
        $router->get('/', [TipController::class, 'getTips'])->name('get.tip');
        $router->get('/{id}', [TipController::class, 'getTipById'])->name('get.tip.by.id');
    });

    Route::get('/search/plant',[SearchController::class,'searchPlant'])->name('plant.search');
});
