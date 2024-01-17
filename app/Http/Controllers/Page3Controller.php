<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiDashboardController;

class Page3Controller extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function page3()
    {
        // $data = [];
        // $data['dashboardIndicators']    = ApiDashboardController::dashboard();
        // $data['projectProgress']        = DB::table('view_dashboard_proj_progress_totals')->get();
        // $data['newSources']             = DB::table('view_dashboard_proj_progress_breakdown')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;
        // return print_r($this->globalFunc());

        return $this->view('dashboard.page3');
        // return view($this->module_path . '.dashboard', $data);
    }
}
