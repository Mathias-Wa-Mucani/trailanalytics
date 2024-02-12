<?php

namespace App\Http\Controllers;

use App\Models\Clocking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function index()
    {
        if (Auth::id() == 1) {
            $data['users'] = DB::table('user_details')->get();
        } else {
            $data['users'] = DB::table('user_details')->where('id', Auth::id())->get();
        }

        return $this->view('dashboard.users.index', $data);

    }
    public function get_user_clocking_details(Request $request)
    {
        $data['clocking_details'] = DB::table('clocking')->where('user_id', $request->user_id)->get();

        return $this->view('dashboard.reports.clocking-details', $data);

    }



}
