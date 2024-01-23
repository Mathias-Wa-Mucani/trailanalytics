<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\Page3Controller;
use App\Http\Controllers\SearchController;
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
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        /**
         * Custom CRUD routes 
         */
        // insert and update data
        Route::post('store', [ActionController::class, 'store'])->name('store');

        // delete data
        Route::get('delete/{table?}/{id?}', [ActionController::class, 'delete'])->name('delete');
        Route::get('delete_table_parts/{model}/{part}/{id}',  [ActionController::class, 'delete_table_parts'])->name('delete_table_parts');

        /**
         * Handles file uploads
         */
        Route::post('upload_file/{frm}', [FileUploadController::class, 'upload_file'])->name('upload_file');
        Route::get('download_file/{doc}', [FileUploadController::class, 'download_file'])->name('download_file');
        Route::post('upload_picture', [FileUploadController::class, 'upload_file'])->name('upload_picture');
        Route::get('upload_picture_form/{model}/{model_id}', [FileUploadController::class, 'upload_picture_form'])->name('upload_picture_form');

        /**
         * Handles module operations
         */
        Route::prefix('mdl')->group(function () {
            Route::get('save/module', [ModuleController::class, 'create_module'])->name('module.create');
            Route::get('details', [ModelController::class, 'model_details'])->name('model.details');
            Route::get('delete', [ModelController::class, 'module_delete'])->name('model.delete');
            Route::get('fy/{fy}/{module}', [ModuleController::class, 'module_fy'])->name('module.fy');
            Route::get('fy/{module}', [ModuleController::class, 'module_fys'])->name('module.fys');
            Route::get('filter', [ModelController::class, 'model_filter'])->name('model.filter');
            Route::get('{module}', [ModuleController::class, 'module_list'])->name('module_list');
        });

        Route::get('model-selection-helper', [ModuleController::class, 'model_selection_helper'])->name('model_selection_helper');
        Route::get('model_options/{model}', [ModelController::class, 'model_options'])->name('model_options');
        Route::get('load_data', [ModuleController::class, 'load_data'])->name('load_data');
        Route::get('location-helper', [ModuleController::class, 'location_helper'])->name('location_helper');
        Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

        /**
         * Handles Reports module
         */
        Route::group(
            [
                'prefix' => 'reports',
            ],
            function () {
                // Route::get('statistic-reports', [ReportController::class, 'statistic_reports'])->name('statistic_reports');
                // Route::get('graph-reports', [ReportController::class, 'graph_reports'])->name('graph_reports');
                // Route::get('basic-reports', [ReportController::class, 'basic_reports'])->name('basic_reports');
                Route::get('report-filter', [SearchController::class, 'report_filter'])->name('report-filter');
                // Route::get('{section}/{report_type}', [ReportController::class, 'report_section'])->name('reports_menu');
            }
        );


        // Route::get('page3', [Page3Controller::class, 'page3'])->name('page3');

        $submenus = DB::table('setup_menu_submenu')/*->where('id IN (SELECT submenu_id FROM view_user_roles_details WHERE id =  "' . $user[0]->role_id . '")')*/->where('flag', true)->orderBy('orders', 'ASC')->get();

        foreach ($submenus as $submenu) {
            if ($submenu->route != "") {
                Route::get($submenu->route, [strtok($submenu->url, '/') . '::class' . explode('/', $submenu->url)[1], $submenu->route])->name($submenu->route);
            }

            // Route::get($submenu->route, [strtok($submenu->url , '/') . '::class' .explode('/', $submenu->url  )[1], $submenu->route])->name($submenu->route);


        }


        Route::get('', [DashboardController::class, 'index'])->name('dashboard');

        /**
         * old person registration routes
         */
        Route::group(
            [
                'prefix' => 'registration',
            ],
            function () {
                Route::get('op-registration', [RegistrationController::class, 'opregistration'])->name('op-registration');
                Route::get('old-persons-form', [RegistrationController::class, 'oldPersonsForm'])->name('old-persons-form');
                Route::get('group-registration', [RegistrationController::class, 'group_registration'])->name('group_registration');
            }
        );

    });
});
