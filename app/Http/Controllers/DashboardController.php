<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use GuzzleHttp\Client;
use App\Http\Controllers\Api\SignupApiController;

class DashboardController extends Controller
{

    public $module_path;

    public function __construct()
    {
    }

    public function index()
    {


        $data['time_ins'] = DB::table('clocking')->where('user_id', Auth::user()->id)->where('time_out', null)->orderBy('id', 'ASC')->limit(1)->get();
        // return print_r($data);
        return $this->view('dashboard.index', $data);
    }

    public function test_api(Request $request)
    {
        // return print_r($this->api_login());
        try {
            $client = new Client();

            $get_users_request = $client->request('GET', 'https://trailanalytics.dbcservicesug.com/api/get-user/'.Auth::id(), [
                'headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer {$this->api_login()}"]
            ]);

            $response = json_decode($get_users_request->getBody()->getContents(), true);
            // $token = $response['token'];

            return print_r($response);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
