<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Response;
use Str;
use PDF;
use Laravel\Socialite\Facades\Socialite;


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

    public function auth_github(Request $request)
    {
        return Socialite::driver('github')->redirect();

    }
    public function auth_github_callback()
    {
        // return 'auth callback';
        $githubUser = Socialite::driver('github')->user();
        // dd($githubUser);
        $user = User::updateOrCreate([
            'email' => $githubUser->email,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'avatar' => $githubUser->avatar,
            'password' => Hash::make(Str::random(24)),
            // 'github_token' => $githubUser->token,
            // 'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');

    }
    public function auth_google(Request $request)
    {
        return Socialite::driver('google')->redirect();

    }
    public function auth_google_callback()
    {
        // return 'auth callback';
        $googleUser = Socialite::driver('google')->user();
        // dd($googleUser);
        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'avatar' => $googleUser->avatar,
            'password' => Hash::make(Str::random(24)),
            // 'github_token' => $githubUser->token,
            // 'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');

    }

    // Generate PDF
    public function create_PDF()
    {
        // retreive all records from db
        $data['users'] = DB::table('user_details')->get();
        // $data['users'] = User::all();

        $pdf = PDF::loadView('dashboard.users.PDF.users', $data);
        // download PDF file with download method
        return $pdf->stream("users.pdf", array("Attachment" => false));
    }

    // export all products to csv file
    public function create_CSV()
    {
        $users = DB::table('user_details')->get();
        // return print_r($data);
        $filename = 'Users list as of ' . date('Y-m-d').".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Name', 'Email', 'Role', 'Create Date']); // Add more headers as needed

        foreach ($users as $user) {
            fputcsv($handle, [$user->name, $user->email, $user->role_name, $user->created_at]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);


    }



}
