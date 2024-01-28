@extends('elements.master-layout')
{{-- start main content --}}
@section('content')
    <!--begin::Row-->
    <div class="row">

        @includeIf('dashboard.partials.page_header', [
            'new_record' => true,
            'route' => route('module.create', [
                'Module' => 'groups',
                'Model' => 'OldPersonGroup',
                'Section' => 'group',
            ]),
            'btnText' => 'Add Group',
            'btnTitle' => 'Add Group',
            'page_title' => 'Registration: List of Groups',
            'modal' => 'modal-large',
        ])

        <div class="col-md-12">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover']) }}
        </div>
    </div>
    <!--end::Row-->

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
@endsection
