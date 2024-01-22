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

?>

<div class="row">
    <div class="col-md-6">
        <div class="fv-row mb-3">
            {{ Form::label('parentDistrict', @$district_text, ['class' => 'required-field']) }} <br>
            {{ Form::select('district_id', $districts->pluck('district', 'dcode')->prepend('select', ''), @$record ? @$record->district->id ?? auth()->user()->district_id : auth()->user()->district_id, ['class' => 'form-select- form-select-sm- location_selection District w-100', 'data-control' => '', 'required', 'data-selection-target-model' => 'County', 'data-filter-field' => 'dcode', 'data-required-label' => 'District']) }}
        </div>
    </div>

    <div class="col-md-6">
        {{ Form::label('', @$county_text, ['class' => 'required-field']) }} <br>
        {{ Form::select('county_id', @$record && @$record->district ? @$record->district->counties->pluck('name', 'id') : [], @$record ? @$record->county->id : null, ['class' => 'form-select- form-select-sm- form-select-solid- location_selection select-search- County  w-100', 'required', 'data-selection-target-model' => 'Subcounty', 'data-filter-field' => 'ccode', 'data-control' => '', 'required', 'data-required-label' => 'County']) }}
    </div>

    <div class="col-md-6">
        {{ Form::label('', @$subcounty_text, ['class' => 'required-field']) }} <br>
        {{ Form::select('subcounty_id', @$record && @$record->county ? $record->county->subcounties->pluck('name', 'id') : [], @$record->subcounty->id, ['class' => 'location_selection Subcounty w-100', 'required', 'data-filter-field' => 'scode', 'data-control' => '', 'data-selection-target-model' => 'Parish', 'required', 'data-required-label' => 'Subcounty']) }}
    </div>

    <div class="col-md-6">
        {{ Form::label('', @$parish_text, ['class' => 'required-field']) }} <br>
        {{ Form::select('parish_id', @$record && @$record->subcounty ? $record->subcounty->parishes->pluck('name', 'id') : [], @$record->parish->id, ['class' => 'location_selection Parish w-100', 'required', 'data-filter-field' => 'pcode', 'data-control' => '', 'data-selection-target-model' => 'Village', 'data-required-label' => '1.4 Parish']) }}
    </div>

    <div class="col-md-6">
        {{ Form::label('', @$village_text, ['class' => 'required-field']) }} <br>
        {{ Form::select('r_fld[stp_adm_village_id]', @$record ? @$record->parish->villages->pluck('name', 'id') : [], @$record->village_id, ['class' => 'location_selection Village end-selection w-100', 'required', 'data-control' => '', 'data-required-label' => 'Village']) }}
    </div>
</div>
