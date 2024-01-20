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

    public function module_details(Request $request)
    {
        $model = @$request->Model;
        $model_id = @$request->ModelId;
        $module = @$request->Module;
        $section = @$request->Section;
        $useFile = @$request->UseFile;

        $isView = false;
        //check if details are retrieved from view
        if (Str::contains($model, 'View')) {
            $model = "Views\\" . $model;
            $isView = true;
        }

        $appModelSystem = "\\App\\Models\\" . $model;

        if (!$useFile) $section = $section . '_details';

        $model_id = is_numeric($model_id) ? $model_id : GeneralHelper::decrypt_data($model_id);

        $record = $appModelSystem::find($model_id);
        // $data = $model_::pluck('name', 'id')->prepend('Select ', '');

        if (!@$record) {
            return view('partials.record_not_found');
        }

        $data = array(
            'record' => @$record,
            'menu_selected' => @$module,
            'page_title' => 'Details',
            'request' => @$request
        );
        // dd($record);
        return view(@$module . '.' . $section)->with($data);
    }

    public function module_delete(Request $request)
    {
        $model = @$request->Model;
        $model_id = GeneralHelper::getRecordId($request->ModelId);

        $module = @$request->Module;
        $section = @$request->Section;
        $appModelSystem = "\\App\\Models\\" . $model;

        $delete_reasons = DeleteReason::pluck('reason', 'id')->prepend('Select', '');
        if (in_array(@$section, GeneralHelper::DeletableModules())) {
            $delete_reasons = DeleteReason::where('section', $section)->pluck('reason', 'id')->prepend('Select', '');
        }

        $record = $appModelSystem::find($model_id);
        // $data = $model_::pluck('name', 'id')->prepend('Select ', '');

        $data = array(
            'record' => @$record,
            'section' => @$section,
            'delete_reasons' => $delete_reasons
        );

        return view('partials.delete_model')->with($data);
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
