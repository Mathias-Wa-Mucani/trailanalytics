<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use GuzzleHttp\Client;

class DashboardController extends Controller
{

    public $module_path;

    public function __construct()
    {
    }

    public function index()
    {
       
        
        $data['time_ins']  = DB::table('clocking')->where('user_id', Auth::user()->id)->where('time_out', null)->orderBy('id', 'ASC')->limit(1)->get();
            // return print_r($data);
        return $this->view('dashboard.index', $data);
    }
}
