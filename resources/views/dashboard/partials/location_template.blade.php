<?php

use App\Models\District;

$districts = District::get();
// $district_text = $district_text ?? "District";
// $county_text = $county_text ?? "County";
// $subcounty_text = $subcounty_text ?? "Sub-county";
// $parish_text = $parish_text ?? "Parish";
// $village_text = $village_text ?? "Village/LC1";

$district_text = 'District';
$county_text = 'County';
$subcounty_text = 'Subcounty';
$parish_text = 'Parish';
$village_text = 'Village';

$village_field = 'vcode' ?? @$village_field;

// dd(@$record->village);

$draft = 'draft';
if (@$is_required) {
    $draft = '';
}

?>

<div class="row">
    <div class="col-md-6 mt-4">
        <div class="form-floating">
            {{ Form::select('district_id', $districts->pluck('district', 'dcode')->prepend('select', ''), @$record->village->dcode, ['class' => 'form-select form-select-sm location_selection District w-100 '.$draft, 'data-control' => '', 'required', 'data-selection-target-model' => 'County', 'data-filter-field' => 'dcode', 'data-required-label' => 'District', 'data-is-required' => 1]) }}
            {{ Form::label('parentDistrict', @$district_text, ['class' => 'required-field']) }}
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="form-floating">
            {{ Form::select('county_id', @$record && @$record->village ? @$record->village->record_district->counties->pluck('county', 'ccode')->prepend('select', '') : [], @$record && @$record->village ? @$record->village->record_county->ccode : null, ['class' => 'form-select form-select-sm location_selection select-search County  w-100', 'required', 'data-selection-target-model' => 'Subcounty', 'data-filter-field' => 'ccode', 'data-control' => '', 'required', 'data-required-label' => 'County']) }}
            {{ Form::label('', @$county_text, ['class' => 'required-field']) }}
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="form-floating">
            {{ Form::select('subcounty_id', @$record && @$record->village ? $record->village->record_county->subcounties->pluck('subcounty', 'scode') : [], @$record && @$record->village ? @$record->village->record_subcounty->scode : null, ['class' => 'form-select form-select-sm location_selection Subcounty w-100', 'required', 'data-filter-field' => 'scode', 'data-control' => '', 'data-selection-target-model' => 'Parish', 'required', 'data-required-label' => 'Subcounty']) }}
            {{ Form::label('', @$subcounty_text, ['class' => 'required-field']) }}
        </div>
    </div>


    <div class="col-md-6 mt-4">
        <div class="form-floating">
            {{ Form::select('parish_id', @$record && @$record->village ? $record->village->record_subcounty->parishes->pluck('parish', 'pcode') : [], @$record && @$record->village ? @$record->village->record_parish->pcode : null, ['class' => 'form-select form-select-sm location_selection Parish w-100', 'required', 'data-filter-field' => 'pcode', 'data-control' => '', 'data-selection-target-model' => 'Village', 'data-required-label' => 'Parish']) }}
            {{ Form::label('', @$parish_text, ['class' => 'required-field']) }}
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="form-floating">
            {{ Form::select('r_fld[' . $village_field . ']', @$record && @$record->village ? @$record->village->record_parish->villages->pluck('village', 'vcode') : [], @$record->vcode, ['class' => 'form-select form-select-sm location_selection Village end-selection w-100', 'required', 'data-control' => '', 'data-required-label' => 'Village']) }}
            {{ Form::label('', @$village_text, ['class' => 'required-field']) }}
        </div>
    </div>
