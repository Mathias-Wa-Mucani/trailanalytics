<?php

namespace App\Http\Controllers;

use App\Classes\SharedCommons;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\PwdGroupRegistration;

class SearchController extends Controller
{
    function autocomplete(Request $request)
    {
        $appModel = @$request->SearchModel;

        // dd($appModel);
        $searchString = @$request->searchString;
        $column = @$request->column;
        $column_value = @$request->column_value;
        if (str_contains($appModel, 'View')) {
            $model = "App\Models\\Views\\" . $appModel;
        } else {
            $model = "App\Models\\" . $appModel;
        }
        $notIn = @$request->notIn ?? null;
        $notInColumn = @$request->notInColumn ?? 'id';

        $columnIn = @$request->columnIn ?? null;
        $columnInValues = @$request->columnInValues ?? [];

        $records = [];
        $records =  $model::when(@$column && @$column_value, function ($query) use ($column, $column_value) {
            $query->where($column, $column_value);
        })->when($notIn, function ($query) use ($notIn, $notInColumn) {
            $notIn = explode(',', $notIn);
            $query->whereNotIn($notInColumn, $notIn);
        })->when(@$columnIn && @$columnInValues, function ($query) use ($columnIn, $columnInValues) {
            if (@$columnIn && @$columnInValues) {
                $columnInValues = explode(',', $columnInValues);
                $query->whereIn($columnIn, $columnInValues);
            }
        })->search(request()->get('q'), null, true)->paginate(10);

        return response()->json($records);
    }
}
