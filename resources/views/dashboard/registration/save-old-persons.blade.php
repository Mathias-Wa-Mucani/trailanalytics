@extends('elements.master-layout')
@section('title')
    SEGOP|{{ $title ?? '' }}
@endsection
@section('header')
    @include('elements.header')
@endsection
@section('toolbar')
    @include('elements.toolbar')
@endsection
@section('sidebar')
    @include('elements.sidebar')
@endsection

{{-- start main content --}}
@section('content')
    <!--begin::Row-->
    <div class="row">
        <div class="col-12">
            <div class="card">

                <form class="form w-100" novalidate="novalidate" id="save_old_persons_form"
                    data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <!--begin::Form-->
                        {{-- <div class="card-header">{{ __('Login') }}</div> --}}
                        <div classx="card-header">
                            <h6 class="card-title x my-auto w-100 ml-4 text-dark"
                                style="height: 30px; line-height:30px; background:rgb(139, 139, 239); font-size:1.5rem">
                                Older Persons
                                Registration Form</h6>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::financial year-->
                                    <label for="">Financial Year<span
                                            class='text-danger font-weight-bolder font-size-lg'>*</span></label>
                                    <select name="financial_year_id" id="financial_year_id" data-control="select2"
                                        class="form-select form-select-sm select2x ">
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
                                    <select name="quarter_id" id="quarter_id" data-control="select2"
                                        class="form-select form-select-sm ">
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
                                    <input type="text" name="full_name" id="full_name"
                                        class="form-control form-control-sm bg-transparent">

                                    <!--end:full name-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::NIN-->
                                    <label for="">NIN<span class='text-danger font-weight-bolder'>*</span></label>
                                    <input type="text" name="nin" id="nin"
                                        class="form-control form-control-sm bg-transparent">
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
                                            <input type="radio" name="sex" value="Male" id=""
                                                class="form-radio form-select-sm">Male

                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="sex" value="Female" id=""
                                                class="form-radio form-select-sm">Female

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
                                    <select name="person_type_id" id="person_type_id" data-control="select2"
                                        class="form-select form-select-sm ">
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
                                    <input type="number" name="num_dependant" id="num_dependant"
                                        class="form-control form-control-lg bg-transparentx">
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
                                            <input type="radio" name="born" value="Yes" id=""
                                                class="form-radio form-select-sm">Yes

                                        </div>
                                        <div class="col-6">
                                            <input type="radio" name="born" value="No" id=""
                                                class="form-radio form-select-sm">No

                                        </div>
                                    </div>
                                    <!--end::Born-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <div class="row">
                                        <!--begin::DOB-->
                                        <label for="">Date of Birth<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                        <input type="date" name="dob" id="dob"
                                            class="form-control form-control-sm bg-transparent">
                                        <!--end::DOB-->
                                    </div>
                                    <div class="row">
                                        <!--begin::age-->
                                        <label for="">Age<span
                                                class='text-danger font-weight-bolder'>*</span></label>
                                        <select name="age" id="age" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select Age Range--</option>
                                            <option value="1">60-80</option>
                                            <option value="2">60-80</option>
                                        </select>
                                        <!--end::age-->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <h6 class="card-title  my-auto w-100 ml-4 text-dark"
                            style="height: 30px; line-height:30px; background:rgb(139, 139, 239); font-size:1.5rem">
                            Contact Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::pri_contact-->
                                        <label for="">Primary Telephone</label><br>
                                        <input type="text" name="pri_telephone" id="pri_telephone"
                                            class="form-control form-control-sm bg-transparent">
                                        <!--end::pri_contact-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <label for="">Alternative Telephone</label><br>
                                        <input type="text" name="sec_telephone" id="sec_telephone"
                                            class="form-control form-control-sm bg-transparent">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::email-->
                                        <label for="">Email</label><br>
                                        <input type="email" name="email" id="pri_telephone"
                                            class="form-control form-control-sm bg-transparent">
                                        <!--end::email-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::pobox-->
                                        <label for="">P.O BOX</label><br>
                                        <input type="text" name="box_number" id="box_number"
                                            class="form-control form-control-sm bg-transparent">
                                        <!--end::pobox-->
                                    </div>
                                </div>

                            </div>

                            <h6 class="card-title  my-auto w-100 ml-4 text-dark"
                                style="height: 30px; line-height:30px; background:rgb(139, 139, 239); font-size:1.5rem">
                                Location</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::district-->
                                        <label for="">District<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="dcode" id="dcode" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select District--</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->district }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::district-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::county-->
                                        <label for="">County<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="ccode" id="ccode" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select County--</option>
                                            <option value="1">Ccode</option>
                                            <option value="2">Ccode</option>
                                        </select>
                                        <!--end::county-->
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::subcounty-->
                                        <label for="">Sub-County<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="scode" id="scode" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select Subcounty--</option>
                                            <option value="1">Scode</option>
                                            <option value="2">Scode</option>
                                        </select>
                                        <!--end::subcounty-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::parish-->
                                        <label for="">Parish<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="pcode" id="pcode" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select Parish--</option>
                                            <option value="1">Pcode</option>
                                            <option value="2">Pcode</option>
                                        </select>
                                        <!--end::parish-->
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::village-->
                                        <label for="">Village<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="vcode" id="vcode" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select Village--</option>
                                            <option value="1">Vcode</option>
                                            <option value="2">Vcode</option>
                                        </select>
                                        <!--end::village-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::address-->
                                        <label for="">Address</label><br>
                                        <textarea name="address" id="address" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                                        <!--end::address-->
                                    </div>
                                </div>

                            </div>

                            <h6 class="card-title  my-auto w-100 ml-4 text-dark"
                                style="height: 30px; line-height:30px; background:rgb(139, 139, 239); font-size:1.5rem">
                                Education</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <!--begin::Educ level-->
                                        <label for="">Education Level<span
                                                class='text-danger font-weight-bolder'>*</span></label><br>
                                        <select name="stp_educ_level_id" id="stp_educ_level_id" data-control="select2"
                                            class="form-select form-select-sm ">
                                            <option value="">--Select Education Level--</option>
                                            <option value="1">Level</option>
                                            <option value="2">Level</option>
                                        </select>
                                        <!--end::Educ level-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Educ comment-->
                                        <label for="">Education Comments</label><br>
                                        <textarea name="educ_comment" id="educ_comment" class="form-control form-control-sm" cols="30" rows="10"></textarea>
                                        <!--end::Educ comment-->
                                    </div>
                                </div>

                            </div>

                            <h6 class="card-title  my-auto w-100 ml-4 text-dark"
                                style="height: 30px; line-height:30px; background:rgb(139, 139, 239); font-size:1.5rem">
                                Add Photo</h6>
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
                        <a href="{{route('op-registration')}}" class="btn btn-danger mr-auto">Cancel</a>
                        <button type="button" id="btnSubmitPlantAppnDraft" onclickx="return saveApplication();"
                            class="btn btn-warning mx-auto btnSubmitPlantAppnDraft">Save Draft</button>
                        <button type="button" id="btnSubmitPlantAppnFinal"
                            class="btn btn-success  xmr-auto btnSubmitPlantAppnFinal">Submit Final</button>

                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </div>
                </form>
                <!--end::Form-->


            </div>
        </div>
    </div>
    <!--end::Row-->
@endsection
{{-- end main content --}}
@section('custom-js')
    {{-- @include('scripts.dashboard.main') --}}
@endsection
