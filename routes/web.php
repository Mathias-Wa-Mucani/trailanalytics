<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;



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

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('role:' . RolePermission::ROLE_SYSTEM_ADMINISTRATOR);
    Route::group(['prefix' => 'dashboard'], function () {

        $submenus = DB::table('setup_menu_submenu')/*->where('id IN (SELECT submenu_id FROM view_user_roles_details WHERE id =  "' . $user[0]->role_id . '")')*/->where('flag', true)->orderBy('orders', 'ASC')->get();

        foreach ($submenus as $submenu) {
            if ($submenu->route != "") {
                // Route::get($submenu->route, [strtok($submenu->url , '/') . '::class' .explode('/', $submenu->url  )[1], $submenu->route])->name($submenu->route);

            }
        }
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('op-registration', [RegistrationController::class, 'opregistration'])->name('op-registration');
        Route::get('old-persons-form', [RegistrationController::class, 'oldPersonsForm'])->name('old-persons-form');

        
    });
});
