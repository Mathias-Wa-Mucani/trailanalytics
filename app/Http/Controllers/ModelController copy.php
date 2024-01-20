<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use App\Models\DeleteReason;
use App\Models\FinancialYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    public $path;

    public function __construct()
    {
        // $this->path = '';
    }

    public function model_options($model)
    {
        $request = @request()->all();
        $parentModel = @$request['ParentModel'];
        $parentModelId = @$request['ParentModelId'];
        $model_ = "\\App\\Models\\" . $model;

        if ($parentModel && $parentModelId) {
            $parentModel_ = "\\App\\Models\\" . $parentModel;
            $parentModelRecord = $parentModel_::find($parentModelId);
        }
        // $data = $model_::pluck('name', 'id')->prepend('Select ', '');

        $data = array(
            'parentModel' => @$parentModel,
            'parentModelId' => @$parentModelId,
            'parentModelRecord' => @$parentModelRecord,
            'parentModel_' => @$parentModel_
        );

        return view('partials.options.options_' . $model)->with($data);

        // foreach ($data as $key => $option) {
        //     $result .= '<option value="' . $key . '">' . $option . '</option>';
        // }
        // return $result;
    }

    public function model_details(Request $request)
    {
        $model = @$request->Model;
        $model_id = @$request->ModelId;
        $module = @$request->Module;
        $section = @$request->Section;
        $sub_section = @$request->SubSection;
        $Template = @$request->UseFile;

        $sub_section = GeneralHelper::replaceHyphenWithUnderScore($request->SubSection);


        $templatePath = (@$sub_section) ? $section . '.' . $sub_section :  $section;
        // dd($templatePath);
        // if (@$sub_section) {
        // $file = 
        // } else {
        // }s

        $isView = false;
        //check if details are retrieved from view
        if (Str::contains($model, 'View')) {
            $model = "Views\\" . $model;
            $isView = true;
        }

        $appModelSystem = "\\App\\Models\\" . $model;
        // dd($templatePath);
        if (@$Template) {
            // $templatePath .= '.' . $section;
        } else {
            $templatePath .= '_details';
        }

        // $file = 

        $record = $appModelSystem::find($model_id);
        // $data = $model_::pluck('name', 'id')->prepend('Select ', '');

        if (@!$Template && !@$record) {
            return view('partials.record_not_found');
        }

        $data = array(
            'record' => @$record,
            'menu_selected' => @$module,
            'page_title' => 'Details',
            'request' => @$request
        );
        // dd($record);
        return view(GeneralHelper::DashboardPath(@$module . '.' . $templatePath))->with($data);
    }

    public function module_delete(Request $request)
    {
        $model = @$request->Model;
        $model_id = @$request->ModelId;
        $module = @$request->Module;
        $section = @$request->Section;
        // $appModelSystem = "\\App\\Models\\" . $model;
        $appModel = app("\\App\\Models\\" . $model);
        // $delete_reasons = @$appModel->delete_reasons()->pluck('name', 'id');
        // dd($delete_reasons);
        $record = $appModel::find($model_id);
        // dd($record);
        $data = array(
            'record' => @$record,
            'section' => @$section,
            'delete_reasons' => []
        );
        return view(GeneralHelper::DashboardPath('deletion.delete_' . $section))->with($data);
        // return view('partials.delete_model')->with($data);
    }

    public function model_filter(Request $request)
    {
        $module = @$request->Module;
        $section = @$request->Section;

        $data = array(
            'request' => @$request
        );

        return view(@$module . '.' . $section)->with($data);
    }
}
