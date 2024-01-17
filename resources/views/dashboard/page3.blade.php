@extends('elements.master-layout')
@section('title')
    SEGOP|Dashboard
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
    {{-- <p>This is my body content.</p> --}}
    
    <h1>Page3 Here....</h1>
@endsection
{{-- end main content --}}
@section('custom-js')
    {{-- @include('scripts.dashboard.main') --}}
    >
@endsection
