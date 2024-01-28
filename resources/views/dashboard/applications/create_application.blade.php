<?php
use App\Models\FinancialYear;
use App\Models\Quarter;
use App\Models\Bank;
use App\Models\ProjectIndustry;
use App\Models\OldPersonGroup;
$financial_years = FinancialYear::pluck('name', 'dmis_financial_year_id')->prepend('Select', '');
$quarters = Quarter::pluck('name', 'dmis_quarter_id')->prepend('Select', '');
$groups = OldPersonGroup::all();
$project_industries = ProjectIndustry::pluck('name', 'dmis_project_industry_id')->prepend('select', '');
$unit_measures = \App\Models\UnitMeasure::pluck('name', 'name')->prepend('Select', '');
$banks = \App\Models\Bank::pluck('name', 'dmis_bank_id')->prepend('Select', '');
?>

<div class="row justify-content-center">
    <div class="col-md-12">
        <!-- open form using laravelcollective -->
        {!! Form::open([
            'route' => ['store'],
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'form_' . time(),
            'autocomplete' => 'nope',
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('ext', null, ['value' => '0']) }}
        @csrf


        <input type="hidden" name="r_fld[is_final]" class="is-final" value="1">
        {{ Form::hidden('import', null, ['value' => '0', 'class' => 'import']) }}
        {{ Form::hidden('table', 'OldPersonApplication') }}

        {{ Form::hidden('fld_id', @$record->id) }}

        <div class="report-main-header gray h-header">
            <h6> <strong> Part 1: Group Selection and Basic Application Information </strong> </h6>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    <select name="r_fld[rec_b_group_id]" class="form-control" required>
                        <option value=""></option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}"
                                {{ @$record->rec_b_group_id == $group->id ? 'selected' : '' }}>
                                {{ $group->group_name }} - {{ $group->group_number }} </option>
                        @endforeach
                    </select>
                    <label for="">
                        Select a Group<span class='text-danger font-weight-bolder font-size-lg'>*</span>
                    </label>
                </div>

                {{-- <select class="livesearch form-control select2" name="r_fld[pwd_grp_a_registration_id]" required
                    data-search-model="PwdGroupRegistration"
                    data-selected-text="{{ @$record ? @$record->group_name . ' - ' . @$record->group_number : '' }}">
                    @if (@$record)
                        <option value="{{ @$record->pwd_grp_a_registration_id }}" selected
                            data-selected-text="{{ @$record->group->grp_name . ' - ' . @$record->group->grp_number }}">
                            {{ @$record->group->grp_name . ' - ' . @$record->group->grp_number }}
                        </option>
                    @else
                        <option value=""></option>
                    @endif
                </select> --}}
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::select('r_fld[stp_project_industry_id]', $project_industries, @$record->stp_project_industry_id, ['class' => 'form-control', 'required']) }}
                    <label for="">Select the Industry of the desired project<span
                            class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::textarea('r_fld[project_description]', @$record->project_description, ['class' => 'form-control', 'rows' => 3, 'required', 'placeholder' => ' ']) }}
                    {{ Form::label('surname', 'Desired Project Description', ['class' => 'col-md-12required-field']) }}
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::select('r_fld[stp_financial_year_id]', $financial_years, @$record->stp_financial_year_id, ['class' => 'form-control', 'required']) }}
                    <label for="">
                        Financial Year<span class='text-danger font-weight-bolder font-size-lg'>*</span>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::select('r_fld[stp_quarter_id]', $quarters, @$record->stp_quarter_id, ['class' => 'form-control', 'required']) }}
                    <label for="">
                        Quarter<span class='text-danger font-weight-bolder font-size-lg'>*</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[est_total_cost]', GeneralHelper::to_money_format(@$record->est_total_cost), ['class' => 'form-control comma_separated draft', 'data-is-required' => 1]) }}
                    {{ Form::label('surname', 'Estimated Total Cost ( in UGX ONLY )', ['class' => 'required-field']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::number('r_fld[implementation_period]', @$record->implementation_period, ['class' => 'form-control draft', 'data-is-required' => 1]) }}
                    {{ Form::label('surname', 'Estimated Implementation Period (in months ONLY )', ['class' => 'required-field']) }}
                </div>
            </div>
        </div>

        <div class="report-main-header gray md">
            Documents
        </div>

        <div class="row">
            <div class="col-md-6">
                <span class="text-bold">
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'land_availability_proof') ? 'Change:' : '' }}
                    Attach Proof of Land Availability:
                </span>

                {{ Form::label('start_date', 'Attach Proof of Land Availability', ['class' => '']) }}
                {{ Form::file('documents[land_availability_proof]', ['class' => 'input-file image_doc_file']) }}

                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'land_availability_proof'))
                        <a class="text-bold"
                            href="{{ GeneralHelper::getDocLocation(@$record, 'land_availability_proof') }}"
                            target="_blank">
                            View Proof of Land Availability
                        </a>
                    @endif
                </p>
            </div>

            <div class="col-md-6">
                <span class="text-bold required-field">
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'meeting_minutes') ? 'Change:' : '' }}
                    Meeting
                    Minutes:
                </span>

                {{ Form::file('documents[meeting_minutes]', ['class' => 'input-file image_doc_file draft', @$record ? '' : 'data-is-required' => 1]) }}
                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'meeting_minutes'))
                        <a class="text-bold" href="{{ GeneralHelper::getDocLocation(@$record, 'meeting_minutes') }}"
                            target="_blank">
                            View Meeting Minutes
                        </a>
                    @endif
                </p>
            </div>
        </div>


        <div class="report-main-header gray md">
            Part 2: Budget Breakdown
        </div>

        <div class="row">
            <div class="col-md-12">
                <div>Indicate the breakdown of the Project cost for all inputs in thee Table below:</div>
                <table class="table table-condensed table-striped mb30 budget_items_table"
                    id="application_budget_table">
                    <thead>
                        <tr>
                            <th width="10">*</th>
                            <th>Item to be procured</th>
                            <th width="150">Unit of Measure</th>
                            <th width="32">Quantity</th>
                            <th width="150">Unit Price (UGX)</th>
                            <th width="150">Totals (UGX)</th>
                            <th width="300">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hide">
                            <td><input name="form-field-checkbox" class="ace" type="checkbox">
                                <span class="lbl"></span>
                                <input type="hidden" name="budget_item_count[]" value="1">
                                <input type="hidden" name="budget_item[id][]" value="">
                                <input type="hidden" name="budget_item[rec_c_application_id][]"
                                    value="{{ @$record->id }}">
                                {{-- <input type="hidden" name="budget_item[budgetable_type][]"
                                    value="{{ (new OldPersonGroup())->getTable() }}"> --}}
                            </td>
                            <td>
                                {{ Form::text('budget_item[item_name][]', null, ['class' => 'form-control']) }}
                            </td>
                            <td>
                                <div class="clearfix">
                                    {{ Form::select('budget_item[unit_measure][]', @$unit_measures, 1, ['class' => 'form-control', 'required']) }}
                                </div>
                            </td>
                            <td>
                                {{ Form::text('budget_item[quantity][]', null, ['class' => 'form-control comma_separated quantity']) }}
                            </td>

                            <td>
                                {{ Form::text('budget_item[unit_price][]', null, ['class' => 'form-control comma_separated unit_price']) }}
                            </td>

                            <td>
                                {{ Form::text('', null, ['class' => 'form-control sub_total', 'readonly']) }}
                            </td>

                            <td>
                                {{ Form::textarea('budget_item[comments][]', null, ['class' => 'form-control', 'rows' => 2]) }}
                            </td>
                        </tr>

                        @if (@$record)
                            @foreach ($record->budget_items as $budget_item)
                                <tr>
                                    <td><input name="form-field-checkbox" class="ace" type="checkbox">
                                        <span class="lbl"></span>
                                        <input type="hidden" name="budget_item_count[]" value="1">
                                        <input type="hidden" name="budget_item[id][]" value="{{ @$budget_item->id }}">
                                        <input type="hidden" name="budget_item[rec_c_application_id][]"
                                            value="{{ @$record->id }}">
                                        {{-- <input type="hidden" name="budget_item[budgetable_type][]"
                                            value="{{ (new $appMorphModel())->getTable() }}"> --}}
                                    </td>
                                    <td>
                                        {{ Form::text('budget_item[item_name][]', @$budget_item->item_name, ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            {{ Form::select('budget_item[unit_measure][]', @$unit_measures, @$budget_item->unit_measure, ['class' => 'form-control', 'required']) }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ Form::text('budget_item[quantity][]', @$budget_item->quantity, ['class' => 'form-control quantity comma_separated']) }}
                                    </td>

                                    <td>
                                        {{ Form::text('budget_item[unit_price][]', GeneralHelper::to_money_format(@$budget_item->unit_price), ['class' => 'form-control unit_price comma_separated']) }}
                                    </td>

                                    <td>
                                        {{ Form::text('', GeneralHelper::to_money_format(@$budget_item->total()), ['class' => 'form-control sub_total', 'readonly']) }}
                                    </td>

                                    <td>
                                        {{ Form::textarea('budget_item[comments][]', @$budget_item->comments, ['class' => 'form-control', 'rows' => 2]) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-white btn-primary btn-mini mr-10"
                    onClick="addRow('application_budget_table');">
                    <i class="fa fa-plus"></i> Add Item
                </button>
                <button type="button" class="btn btn-white btn-danger btn-mini"
                    onClick="deleteRow('application_budget_table');">
                    <i class="fa fa-remove"></i> Remove selected
                </button>
            </div>
        </div>


        <div class="report-main-header gray md">
            <div class="text-bold"> Part 3: Budget Summary and Source of Funding</div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[total_budget]', @$record ? GeneralHelper::to_money_format(@$record->budgetTotal()) : null, ['class' => 'form-control project_cost', 'readonly']) }}
                    {{ Form::label('surname', '1. What is the total cost of the project?', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[financial_contribution]', GeneralHelper::to_money_format(@$record->financial_contribution), ['class' => 'form-control comma_separated financial_group_contribution draft', 'data-is-required' => 1]) }}
                    {{ Form::label('financial_contribution', '2. What is the financial contribution of the group?', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[requested_amount]', GeneralHelper::to_money_format(@$record->requested_amount), ['class' => 'form-control comma_separated amount_borrowed draft', 'data-is-required' => 1, 'readonly']) }}
                    {{ Form::label('borrowed', '3. How much do you wish to borrow?', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::label('non_financial_contribution', '4. What is the non-financial contribution of the group?', ['class' => 'col-form-label required-field']) }}
                    {{ Form::textarea('r_fld[non_financial_contribution]', @$record->non_financial_contribution, ['class' => 'form-control draft', 'rows' => 4, 'data-is-required' => 1]) }}
                </div>
            </div>
        </div>


        <div class="report-main-header gray md">
            <div class="text-bold"> Part 4: Sales Projection</div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div>Expected sales within one year</div>
                <table class="table table-condensed table-striped mb30 projection_sales_table"
                    id="application_projection_sales_table">
                    <thead>
                        <tr>
                            <th width="10">*</th>
                            <th>Products</th>
                            <th width="150">Quantity</th>
                            <th width="150">Unit Price (UGX)</th>
                            <th width="300">Expected Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hide">
                            <td><input name="form-field-checkbox" class="ace" type="checkbox">
                                <span class="lbl"></span>
                                <input type="hidden" name="sales_projection_count[]" value="1">
                                <input type="hidden" name="sales_projection[id][]" value="">
                                <input type="hidden" name="sales_projection[rec_c_application_id][]"
                                    value="{{ @$record->id }}">
                            </td>
                            <td>
                                {{ Form::text('sales_projection[product_name][]', null, ['class' => 'form-control']) }}
                            </td>
                            <td>
                                {{ Form::text('sales_projection[quantity][]', null, ['class' => 'form-control comma_separated quantity']) }}
                            </td>

                            <td>
                                {{ Form::text('sales_projection[unit_price][]', null, ['class' => 'form-control unit_price comma_separated']) }}
                            </td>

                            <td>
                                {{ Form::text('sales_projection[expected_sale][]', null, ['class' => 'form-control comma_separated sub_total', 'readonly']) }}
                            </td>
                        </tr>

                        @if (@$record)
                            @foreach ($record->sales_projections as $projection)
                                <tr>
                                    <td><input name="form-field-checkbox" class="ace" type="checkbox">
                                        <span class="lbl"></span>
                                        <input type="hidden" name="sales_projection_count[]" value="1">
                                        <input type="hidden" name="sales_projection[id][]"
                                            value="{{ @$projection->id }}">
                                        <input type="hidden" name="sales_projection[rec_c_application_id][]"
                                            value="{{ @$record->id }}">
                                    </td>
                                    <td>
                                        {{ Form::text('sales_projection[product_name][]', @$projection->product_name, ['class' => 'form-control']) }}
                                    </td>
                                    <td>
                                        {{ Form::text('sales_projection[quantity][]', @$projection->quantity, ['class' => 'form-control comma_separated quantity']) }}
                                    </td>

                                    <td>
                                        {{ Form::text('sales_projection[unit_price][]', GeneralHelper::to_money_format(@$projection->unit_price), ['class' => 'form-control comma_separated unit_price']) }}
                                    </td>

                                    <td>
                                        {{ Form::text('sales_projection[expected_sale][]', GeneralHelper::to_money_format(@$projection->expectedSale()), ['class' => 'form-control comma_separated sub_total', 'readonly']) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-white btn-primary btn-mini mr-10"
                    onClick="addRow('application_projection_sales_table');">
                    <i class="fa fa-plus"></i> Add Item
                </button>
                <button type="button" class="btn btn-white btn-danger btn-mini"
                    onClick="deleteRow('application_projection_sales_table');">
                    <i class="fa fa-remove"></i> Remove selected
                </button>
            </div>
        </div>


        <div class="report-main-header gray md">
            <div class="text-bold"> Part 5: Expected Gross Profits and Specialist Comments</div>
        </div>


        <div class="report-main-header md">
            <div class="text-bold"> Expected Gross Profits</div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-floating">
                    {{ Form::text('', @$record ? GeneralHelper::to_money_format(@$record->salesProjectionsTotal()) : 0, ['class' => 'form-control project_total_sales', 'disabled']) }}
                    {{ Form::label('total_sales', 'Total sales', ['class' => 'required-field']) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating">
                    {{ Form::text('', @$record ? GeneralHelper::to_money_format(@$record->budgetTotal()) : 0, ['class' => 'form-control total_project_cost', 'disabled']) }}
                    {{ Form::label('', 'Project Cost', ['class' => 'required-field']) }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-floating">
                    {{ Form::text('', @$record ? GeneralHelper::to_money_format(@$record->grossProfit()) : 0, ['class' => 'form-control total_gross_profit', 'disabled']) }}
                    {{ Form::label('', 'Equals', ['class' => 'required-field']) }}
                </div>
            </div>
        </div>

        {{-- <div class="report-main-header md">
            <div class="text-bold"> Account Details </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[account_number]', @$record->account_number, ['class' => 'form-control remove_characters', 'required']) }}
                    {{ Form::label('account_number', 'Account Number:', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[account_name]', @$record->account_name, ['class' => 'form-control', 'required']) }}
                    {{ Form::label('account_name', 'Account Name:', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::select('r_fld[stp_bank_id]', $banks, @$record->stp_bank_id, ['class' => 'form-control selectize', 'required']) }}
                    {{ Form::label('stp_bank_id', 'Bank:', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[account_branch]', @$record->account_branch, ['class' => 'form-control', 'required']) }}
                    {{ Form::label('account_branch', 'Account Branch:', ['class' => 'col-form-label required-field']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <span class="text-bold required-field">
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'bank_statement') ? 'Change:' : '' }} Bank
                    Statement:
                </span>

                {{ Form::file('documents[bank_statement]', ['class' => 'input-file image_doc_file', @$record ? '' : 'required']) }}

                @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'bank_statement'))
                    <p>
                        <a class="text-bold" href="{{ GeneralHelper::getDocLocation(@$record, 'bank_statement') }}"
                            target="_blank">
                            View Bank Statement
                        </a>
                    </p>
                @endif
            </div>
        </div> --}}

        <div class="report-main-header md">
            <div class="text-bold"> Preparedness of Group for Project </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <span class="required-field">
                    What preparedness has been put in place for the group to achieve their targets e.g. training
                    received, etc
                </span>

                {{ Form::textarea('r_fld[preparedness]', @$record->preparedness, ['class' => 'form-control draft', 'rows' => 3, 'data-is-required' => 1]) }}
            </div>
        </div>


        <div class="row mb-0 mt-4">
            <div class="card-footer d-flex justify-content-center">
                <a href="#" class="btn btn-danger mr-auto" data-bs-dismiss="modal">Cancel</a>
                <button type="button" id="btnSubmitPlantAppnDraft"
                    class="btn btn-warning mx-auto btnSubmitPlantAppnDraft submit-draft btnSubmit"
                    data-submit-draft="1">Save
                    Draft</button>
                <button type="submit" id="btnSubmitPlantAppnFinal"
                    class="btn btn-success xmr-auto btnSubmitPlantAppnFinal btnSubmit">Submit Final</button>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>
