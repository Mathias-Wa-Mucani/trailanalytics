<?php
use App\Models\FinancialYear;
use App\Models\Quarter;
use App\Models\Bank;
$financial_years = FinancialYear::pluck('name', 'dmis_financial_year_id')->prepend('Select', '');
$quarters = Quarter::pluck('name', 'dmis_quarter_id')->prepend('Select', '');
$banks = Bank::pluck('name', 'dmis_bank_id')->prepend('Select', '');
$group_roles = \App\Models\GroupRole::all();
$members = \App\Models\OldPerson::all();
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
        {{ Form::hidden('table', 'OldPersonGroup') }}

        {{ Form::hidden('fld_id', @$record->id) }}

        <div class="report-main-header gray h-header">
            <h6> <strong> Older Persons Group Registration Form </strong> </h6>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::select('r_fld[financial_year_id]', $financial_years, @$record->financial_year_id, ['class' => 'form-control', 'placeholder' => ' ', 'required']) }}
                    <label for="">Financial Year<span
                            class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::select('r_fld[quarter_id]', $quarters, @$record->quarter_id, ['class' => 'form-control', 'placeholder' => ' ', 'required']) }}
                    <label for="">Quarter<span class='text-danger font-weight-bolder'>*</span></label>
                </div>
            </div>
        </div>

        <div class="form-floating mt-2">
            {{ Form::text('r_fld[group_name]', @$record->group_name, ['class' => 'form-control', 'placeholder' => ' ', 'required']) }}
            {{ Form::label('', 'Group Name', ['class' => '']) }}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::text('r_fld[tin]', @$record->tin, ['class' => 'form-control tin_number', 'placeholder' => ' ']) }}
                    {{ Form::label('', 'TIN', ['class' => '']) }}
                </div>
            </div>

            <div class="col-md-6">
                {{ Form::label('', 'Is Home', ['class' => '']) }} <br>
                <div class="form-check form-check-inline mt-4">
                    <input class="form-check-input" type="radio" name="r_fld[is_home]" id="is_home" value="1"
                        required {{ @$record->is_home ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_home">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="r_fld[is_home]" id="is_not_home" value="0"
                        required {{ @$record->is_home === false ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_not_home">No</label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('r_fld[date_established]', @$record->date_established, ['class' => 'form-control datepicker', 'placeholder' => ' ', 'required']) }}
                    {{ Form::label('', 'Date of Establishment', ['class' => 'required-field']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="report-main-header gray">
                    Location
                </div>
            </div>
        </div>

        @include('dashboard.partials.location_template')

        <div class="row mt-4">
            <div class="col-md-6">
                <!--begin::Input group=-->
                <div class="mb-8">
                    <!--begin::address-->
                    <div class="form-floating">
                        <input name="r_fld_[address]" id="address" class="form-control draft" required- placeholder=" "
                            data-is-required="1" value="{{ @$record->address }}">
                        <label for="">Physical Address</label>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header gray">
                    Group Members
                </div>
            </div>

            <div class="col-md-12">
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
                                <input type="hidden" name="group_members[rec_b_group_id][]"
                                    value="{{ @$record->id }}">
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
                                        <input type="hidden" name="group_members[rec_b_group_id][]"
                                            value="{{ @$record->id }}">
                                        <input type="hidden" name="group_members[id][]" value="{{ @$member->id }}">
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <select class="form-control" name="group_members[rec_a_elder_id][]">
                                                <option value="{{ @$member->older_person->id }}">
                                                    {{ @$member->older_person->full_name }}
                                                </option>
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
                    <button type="button" class="btn btn-white btn-danger btn-sm"
                        onClick="deleteRow('group_member_table');">
                        <i class="fa fa-remove"></i> {{ __('Remove selected') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header gray">
                    Contact Information
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::pri_contact-->
                    <div class="form-floating">
                        <input type="text" name="contact_info[contact_pri_telephone]" id="pri_telephone"
                            class="form-control form-control-sm bg-transparent phone_number draft" placeholder=" "
                            value="{{ @$record->contact_pri_telephone }}">
                        <label for="">Primary Telephone</label>
                        <!--end::pri_contact-->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!--begin::Input group=-->
                <div class="fv-row mb-8">
                    <div class="form-floating">
                        <input type="text" name="contact_info[contact_sec_telephone]" id="sec_telephone"
                            class="form-control form-control-sm bg-transparent phone_number draft" placeholder=" "
                            value="{{ @$record->contact_sec_telephone }}">
                        <label for="">Secondary Telephone</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!--end::Input group=-->
                <div class="fv-row mb-3">
                    <!--begin::email-->
                    <div class="form-floating">
                        <input type="email" name="contact_info[contact_email]"
                            class="form-control form-control-sm bg-transparent email draft" placeholder=" "
                            value="{{ @$record->contact_email }}">
                        <label for="">Email</label>
                    </div>
                    <!--end::email-->
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header gray">
                    Group Account Details
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    {{ Form::select('r_fld[stp_bank_id]', $banks, @$record->stp_bank_id, ['class' => 'form-control', 'placeholder' => ' ', 'required']) }}
                    <label for="">Bank<span
                            class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-2">
                    <input type="text" name="r_fld[account_name]"
                        class="form-control form-control-sm bg-transparent draft" placeholder=" "
                        value="{{ @$record->account_name }}" required>
                    <label for="">Account Name<span class='text-danger font-weight-bolder'>*</span></label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    <input type="text" name="r_fld[account_number]"
                        class="form-control form-control-sm bg-transparent draft" placeholder=" "
                        value="{{ @$record->account_number }}" required>
                    <label for="">Account Number<span class='text-danger font-weight-bolder'>*</span></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-2">
                    <input type="text" name="r_fld[account_branch]"
                        class="form-control form-control-sm bg-transparent draft" placeholder=" "
                        value="{{ @$record->account_branch }}" required>
                    <label for="">Account Branch<span class='text-danger font-weight-bolder'>*</span></label>
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-12">
                <div class="report-main-header gray">
                    Add Photo
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <span class="text-bold">
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'group_certificate') ? 'Change' : '' }}
                    Group Registration/Certificate:
                </span>

                {{ Form::file('documents_[group_certificate]', ['class' => 'input-file image_doc_file', @$record ? '' : '']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'group_certificate'))
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
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'group_photograph') ? 'Change' : '' }}
                    Group
                    Photograph:
                </span>

                {{ Form::file('documents_[group_photograph]', ['class' => 'input-file image_doc_file', @$record ? '' : 'required']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only Images (png, jpeg, jpg) or maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'group_photograph'))
                        <a class="text-bold" href="{{ GeneralHelper::getDocLocation(@$record, 'group_photograph') }}"
                            target="_blank">
                            View Group Photograph
                        </a>
                    @endif
                </p>

            </div>

            <div class="col-md-6 mt-10">
                <span class="text-bold required-field">
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'beneficiary_selection_meeting_minutes') ? 'Change' : '' }}
                    Minutes of Beneficiary Selection Meeting:
                </span>

                {{ Form::file('documents[beneficiary_selection_meeting_minutes]', ['class' => 'input-file image_doc_file', @$record ? '' : 'required']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'beneficiary_selection_meeting_minutes'))
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
                    {{ @$record_ && GeneralHelper::getDocLocation(@$record, 'group_constitution') ? 'Change' : '' }}
                    Group Constitution:
                </span>

                {{ Form::file('documents[group_constitution]', ['class' => 'input-file image_doc_file']) }}
                <p class="mt-4 highlight-orange fs-6">
                    <i>
                        {{ __('Only PDF and Images - maximum ' . MAX_FILE_UPLOAD_SIZE_MBS . 'mb') }}
                    </i>
                </p>

                <p>
                    @if (@$record_ && GeneralHelper::getDocLocation(@$record, 'group_constitution'))
                        <a class="text-bold"
                            href="{{ GeneralHelper::getDocLocation(@$record, 'group_constitution') }}"
                            target="_blank">
                            View Group Constitution
                        </a>
                    @endif
                </p>

            </div>
        </div>

        <hr>

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
