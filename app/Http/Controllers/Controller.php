<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;
use App\Models\SubMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view($page = 'home', array $data = [])
    {
        $page = \str_replace('.', '/', $page);
        DB::enableQueryLog();

        // $data = [];
        if (Auth::check()) {
            $position_id = Auth::user()->role_id;
            // $data['mainmenus'] = DB::table('setup_menu_main')->whereIn('id', array(SELECT menu_id FROM view_user_roles_details WHERE id =  "' . Auth::user()->position_id . '")')->where('flag', true)->orderBy('orders', 'ASC')->get();
            $data['mainmenus'] = DB::table('setup_menu_main')->whereIn('id', function ($query) {
                $query->select('menu_id')
                    ->from('view_user_roles_details')
                    ->whereRaw('view_user_roles_details.id', Auth::user()->role_id);
            })->where('flag', true)->orderBy('orders', 'ASC')->get();

            $data['submenus'] = DB::table('setup_menu_submenu')->whereIn('id', function ($query) {
                $query->select('submenu_id')
                    ->from('view_user_roles_details')
                    ->whereRaw('view_user_roles_details.id', Auth::user()->role_id);
            })->where('flag', true)->orderBy('orders', 'ASC')->get();
            // return print_r( $data['submenus']);

            /*
            $data['mainmenus'] = DB::select(
                '
                SELECT * FROM setup_menu_main WHERE id IN (SELECT menu_id FROM view_user_roles_details WHERE id = "' . $position_id . '") AND flag = TRUE ORDER BY orders ASC               
                '
            );
            $data['submenus'] = DB::select(
                "
                SELECT * FROM setup_menu_submenu WHERE id IN (SELECT submenu_id FROM view_user_roles_details WHERE id = '" . $position_id . "') AND flag = TRUE ORDER BY orders ASC               
                "
            );*/

            // return print_r( $data);

        }


        return view($page, $data);
    }
}
