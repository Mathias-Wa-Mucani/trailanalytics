    <?php
    use App\Models\EducationalLevel;
    $educational_levels = EducationalLevel::pluck('name','id')->prepend('Select', '');
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <form class="form w-100" novalidate="novalidate" id="save_old_persons_form" action="{{ route('store') }}"
                    method="POST">
                    <input type="hidden" name="ext" value="1">
                    @csrf
                    <input type="hidden" name="table" value="OpRegistration">

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
                                    <!--begin::financial year-->
                                    <label for="">Financial Year<span
                                            class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                                    <select name="r_fld[stp_financial_year_id]" id="financial_year_id"
                                        data-control="select2" class="form-select form-select-sm select2x " required>
                                        <option value="">--Select Financial Year--</option>

                                        @foreach ($financialYrs as $financialYr)
                                            <option value="{{ $financialYr->id }}">{{ $financialYr->name }}</option>
                                        @endforeach
                                    </select>

                                    <!--end::financial year-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Quarter-->
                                    <label for="">Quarter<span
                                            class='text-danger font-weight-bolder'>*</span></label>
                                    <select name="r_fld[stp_quarter_id]" id="quarter_id" data-control="select2"
                                        class="form-select form-select-sm " required>
                                        <option value="">--Select Quarter--</option>
                                        @foreach ($quarters as $quarter)
                                            <option value="{{ $quarter->id }}">{{ $quarter->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Quarter-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::full name-->
                                    <label for="">Full Name<span
                                            class='text-danger font-weight-bolder'>*</span></label>
                                    <input type="text" name="r_fld[full_name]" id="full_name"
                                        class="form-control form-control-sm bg-transparent name" required>

                                    <!--end:full name-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::NIN-->
                                    <label for="">NIN<span
                                            class='text-danger font-weight-bolder'>*</span></label>
                                    <input type="text" name="r_fld[nin]" id="nin"
                                        class="form-control form-control-sm bg-transparent" required>
                                    <!--end::NIN-->
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
                                                class="form-radio form-select-sm" required>Male

                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="r_fld[sex]" value="2" id=""
                                                class="form-radio form-select-sm" required>Female

                                        </div>
                                    </div>
                                    <!--end::Sex-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::type of beneficiary-->
                                    <label for="">Select Type of Beneficiary<span
                                            class='text-danger font-weight-bolder'>*</span></label>
                                    <select name="r_fld[person_type_id]" id="person_type_id" data-control="select2"
                                        class="form-select form-select-sm " required>
                                        <option value="">--Select Type--</option>
                                        @foreach ($personTypes as $personType)
                                            <option value="{{ $personType->id }}">{{ $personType->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::type of beneficiary-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::dependants-->
                                    <label for="">Number of Dependants</label><br>
                                    <input type="number" name="r_fld[num_dependant]" id="num_dependant"
                                        class="form-control form-control-lg bg-transparentx" required>
                                    <!--end::dependants-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Born-->
                                    <label for="">Do you know when you were born?<span
                                            class='text-danger font-weight-bolder'>*</span></label><br>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="radio" name="person_when_born" value="1" id=""
                                                class="form-radio form-select-sm" required>Yes

                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="person_when_born" value="0"
                                                id="" class="form-radio form-select-sm" required>No

                                        </div>
                                    </div>
                                    <!--end::Born-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <div class="row dob_section">
                                        <!--begin::DOB-->
                                        <label for="">Date of Birth<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                        <input type="date" name="r_fld[dob]" id="dob"
                                            class="form-control form-control-sm bg-transparent date-of-birth" required>
                                        <!--end::DOB-->
                                    </div>
                                    <div class="row age_section hide">
                                        <!--begin::age-->
                                        <label for="">Age<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                        {{-- <select name="age" id="age" data-control="select2"
                                            class="form-select form-select-sm " required>
                                            <option value="">--Select Age Range--</option>
                                            <option value="1">60-80</option>
                                            <option value="2">60-80</option>
                                        </select> --}}

                                        <select class="form-select form-select-sm select_age" name=""
                                            id="" data-control="select2">
                                            @for ($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"> {{ $i }} </option>
                                            @endfor
                                        </select>
                                        <!--end::age-->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header">
                            Contact Information
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::pri_contact-->
                                    <label for="">Primary Telephone</label><br>
                                    <input type="text" name="contact_info[pri_telephone]" id="pri_telephone"
                                        class="form-control form-control-sm bg-transparent phone_number" required>
                                    <!--end::pri_contact-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <label for="">Alternative Telephone</label><br>
                                    <input type="text" name="contact_info[sec_telephone]" id="sec_telephone"
                                        class="form-control form-control-sm bg-transparent phone_number">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::email-->
                                    <label for="">Email</label><br>
                                    <input type="email" name="contact_info[email]" id="pri_telephone"
                                        class="form-control form-control-sm bg-transparent email">
                                    <!--end::email-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::pobox-->
                                    <label for="">P.O BOX</label><br>
                                    <input type="text" name="contact_info[box_number]" id="box_number"
                                        class="form-control form-control-sm bg-transparent">
                                    <!--end::pobox-->
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header">
                            Location
                        </div>

                        @include('dashboard.partials.location_template')


                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::address-->
                                    <label for="">Address</label><br>
                                    <input name="address" id="address" class="form-control form-control-sm"
                                        required>
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header">
                            Education
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::Educ level-->educational_levels
                                    <label for="">Education Level<span
                                            class='text-danger font-weight-bolder'>*</span></label><br>
                                    {{-- <select name="stp_educ_level_id" id="stp_educ_level_id" data-control="select2"
                                        class="form-select form-select-sm " required>
                                        <option value="">--Select Education Level--</option>
                                    </select> --}}

                                    {{ Form::select('r_fld[stp_educ_level_id]', $educational_levels, @$record->stp_educ_level_id,  ['class' => '', 'required']) }}

                                    <!--end::Educ level-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::Educ comment-->
                                    <label for="">Education Comments</label><br>
                                    <textarea name="r_fld[educ_comment]" id="educ_comment" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                                    <!--end::Educ comment-->
                                </div>
                            </div>

                        </div>

                        <div class="report-main-header">
                            Add Photo
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--end::Input group=-->
                                <div class="fv-row mb-3">
                                    <!--begin::photo-->
                                    <label for="">Add Photo</label><br>
                                    <input type="file" name="rec_z_documents" id="rec_z_documents"
                                        class="form-control form-control-sm">
                                    <!--end::photo-->
                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="card-footer d-flex justify-content-center">
                        <a href="{{ route('op-registration') }}" class="btn btn-danger mr-auto">Cancel</a>
                        <button type="button" id="btnSubmitPlantAppnDraft"
                            class="btn btn-warning mx-auto btnSubmitPlantAppnDraft">Save Draft</button>
                        <button type="submit" id="btnSubmitPlantAppnFinal"
                            class="btn btn-success xmr-auto btnSubmitPlantAppnFinal btnSubmit">Submit Final</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Row-->
