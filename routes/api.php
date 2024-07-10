<?php


use Illuminate\Support\Facades\Route;
use App\Http\controllers\Api\UserController;

Route::apiResource('/users',UserController::class);


// Route::get('/users',[UserController::class,'index']);
// Route::post('/users',[UserController::class,'store']);
// Route::get('/users/{id}',[UserController::class,'show']);
// Route::patch('/users/{id}',[UserController::class,'update']);
// Route::delete('/users/{id}',[UserController::class,'destroy']);





Route::get('/', function(){
    return response()->json([
        'success'=>true
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
