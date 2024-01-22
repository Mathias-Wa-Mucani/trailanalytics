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
                <div class="card-body table-responsive">
                    <div class="col-md-12">
                        {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover']) }}
                    </div>
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
