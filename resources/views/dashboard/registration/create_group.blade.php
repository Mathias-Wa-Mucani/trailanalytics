<?php
use App\Models\FinancialYear;
use App\Models\Quarter;
$financial_years = FinancialYear::pluck('name', 'id')->prepend('Select', '');
$quarters = Quarter::pluck('name', 'id')->prepend('Select', '');
$group_roles = \App\Models\GroupRole::all();
$members = \App\Models\OpRegistration::all();

// dd($members);

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
        ]) !!}
        {{ Form::hidden('ext', null, ['value' => '0']) }}
        @csrf

        {{ Form::hidden('table', 'OpGroupRegistration') }}

        {{ Form::hidden('fld_id', @$record->id) }}

        <div class="report-main-header gray h-header">
            <h6> <strong> Older Persons Group Registration Form </strong> </h6>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::select('r_fld[stp_financial_year_id]', $financial_years, @$record->stp_financial_year_id, ['class' => 'form-control form-control-solid', 'placeholder' => ' ', 'required']) }}
                    {{ Form::label('', 'Financial Year', ['class' => 'required-field']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::select('r_fld[stp_quarter_id]', $quarters, @$record->stp_quarter_id, ['class' => 'form-control form-control-solid', 'placeholder' => ' ', 'required']) }}
                    {{ Form::label('', 'Quarter', ['class' => 'required-field']) }}
                </div>
            </div>
        </div>

        <div class="form-floating mt-2">
            {{ Form::text('r_fld[group_name]', @$record->group_name, ['class' => 'form-control form-control-solid', 'placeholder' => ' ', 'required']) }}
            {{ Form::label('', 'Group Name', ['class' => 'required-field']) }}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::text('r_fld[tin]', @$record->tin, ['class' => 'form-control form-control-solid', 'placeholder' => ' ']) }}
                    {{ Form::label('', 'TIN', ['class' => '']) }}
                </div>
            </div>

            <div class="col-md-6">
                {{ Form::label('', 'Is Home', ['class' => '']) }} <br>
                <div class="form-check form-check-inline mt-4">
                    <input class="form-check-input" type="radio" name="r_fld[is_home]" id="is_home" value="1"
                        required>
                    <label class="form-check-label" for="is_home">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="r_fld[is_home]" id="is_not_home" value="0"
                        required>
                    <label class="form-check-label" for="is_not_home">No</label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[date_established]', null, ['class' => 'form-control form-control-solid datepicker', 'placeholder' => ' ', 'required']) }}
                    {{ Form::label('', 'Date of Establishment', ['class' => 'required-field']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="report-main-header">
                    Location
                </div>
            </div>
        </div>

        @include('dashboard.partials.location_template')

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header">
                    Group Members
                </div>
            </div>
        </div>

        <table class="table table-condensed table-striped mb30" id="group_member_table">
            <thead>
                <tr>
                    <th width="10">*</th>
                    <th class="col-md-6"> {{ __('Select Members') }} </th>
                    <th class="col-md-6"> {{ __('Role') }} </th>
                </tr>
            </thead>
            <tbody>
                <tr class="hide">
                    <td><input name="form-field-checkbox" class="ace" type="checkbox">
                        <span class="lbl"></span>
                        <input type="hidden" name="group_members_count[]" value="1">
                        <input type="hidden" name="group_members[rec_b_group_id][]" value="{{ @$record->id }}">
                        <input type="hidden" name="group_members[id][]" value="">
                    </td>

                    <td class="multiple-live-search_">
                        {{-- <div class="clearfix multiple-live-search select2-100 ">
                            <select class="livesearch form-control" name="group_members[rec_a_elder_id][]"
                                data-search-model="PwdRegistration">
                            </select>
                        </div> --}}
                        <select class="form-control" name="group_members[rec_a_elder_id][]">
                            <option value=""> --select-- </option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"> {{ $member->full_name }} </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <div class="clearfix">
                            <select class="form-control" name="group_members[stp_group_role_id][]">
                                {{-- <option value=""> {{__('Select')}} </option> --}}
                                @foreach ($group_roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ Str::contains(strtolower(@$role->name), 'member') ? 'selected' : '' }}>
                                        {{ $role->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>

                @if (@$record)
                    @foreach ($record->members as $member)
                        <tr>
                            <td><input name="form-field-checkbox" class="ace" type="checkbox">
                                <span class="lbl"></span>
                                <input type="hidden" name="group_members_count[]" value="1">
                                <input type="hidden" name="group_members[pwd_grp_a_registration_id][]"
                                    value="{{ @$record->id }}">
                                <input type="hidden" name="group_members[id][]" value="{{ @$member->id }}">
                            </td>
                            <td>
                                <div class="clearfix">
                                    <select class="form-control" name="group_members[pwd_registration_id][]">
                                        <option value="{{ @$member->pwd->id }}" selected>
                                            {{ @$member->pwd->names . ' - ' . @$member->pwd->pwd_number }} </option>
                                    </select>

                                </div>
                            </td>
                            <td>
                                <div class="clearfix">
                                    <select class="form-control" name="group_members[stp_group_role_id][]">
                                        <option value=""> {{ __('Select') }} </option>
                                        @foreach ($group_roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ @$role->id == @$member->stp_group_role_id ? 'selected' : '' }}>
                                                {{ $role->name }} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
        <div class="col-md-12">
            <button type="button" class="btn btn-white btn-primary btn-sm mr-10"
                onClick="addRow('group_member_table');">
                <i class="fa fa-plus"></i> {{ __('Add Member') }}
            </button>
            <button type="button" class="btn btn-white btn-danger btn-sm" onClick="deleteRow('group_member_table');">
                <i class="fa fa-remove"></i> {{ __('Remove selected') }}
            </button>
        </div>


        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header">
                    Add Photo
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <span class="text-bold">
                    {{ @$record && GeneralHelper::getDocLocation(@$record, 'group_certificate') ? 'Change' : '' }}
                    Group Registration/Certificate:
                </span>

                {{ Form::file('documents[group_certificate]', ['class' => 'input-file image_doc_file', @$record ? '' : '']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record && GeneralHelper::getDocLocation(@$record, 'group_certificate'))
                        <a class="text-bold"
                            href="{{ GeneralHelper::getDocLocation(@$record, 'group_certificate') }}"
                            target="_blank">
                            View Group Registration/Certificate
                        </a>
                    @endif
                </p>

            </div>

            <div class="col-md-6">
                <span class="text-bold required-field">
                    {{ @$record && GeneralHelper::getDocLocation(@$record, 'group_photograph') ? 'Change' : '' }} Group
                    Photograph:
                </span>

                {{ Form::file('documents[group_photograph]', ['class' => 'input-file image_doc_file', @$record ? '' : 'required']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only Images (png, jpeg, jpg) or maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record && GeneralHelper::getDocLocation(@$record, 'group_photograph'))
                        <a class="text-bold" href="{{ GeneralHelper::getDocLocation(@$record, 'group_photograph') }}"
                            target="_blank">
                            View Group Photograph
                        </a>
                    @endif
                </p>

            </div>

            <div class="col-md-6 mt-10">
                <span class="text-bold required-field">
                    {{ @$record && GeneralHelper::getDocLocation(@$record, 'beneficiary_selection_meeting_minutes') ? 'Change' : '' }}
                    Minutes of Beneficiary Selection Meeting:
                </span>

                {{ Form::file('documents[beneficiary_selection_meeting_minutes]', ['class' => 'input-file image_doc_file', @$record ? '' : 'required']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record && GeneralHelper::getDocLocation(@$record, 'beneficiary_selection_meeting_minutes'))
                        <a class="text-bold"
                            href="{{ GeneralHelper::getDocLocation(@$record, 'beneficiary_selection_meeting_minutes') }}"
                            target="_blank">
                            View Minutes of Beneficiary Selection Meeting
                        </a>
                    @endif
                </p>

            </div>

            <div class="col-md-6 mt-10">
                <span class="text-bold">
                    {{ @$record && GeneralHelper::getDocLocation(@$record, 'group_constitution') ? 'Change' : '' }}
                    Group Constitution:
                </span>

                {{ Form::file('documents[group_constitution]', ['class' => 'input-file image_doc_file']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record && GeneralHelper::getDocLocation(@$record, 'group_constitution'))
                        <a class="text-bold"
                            href="{{ GeneralHelper::getDocLocation(@$record, 'group_constitution') }}"
                            target="_blank">
                            View Group Constitution
                        </a>
                    @endif
                </p>

            </div>
        </div>


        <div class="row mb-0 mt-20">
            <div class="col-md-12">
                <button class="btn btn-primary btn-sm btnSubmit">
                    Save
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
