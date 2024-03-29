<?php


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClockingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsersController;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return     "Connected sucessfully to database ".DB::connection('db_dmis')->getDatabaseName().url('/');
    return view('auth.login');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

 
Route::get('auth-github', [App\Http\Controllers\UsersController::class, 'auth_github'])->name('auth-github');
Route::get('auth-github-callback', [App\Http\Controllers\UsersController::class, 'auth_github_callback'])->name('auth-github-callback');
 
Route::get('auth-google', [App\Http\Controllers\UsersController::class, 'auth_google'])->name('auth-google');
Route::get('auth-google-callback', [App\Http\Controllers\UsersController::class, 'auth_google_callback'])->name('auth-google-callback');


Route::group(['middleware' => ['auth', 'verified']], function () {
    // Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('role:' . RolePermission::ROLE_SYSTEM_ADMINISTRATOR);
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('time-in', [ClockingController::class, 'time_in'])->name('time-in');
        Route::post('time-out', [ClockingController::class, 'time_out'])->name('time-out');
        Route::get('report', [ReportController::class, 'report'])->name('report');
        Route::post('get-user-clocking-details', [ReportController::class, 'get_user_clocking_details'])->name('get-user-clocking-details');
        Route::get('manage-users', [UsersController::class, 'index'])->name('manage-users');
        Route::post('load-add-user-modal', [UsersController::class, 'load_add_user_modal'])->name('load-add-user-modal');
        Route::post('save-user', [UsersController::class, 'save_user'])->name('save-user');
        Route::post('delete-user', [UsersController::class, 'delete_user'])->name('delete-user');
        Route::get('export-users-topdf', [UsersController::class, 'create_PDF'])->name('export-users-topdf');
        Route::get('export-users-tocsv', [UsersController::class, 'create_CSV'])->name('export-users-tocsv');
        Route::get('export-user-report-pdf/{user_id}', [ReportController::class, 'create_PDF'])->name('export-user-report-pdf');
        Route::get('test-api', [DashboardController::class, 'test_api'])->name('test-api');

        
    });
});
