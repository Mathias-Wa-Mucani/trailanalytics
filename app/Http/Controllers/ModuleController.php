<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Classes\ModuleHelper;
use App\Classes\RolePermission;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public $path;

    public function __construct()
    {
        $this->path = '';
    }

    /**
     * Creates module 
     */
    public function create_module(Request $request)
    {
        //    return $request = request()->all();
        // dd($request->module);
        // $module, $section = null, $model = null, $model_id = 0, $child = null, $child_id = 0, $extra = null;

        $module = GeneralHelper::replaceHyphenWithUnderScore($request->Module);
        $section = @$request->Section ? @$request->Section : $module;
        $section = GeneralHelper::replaceHyphenWithUnderScore($section);
        $sub_section = GeneralHelper::replaceHyphenWithUnderScore($request->SubSection);

        $record = null;
        $appModelLong = null;


        $ModelId = GeneralHelper::getRecordId($request->ModelId);

        if (@$request->Model && $ModelId) {
            $model = ModelHelper::generateModelFromString($ModelId);
            $appModelLong = "App\\Models\\" . ucfirst($request->Model);
            $record = $appModelLong::find($ModelId);
        }
        // dd($record);
        if (@$sub_section) {
            $file = $section . '.create_' . $sub_section;
        } else {
            $file = 'create_' . $section;
        }

        if (@$request->ChildModel) {
            $childModelLong = "App\\Models\\" . ucfirst(@$request->ChildModel);
            $childRecord = $childModelLong::find(@$request->ChildModelId);
            // $file = 'create_' .  GeneralHelper::replaceHyphenWithUnderScore(@$request->ChildModel);
        }

        $data = array(
            // 'extra' => @$request->extra,
            // 'fy' => FinancialYear::find(@$request->FyId),
            'module' => $module,
            'section' => $section,
            'sub_section' => @$request->SubSection,
            'record' => @$record,
            'appModelLong' => @$appModelLong,
            'appModel' => @$request->Model,
            'childModel' => @$request->ChildModel,
            'childRecord' => @$childRecord,
            'file' => $file,
            'request' => $request->all()
        );
        // dd($data);
        return view(GeneralHelper::DashboardPath($module . '.' . $file))->with($data);
    }

    /**
     * Handles module counts associated with financial year
     */
    // public function module_fy(FinancialYear $fy, $module)
    // {
    //     $data = array(
    //         'fy' => $fy,
    //         'module' => $module,
    //         'page_title' => "Financial Year",
    //         'page_heading_bc' => $fy->name,
    //         'menu_selected' => $module
    //     );

    //     return view($this->path . '.' . $module . '.' . $module)->with($data);
    // }


    /**
     * Handles modules data associated with a financial year
     */
    public function module_fys($module)
    {
        $data = array(
            'module' => $module,
            'page_title' => "Financial Year",
            'menu_selected' => $module
        );

        return view($this->path . '.' . $module . '.' . $module . '_fy')->with($data);
    }

    /**
     * Lists or displays module data
     */
    // public function module_list($module)
    // {
    //     $module_ = str_replace('-', '_', $module);
    //     $data = array(
    //         'module' => $module,
    //         'menu_selected' => @$module_,
    //         'module_text' => ucwords(str_replace('_', ' ', $module_))
    //     );

    //     /**
    //      * check if user has permission to access module
    //      */
    //     $isAuthorized = true;
    //     switch ($module_) {
    //             /**
    //          * if current listing/module is pwd registration
    //          */
    //         case ModuleHelper::MODULE_REGISTRATION:
    //             if (!ModuleHelper::ModuleAuthorized(RolePermission::PWD_REGISTRATION_FEATURES)) {
    //                 $isAuthorized = false;
    //             }
    //             break;

    //             /**
    //              * if current module is pwd groups
    //              */
    //         case ModuleHelper::MODULE_GROUPS:
    //             if (!ModuleHelper::ModuleAuthorized(RolePermission::PWD_GROUPS_FEATURES)) {
    //                 $isAuthorized = false;
    //             }
    //             break;

    //             /**
    //              * if current module is applications
    //              */
    //         case ModuleHelper::MODULE_GROUP_APPLICATIONS:
    //             if (!ModuleHelper::ModuleAuthorized(RolePermission::GROUP_APPLICATION_FEATURES)) {
    //                 $isAuthorized = false;
    //             }
    //             break;

    //         default:
    //             $isAuthorized = true;
    //             break;
    //     }

    //     if (!@$isAuthorized) {
    //         return ModuleHelper::ModuleUnAuthorizedPage();
    //     }

    //     return view($this->path . '.' . $module_ . '.' . $module_)->with($data);
    // }

    public function load_data(Request $request)
    {
        $model = @$request->Model;
        $model_id = @$request->ModelId;
        $module = @$request->Module;
        $section = @$request->Section ?? $module;
        $section = GeneralHelper::replaceHyphenWithUnderScore($section);
        $appModelSystem = "\\App\\Models\\" . $model;
        $file = 'load_' . $section;

        $record = $appModelSystem::find($model_id);
        // $data = $model_::pluck('name', 'id')->prepend('Select ', '');

        $sub_section = GeneralHelper::replaceHyphenWithUnderScore($request->SubSection);

        if (@$sub_section) {
            $file = $section . '.' . $sub_section;
        } else {
            $file = $section;
        }

        $data = array(
            'record' => @$record,
            'appModel' => @$request->Model,
            'appModelId' => @$model_id,
            'file' => $file
        );

        return view(GeneralHelper::DashboardPath($module . '.' . $file))->with($data);
        // return view($this->path . '.' . $module . '.' . $file)->with($data);
    }

    public function location_helper(Request $request)
    {
        $model = @$request->TargetModel;
        $filterField = @$request->filterField;
        $filterFieldID = @$request->filterFieldID;
        $appModelSystem = "\\App\\Models\\" . $model;

        $results = $appModelSystem::where($filterField, $filterFieldID)->get();
        // dd($results);
        $html = '';
        $html .= '<option data-value="default"></option>';

        if ($model == 'County') {
            foreach ($results as $result) {
                $html .= '<option value=' . $result->ccode . '>' . @$result->county . '</option>';
            }
        } elseif ($model == 'Subcounty') {
            foreach ($results as $result) {
                $html .= '<option value=' . $result->scode . '>' . @$result->subcounty . '</option>';
            }
        } elseif ($model == 'Parish') {
            foreach ($results as $result) {
                $html .= '<option value=' . $result->pcode . '>' . @$result->parish . '</option>';
            }
        } elseif ($model == 'Village') {
            foreach ($results as $result) {
                $html .= '<option value=' . $result->vcode . '>' . @$result->village . '</option>';
            }
        }


        return $html;
    }
}
