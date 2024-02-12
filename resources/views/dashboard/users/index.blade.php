@extends('elements.master-layout')
@section('title')
TrailAnalytics|User Panel
@endsection
{{-- start main content --}}
@section('content')
{{-- <p>This is my body content.</p> --}}
<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="col-lg-6 my-auto">
                <h3>Users</h3>
            </div>
            <div class="col-lg-6 my-auto">
                <button class="btn btn-sm fa fa-plus btn-success float-end" id="btnLoadAddUserModal"> Add User</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @if (count($users) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? $i =1;?>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role_name}}</td>
                                    <td>{{ date('D, d/M/y ', strtotime($user->created_at)) }}</td>
                                    <td><button class="btn btn-sm btn-danger fa fa-trash"> Delete</button></td>

                                </tr>
                                <? $i++ ;?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <span class="text-center text-warning">No Users found!!</span>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@include('scripts.dashboard.users')
@endpush
@endsection