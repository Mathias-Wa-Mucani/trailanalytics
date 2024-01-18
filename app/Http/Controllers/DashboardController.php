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
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function index()
    {
        // $data = [];
        // $data['dashboardIndicators']    = ApiDashboardController::dashboard();
        // $data['projectProgress']        = DB::table('view_dashboard_proj_progress_totals')->get();
        // $data['newSources']             = DB::table('view_dashboard_proj_progress_breakdown')->get();
        // return '<pre>'.json_encode($data['dashboardIndicators']->getdata(), JSON_PRETTY_PRINT);//->access->bgcolor;
        // return print_r($this->globalFunc());
        $client = new Client();
        $res = $client->request('POST', 'http://test-nsr.mglsd.go.ug:20190/connect/token', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [

                "grant_type" => "password",
                "username" => "centricsolutionslimited@gmail.com",
                "password" => "247@Centric?"
            ]
        ]);
        // echo $res->getStatusCode();
        // 200
        // echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        // echo $res->getBody();
        $jsonResponseToken =  json_decode($res->getBody()->getContents(), true);

        $accessToken =  $jsonResponseToken['access_token'];

        // $adminLists = $client->request('GET', 'http://test-nsr.mglsd.go.ug:20190/api/v1/getGeoLocationsMasterList', [
        //     'headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer {$accessToken}"],
        //     'json' => [

        //         "programmeCode"=>"DG"
        //     ]
        // ]);

        // $jsonResponseAdmins =  json_decode($adminLists->getBody()->getContents(), true);

        // $adminsRes =  $jsonResponseAdmins['geoLocationsMasterList'];
        // return $adminsRes;

        return $this->view('dashboard.index');
        // return view($this->module_path . '.dashboard', $data);
    }
}
