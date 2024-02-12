<?php

namespace App\Http\Controllers;

use App\Models\Clocking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClockingController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function time_in(Request $request)
    {
        $clocking = new Clocking;
        $clocking->time_in = date('Y-m-d H:i:s');
        $clocking->user_id = Auth::id();
        // $clocking->course = $request->input('course');

        if ($clocking->save()) {
            return Response()->json(['res' => 'success']);
        } else {
            return Response()->json(['res' => 'error']);
        }
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
