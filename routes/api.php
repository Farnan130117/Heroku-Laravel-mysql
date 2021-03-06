<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login',function (){
        return sendError('Unauthorised', ['error' => 'Unauthorised'], 401);
    })->name('login');

    Route::middleware('auth:api')->group(function (){
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/authuser', [AuthController::class, 'authuser']);
        Route::middleware([\App\Http\Middleware\CheckRole::class])->group(function() {
            Route::post('/rolecheck', [AuthController::class, 'rolecheck'])->name('rolechecker');
            Route::post('/permissioncheck/{id}', [AuthController::class, 'permissioncheck'])->name('permissionchecker');

        });
    });

});
