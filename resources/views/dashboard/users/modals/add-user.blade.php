<div class="modal fade" id="modalLoadAddUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Add new user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user_id" value="{{ $user->id ?? "" }}">
                    <div class="row">
                        <label for="" class="font-weight-bolder"><strong>Name <span
                                    class="text-danger">*</span></strong> </label>
                        <input type="text" name="" id="name" value="{{ $user->name ?? "" }}" class="form-control form-control-sm required">
                    </div>
                    <div class="row">
                        <label for="" class="font-weight-bolder"><strong>Email <span class="text-danger">*</span></strong> </label>
                        <input type="email" name="" id="email" value="{{ $user->email ?? "" }}"  class="form-control form-control-sm required">
                    </div>
                    <div class="row">
                        <label for="" class="font-weight-bolder"><strong>Password <span class="text-danger">*</span></strong> </label>
                        <input type="password" name="" id="password"  class="form-control form-control-sm required">
                    </div>
                    <div class="row">
                        <label for="" class="font-weight-bolder"><strong>Confirm Password <span class="text-danger">*</span></strong> </label>
                        <input type="password" name="" id="cpassword" class="form-control form-control-sm required">
                    </div>
                    <div class="row">
                        <label for="" class="font-weight-bolder"><strong>User Type <span class="text-danger">*</span></strong> </label>
                        <div class="row">
                            <div class="col-6">
                                <label for=""><input type="radio" <? if(isset($user)){ if($user->role_id == 1){ echo "checked";} else{ echo "";}} ?> id="admin" name="user_type" value="1">
                                    <label for="admin">
                                        Admin
                                    </label>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for=""><input type="radio" <? if(isset($user)){ if($user->role_id == 2){ echo "checked";} else{ echo "";}} ?> id="user" name="user_type" value="2">
                                    <label for="user">
                                        User
                                    </label>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger btn-sm float-start"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm fa fa-plus" id="btnAddUser">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('scripts.dashboard.users')