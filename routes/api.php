<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SignupApiController;
use App\Http\Controllers\UsersController;

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
Route::post('/auth/register', [SignupApiController::class, 'signup'])->name('/auth/register');
Route::post('/auth/login', [SignupApiController::class, 'login'])->name('/auth/loogin');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('get-users', [UsersController::class,'get_users'])->name('get-users');
    Route::get('get-user/{id}', [UsersController::class,'get_user'])->name('get-user');

});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
