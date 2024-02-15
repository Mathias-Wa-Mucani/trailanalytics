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
            <div class="col-lg-3 my-auto">
                <h3>Users</h3>
            </div>
            <div class="col-lg-3 my-auto">
                <button class="btn btn-sm fa fa-plus btn-success float-end" id="btnLoadAddUserModal"> Add User</button>
            </div>
            <div class="col-lg-3 my-auto">
                <a href="{{route('export-users-topdf')}}" target="_blank"
                    class="btn btn-sm btn-primary float-end fa fa-file-pdf"> Export to PDF </a>
            </div>
            <div class="col-lg-3 my-auto">
                <a href="{{route('export-users-tocsv')}}" 
                    class="btn btn-sm btn-warning float-end fa fa-file-csv"> Export to CSV </a>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    @if (count($users) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="bg-secondary">
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
                                    <td class="d-none user_id">{{$user->id}}</td>
                                    <td>{{$i}}</td>
                                    <td class="clickable_user"><a href="javascript:void(0)">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role_name}}</td>
                                    <td>{{ date('D, d/M/y ', strtotime($user->created_at)) }}</td>
                                    <td><button class="btn btn-sm btn-danger fa fa-trash btnDeleteUser"> Delete</button>
                                    </td>

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