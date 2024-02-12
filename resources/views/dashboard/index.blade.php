@extends('elements.master-layout')
@section('title')
    TrailAnalytics|Dashboard
@endsection
{{-- start main content --}}
@section('content')
    {{-- <p>This is my body content.</p> --}}
    <span class="text-center">
        <h1>{{ date('H:i') }} Hrs  </h1>
        <h6>{{ date('D, d/M/y') }}</h6>
        {{-- {{Auth::user()}} --}}
    </span>
    <div class="d-flexx justify-content-centerx text-center">
        <button class="btn btn-sm btn-success " id="time_in">Time In</button>
        <button class="btn btn-sm btn-danger d-none" id="time_out">Time Out</button>
    </div>

    @push('scripts')
        @include('scripts.dashboard.index')
    @endpush
@endsection
