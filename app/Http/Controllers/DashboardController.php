<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiDashboardController;

class DashboardController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function index()
    {
        // $data = [];
        // $data['dashboardIndicators']    = ApiDashboardController::dashboard();
        // $data['projectProgress']        = DB::table('view_dashboard_proj_progress_totals')->get();
        // $data['newSources']             = DB::table('view_dashboard_proj_progress_breakdown')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;

        return view('dashboard.index');
        // return view($this->module_path . '.dashboard', $data);
    }
}
