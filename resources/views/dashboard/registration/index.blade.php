@extends('elements.master-layout')
{{-- start main content --}}
@section('content')
    <!--begin::Row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title alert alert-primary my-auto w-50"
                        style="height: 30px; line-height:30px; paddingX:0px 15px">Registration List of Older Persons </h3>

                    <a href="{{ route('old-persons-form') }}" class="dynamic-modal btn btn-sm btn-primary"
                        data-modal-target="modal-large" title="Add Older Person">
                        <i class="fa fa-plus fa-lg fa fa-menu"></i> Add Older Person
                    </a>

                </div>
                <div class="menu-dropdown dropdown-inline mr-4 d-none">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Dropup
                    </button>
                    <div class="dropdown-menu">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-user"></i> TestDropdown
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void();" data-toggle='tooltip' data-placement='top'
                            title='Click to view curriculum'><i class="fa fa-eye text-success btnViewCurri">View</i></a>
                        <div class="dropdown-divider"></div>
                        <a role='button' class='fas fa-trash  fa-lg text-danger btnDeleteCurri' data-toggle='tooltip'
                            data-placement='top' title='Click to delete'> Delete</a>
                        <div class="dropdown-divider"></div>
                        <a class="text-warning fa fa-building fa-lg btnArchiveCurri" role="button" data-toggle='tooltip'
                            data-placement='top' title='Click to archive'> Archive</a>

                    </div>
                </div>

                <div class="card-body table-responsive">


                </div>



            </div>
        </div>
    </div>
    <!--end::Row-->
@endsection
{{-- end main content --}}
@section('custom-js')
    {{-- @include('scripts.dashboard.main') --}}
@endsection
