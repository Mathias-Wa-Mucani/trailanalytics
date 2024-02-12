<?php

namespace App\Http\Controllers;

use App\Models\Clocking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function report()
    {
        $data['users'] = DB::table('users')->get();

        return $this->view('dashboard.reports.index', $data);
        
    }
    public function get_user_clocking_details(Request $request)
    {
        $data['clocking_details'] = DB::table('clocking')->where('user_id', $request->user_id)->get();

        return $this->view('dashboard.reports.clocking-details', $data);
        
    }

    public function time_out(Request $request)
    {
        $clocking = new Clocking;
        $clock_out['time_out'] = date('Y-m-d H:i:s');
        // $clocking->user_id = Auth::id();
        // $clocking->course = $request->input('course');

        if ($clocking->where('user_id', Auth::id())->where('time_out', null)->update($clock_out)) {
            return Response()->json(['res' => 'success']);
        } else {
            return Response()->json(['res' => 'error']);
        }
    }

    
}
