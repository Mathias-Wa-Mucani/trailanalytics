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
       
        // $client = new Client();
        // $res = $client->request('POST', 'http://test-nsr.mglsd.go.ug:20190/connect/token', [
        //     'headers' => ['Content-Type' => 'application/json'],
        //     'json' => [

        //         "grant_type" => "password",
        //         "username" => "centricsolutionslimited@gmail.com",
        //         "password" => "247@Centric?"
        //     ]
        // ]);
        // echo $res->getStatusCode();
        // 200
        // echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        // echo $res->getBody();
        // $jsonResponseToken =  json_decode($res->getBody()->getContents(), true);

        // $accessToken =  $jsonResponseToken['access_token'];

        // $adminLists = $client->request('GET', 'http://test-nsr.mglsd.go.ug:20190/api/v1/getGeoLocationsMasterList', [
        //     'headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer {$accessToken}"],
        //     'json' => [

        //         "programmeCode"=>"DG"
        //     ]
        // ]);

        // $jsonResponseAdmins =  json_decode($adminLists->getBody()->getContents(), true);

        // $adminsRes =  $jsonResponseAdmins['geoLocationsMasterList'];
        // return $adminsRes;
        $data['time_ins']  = DB::table('clocking')->where('user_id', Auth::user()->id)->where('time_out', null)->orderBy('id', 'ASC')->limit(1)->get();
            // return print_r($data);
        return $this->view('dashboard.index', $data);
    }
}
