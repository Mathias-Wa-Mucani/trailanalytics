@extends('elements.master-layout')
@section('title')
    SEGOP|Application
@endsection
{{-- start main content --}}
@section('content')
    <!--begin::Row-->
    <div class="row">

        @includeIf('dashboard.partials.page_header', [
            'new_record' => true,
            'route' => route('module.create', [
                'Module' => 'applications',
                'Model' => 'OldPersonApplication',
                'Section' => 'application',
            ]),
            'btnText' => 'Add Application',
            'btnTitle' => 'Add Application',
            'page_title' => 'List of Applications',
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
