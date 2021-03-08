<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Type\TypeController;
use App\Http\Controllers\Disponibility\DisponibilityController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\Dashboard\DashboardController;

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
/**
 * Authentication Routes
 */

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login'])->withoutMiddleware(['auth:api']);;
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh'])->withoutMiddleware(['auth:api']);;
    Route::get('user', [AuthController::class,'me']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'dashboard'

], function () {
    Route::get('/', [DashboardController::class,'index']);

});

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function () {
    Route::get('/', [UserController::class,'index']);
    Route::get('/{user:id}', [UserController::class,'show']);
    Route::put('/{user:id}', [UserController::class,'update']);
    Route::delete('/{user:id}', [UserController::class,'delete']);
    Route::post('/', [UserController::class,'store']);


});

Route::group([

    'middleware' => 'api',
    'prefix' => 'doctors'

], function () {
    Route::get('/', [UserController::class,'doctors']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'patients'

], function () {
    Route::get('/', [UserController::class,'patients']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'types'

], function () {
    Route::get('/', [TypeController::class,'index']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'disponibilities'

], function () {
    Route::get('/', [DisponibilityController::class,'index']);
    Route::get('/{disponibility:id}', [DisponibilityController::class,'show']);
    Route::put('/{disponibility:id}', [DisponibilityController::class,'update']);
    Route::delete('/{disponibility:id}', [DisponibilityController::class,'delete']);
    Route::post('/', [DisponibilityController::class,'store']);
});

Route::get('disponibility/options', [DisponibilityController::class,'options']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'schedules'

], function () {
    Route::get('/', [ScheduleController::class,'index']);
    Route::get('/{schedule:id}', [ScheduleController::class,'show']);
    Route::put('/{schedule:id}', [ScheduleController::class,'update']);
    Route::delete('/{schedule:id}', [ScheduleController::class,'delete']);
    Route::post('/', [ScheduleController::class,'store']);


});


