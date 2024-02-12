<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Response;

class UsersController extends Controller
{

    public $module_path;

    public function __construct()
    {
        // $this->module_path = GeneralHelper::DashboardPath('');
    }

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $data['users'] = DB::table('user_details')->get();
        } else {
            $data['users'] = DB::table('user_details')->where('id', Auth::id())->get();
        }

        return $this->view('dashboard.users.index', $data);

    }
    public function load_add_user_modal(Request $request)
    {
        $data = [];
        if ($request->user_id != null) {
            $data['user'] = User::find($request->user_id);
        }

        return $this->view('dashboard.users.modals.add-user', $data);

    }
    public function save_user(Request $request)
    {
        // validate incoming request

        if ($request->user_id == null) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'name' => 'required|string|max:50',
                'password' => 'required|min:4',
                'role_id' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'password' => 'required|min:4',
                'role_id' => 'required'
            ]);
        }

        if ($validator->fails()) {
            return Response()->json(['res' => 'validation_error', 'errors' => implode("<br>", $validator->messages()->all())]);
        }

        // finally store our user
        $user = new User();
        $userData['email'] = $request->email;
        $userData['name'] = $request->name;
        $userData['password'] = Hash::make($request->password);
        $userData['role_id'] = $request->role_id;

        if ($request->user_id != null) { //check if user id exists and update the record or just save
            if ($user->where('id', $request->user_id)->update($userData)) {
                return Response()->json(['res' => 'success']);
            } else {
                return Response()->json(['res' => 'error']);
            }
        } else {
            if (User::insert($userData)) {
                return Response()->json(['res' => 'success']);
            } else {
                return Response()->json(['res' => 'error']);
            }
        }


    }

    public function delete_user(Request $request)
    {
        // validate incoming request

        $validator = Validator::make($request->all(), [

            'user_id' => 'required'
        ]);


        if ($validator->fails()) {
            return Response()->json(['res' => 'validation_error', 'errors' => implode("<br>", $validator->messages()->all())]);
        }

        // finally delete our user
        $user = new User();
        // $userData['email'] = $request->email;
        // $userData['name'] = $request->name;
        // $userData['password'] = Hash::make($request->password);
        // $userData['role_id'] = $request->role_id;

        if ($user->where('id', $request->user_id)->delete()) {
            return Response()->json(['res' => 'success']);
        } else {
            return Response()->json(['res' => 'error']);
        }



    }



}
