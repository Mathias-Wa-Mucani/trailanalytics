<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use App\DataTables\OpGroupDataTable;
use App\DataTables\ViewElderPersonDataTable;
use App\DataTables\ViewOldPersonDataTable;
use App\DataTables\ViewOpGroupDataTable;
use App\DataTables\ViewOpRegistrationDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function index(ViewOldPersonDataTable $dataTable)
    {
        $data['title']    = "OP Registration";

        // $data['dashboardIndicators']    = ApiDashboardController::dashboard();
        // $data['projectProgress']        = DB::table('view_dashboard_proj_progress_totals')->get();
        // $data['newSources']             = DB::table('view_dashboard_proj_progress_breakdown')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;
        // return $data;
        return $dataTable->render('dashboard.registration.index', $data);
        // return $this->view('dashboard.registration.index', $data);
        // return view($this->module_path . '.dashboard', $data);
    }
    
    public function oldPersonsForm()
    {
        $data['title']          = "Save Old Persons";

        $data['financialYrs']   = DB::connection('db_dmis')->table('stp_financial_year')->get();
        $data['quarters']   = DB::connection('db_dmis')->table('stp_quarter')->get();
        $data['personTypes']   = DB::table('stp_person_type')->get();
        $data['districts']   = DB::table('stp_admin_unit_a_district')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;
        // return $data;
        return $this->view('dashboard.registration.create_old_person', $data);
        // return view($this->module_path . '.dashboard', $data);
    }

}
