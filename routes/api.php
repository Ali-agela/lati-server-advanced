<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserServerController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersTasksController;
use App\Http\Controllers\UploaderController;


Route::post("/register",[UserController::class,"store"] ) ;
Route::post("/login",[UserController::class,"login"] ) ;

Route::middleware('auth:api')->group(function () {
    Route::get('/user',[UserController::class,'user'] );
    Route::post('/logout',[UserController::class,'logout'] );
    Route::post('/user',[UploaderController::class,'upload'] );



    Route::post('/servers',[ServerController::class,'store'] );
    Route::get('/server',[ServerController::class,'show'] );
    Route::put('/server',[ServerController::class,'update'] );
    Route::delete('/server',[ServerController::class,'destroy'] );

    Route::post('/{code}/join',[UserServerController::class,'store'] );
    Route::delete('/{code}/leave',[UserServerController::class,'destroy'] );
    Route::get('/servers',[UserServerController::class,'index']);

    Route::post('/Task',[TaskController::class,'store'] );
    Route::delete('/Task/{id}',[TaskController::class,'destroy'] );

    Route::post('/tasks',[UsersTasksController::class,'store'] );
    Route::delete('/tasks',[UsersTasksController::class,'destroy'] );
    Route::get('/tasks',[UsersTasksController::class,'index'] );
    Route::put('/tasks/{id}',[UsersTasksController::class,'update'] );
    

});