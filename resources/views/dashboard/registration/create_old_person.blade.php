    <?php
    use App\Models\EducationalLevel;
    use App\Models\FinancialYear;
    use App\Models\Quarter;
    $educational_levels = EducationalLevel::pluck('name', 'id')->prepend('Select', '');
    $financial_years = FinancialYear::pluck('name', 'dmis_financial_year_id')->prepend('Select', '');
    $quarters = Quarter::pluck('name', 'dmis_quarter_id')->prepend('Select', '');
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <form class="form w-100" novalidate="novalidate" id="save_old_persons_form" action="{{ route('store') }}"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ext" value="1">
                    @csrf
                    <input type="hidden" name="table" value="OldPerson">
                    <input type="hidden" name="r_fld[is_final]" class="is-final" value="1">
                    {{ Form::hidden('import', null, ['value' => '0', 'class' => 'import']) }}
                    {{ Form::hidden('fld_id', @$record->id) }}

                    <div class="card-body-">
                        <!--begin::Form-->
                        {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                        <div class="report-main-header gray h-header">
                            <h6> <strong> Older Persons Registration Form </strong> </h6>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">

                                    <div class="form-floating">
                                        {{ Form::select('r_fld[financial_year_id]', $financial_years, @$record->financial_year_id, ['class' => 'form-select form-select-sm', 'required']) }}

                                        <label for="">Financial Year<span
                                                class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Quarter-->

                                    <div class="form-floating">
                                        {{ Form::select('r_fld[quarter_id]', $quarters, @$record->quarter_id, ['class' => 'form-select form-select-sm', 'required']) }}

                                        <label for="">Quarter<span
                                                class='text-danger font-weight-bolder'>*</span></label>

                                        <!--end::Quarter-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::full name-->
                                    <div class="form-floating">
                                        <input type="text" name="r_fld[full_name]" id="full_name"
                                            class="form-control form-control-sm bg-transparent name" required
                                            placeholder=" " value="{{ @$record->full_name }}">
                                        <label for="">Full Name<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                    </div>

                                    <!--end:full name-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::NIN-->
                                    <div class="form-floating">
                                        <input type="text" name="r_fld[nin]" id="nin"
                                            class="form-control form-control-sm bg-transparent nin" required
                                            placeholder=" " value="{{ @$record->nin }}">
                                        <!--end::NIN-->
                                        <label for="">NIN<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Sex-->
                                    <label for="">Sex<span
                                            class='text-danger font-weight-bolder'>*</span></label><br>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="radio" name="r_fld[sex]" value="1" id=""
                                                class="form-radio form-select-sm" required
                                                {{ @$record->sex == 1 ? 'checked' : '' }}>Male

                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="r_fld[sex]" value="2" id=""
                                                class="form-radio form-select-sm" required
                                                {{ @$record->sex == 2 ? 'checked' : '' }}>Female

                                        </div>
                                    </div>
                                    <!--end::Sex-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-8">
                                    <div class="row">
                                        <div class="form-floating">
                                            <input type="date" name="r_fld[dob]" id="dob"
                                                class="form-control form-control-sm bg-transparent date-of-birth draft"
                                                required placeholder=" " value="{{ @$record->dob }}">
                                            <label for="">Date of Birth<span
                                                    class='text-danger font-weight-bolder'>*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="report-main-header gray">
                            Contact Information
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::pri_contact-->
                                    <div class="form-floating">
                                        <input type="text" name="contact_info[pri_telephone]" id="pri_telephone"
                                            class="form-control form-control-sm bg-transparent phone_number draft"
                                            placeholder=" "
                                            value="{{ @$record ? @$record->contact_info->pri_telephone : null }}">
                                        <label for="">Primary Telephone</label>
                                        <!--end::pri_contact-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <div class="form-floating">
                                        <input type="text" name="contact_info[sec_telephone]" id="sec_telephone"
                                            class="form-control form-control-sm bg-transparent phone_number draft"
                                            placeholder=" "
                                            value="{{ @$record ? @$record->contact_info->sec_telephone : null }}">
                                        <label for="">Alternative Telephone</label>
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
                                        <input type="email" name="contact_info[email]" id="pri_telephone"
                                            class="form-control form-control-sm bg-transparent email draft"
                                            placeholder=" "
                                            value="{{ @$record ? @$record->contact_info->email : null }}">
                                        <label for="">Email</label>
                                    </div>
                                    <!--end::email-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::pobox-->
                                    <div class="form-floating">
                                        <input type="text" name="contact_info[box_number]" id="box_number"
                                            class="form-control form-control-sm bg-transparent" placeholder=" "
                                            value="{{ @$record ? @$record->contact_info->box_number : null }}">
                                        <label for="">P.O BOX</label>
                                    </div>
                                    <!--end::pobox-->
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header gray">
                            Location
                        </div>

                        @include('dashboard.partials.location_template')

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="mb-8">
                                    <!--begin::address-->
                                    <div class="form-floating">
                                        <input name="r_fld[address]" id="address" class="form-control draft"
                                            required placeholder=" " data-is-required="1"
                                            value="{{ @$record->address }}">
                                        <label for="">Physical Address</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header gray">
                            Education
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Educ level-->
                                    <div class="form-floating">
                                        {{ Form::select('r_fld[stp_educ_level_id]', $educational_levels, @$record->stp_educ_level_id, ['class' => 'form-select form-select-sm draft', 'required', 'data-is-required' => 1]) }}
                                        <label for="">Education Level<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                    </div>

                                    <!--end::Educ level-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <div class="form-floating">
                                        <textarea name="r_fld[educ_comment]" id="educ_comment" class="form-control form-control-sm" cols="30"
                                            rows="10" placeholder=" ">{{ @$record->educ_comment }}</textarea>
                                        <label for="">Education Comments</label>
                                    </div>
                                    <!--end::Educ comment-->
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header gray">
                            Add Photo of Individual
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::photo-->
                                    <label for="">Passport Photograph</label><br>
                                    <input type="file" name="documents[elder_passport_photograph][old_person]"
                                        class="form-control form-control-sm image-file">
                                    <!--end::photo-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center">
                        <a href="#" data-bs-dismiss="modal" class="btn btn-danger mr-auto">Cancel</a>
                        <button type="button" id="btnSubmitPlantAppnDraft"
                            class="btn btn-warning mx-auto btnSubmitPlantAppnDraft submit-draft btnSubmit"
                            data-submit-draft="1">Save
                            Draft</button>
                        <button type="submit" id="btnSubmitPlantAppnFinal"
                            class="btn btn-success xmr-auto btnSubmitPlantAppnFinal btnSubmit">Submit Final</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Row-->
