@extends('elements.master-layout')
@section('title')
TrailAnalytics|Reports
@endsection
{{-- start main content --}}
@section('content')
{{-- <p>This is my body content.</p> --}}

<div class="row" data-sticky-container="">
    <div class="col-lg-4 col-xl-3">
        <div class="card card-custom" data-sticky="true" data-margin-top="140px" data-sticky-for="1023"
            data-sticky-class="sticky">
            <div class="card-body p-0">
                <ul class="navi navi-bold navi-hover my-5" role="tablist">

                    @foreach ($users as $user)
                    <li class="navi-item clickable-user clickable-user{{ $user->id }}" id="{{ $user->id }}">
                        <div class="clicked-user py-2 user-details{{ $user->id }} px-4">
                            <a class="navi-link activex" data-toggle="tab" href="javascript:void">
                                <span class="navi-icon"><i class="flaticon-avatar"></i></span>
                                <h5 class="navi-text">{{ $user->name }}</h5>
                                <h6 class="navi-text">{{ $user->email }}</h6>
                            </a>
                        </div>

                    </li>
                    <div class="divider py-1 bg-secondary"></div>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9">
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Time In and Time Out Logs</small></h3>
                </div>
                <div class="card-toolbar">
                    <div class="example-tools justify-content-center">
                        <span class="example-toggle" data-toggle="tooltip" title=""
                            data-original-title="View code"></span>
                        <span class="example-copy" data-toggle="tooltip" title=""
                            data-original-title="Copy code"></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="clocking-details">

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@include('scripts.dashboard.reports')
@endpush
@endsection