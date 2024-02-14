<?php

namespace App\Http\Controllers;

use App\Models\Clocking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
class ReportController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function report()
    {
        if (Auth::user()->role_id == 1) {
            $data['users'] = DB::table('users')->get();
        } else {
            $data['users'] = DB::table('users')->where('id', Auth::id())->get();
        }

        return $this->view('dashboard.reports.index', $data);

    }
    public function get_user_clocking_details(Request $request)
    {
        $data['clocking_details'] = DB::table('clocking')->where('user_id', $request->user_id)->get();

        return $this->view('dashboard.reports.clocking-details', $data);

    }

    public function create_PDF($user_id)
    {
        // return print_r($user_id);
        // retreive all records from db
        $data['clocking_details'] = DB::table('clocking')->join('user_details', 'clocking.user_id', '=', 'user_details.id')->select('clocking.*', 'user_details.*')->where('clocking.user_id', $user_id)->get();
        // dd($data);
        $pdf = PDF::loadView('dashboard.reports.PDF.user-report', $data);
        // download PDF file with download method
        return $pdf->stream("users.pdf", array("Attachment" => false));
    }



}
