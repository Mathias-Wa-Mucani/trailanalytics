@extends('elements.master-layout')
@section('title')
TrailAnalytics|Dashboard
@endsection
{{-- start main content --}}
@section('content')
{{-- <p>This is my body content.</p> --}}
<span class="text-center">
    <h1>{{ date('H:i') }} Hrs </h1>
    <h6>{{ date('D, d/M/y') }}</h6>
    {{-- {{Auth::user()}} --}}
</span>
<div class="d-flexx justify-content-centerx text-center">
    @if(count($time_ins) == 0)
    <button class="btn btn-sm btn-success " id="time_in">Time In</button>
    @else
    <button class="btn btn-sm btn-danger d-nonex" id="time_out">Time Out</button>
    @endif
</div>

@push('scripts')
@include('scripts.dashboard.index')
@endpush
@endsection