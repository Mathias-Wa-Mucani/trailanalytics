<?php

namespace App\Http\Controllers;

use App\DataTables\ViewOldPersonGroupDataTable;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(ViewOldPersonGroupDataTable $dataTable)
    {
        $data['title']    = "Groups";
        return $dataTable->render('dashboard.groups.groups', $data);

        // $data['dashboardIndicators']    = ApiDashboardController::dashboard();
        // $data['projectProgress']        = DB::table('view_dashboard_proj_progress_totals')->get();
        // $data['newSources']             = DB::table('view_dashboard_proj_progress_breakdown')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;
        // return $data;
        // return $this->view('dashboard.groups.groups', $data);
        // return view($this->module_path . '.dashboard', $data);
    }
}
