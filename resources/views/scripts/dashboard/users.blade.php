<script>
    $(document).ready(function () {

        $('#btnLoadAddUserModal').unbind().bind('click', function (e) {

            return loadAddUserModal();//call load add user modal function

        });

        $(document).on('click', '#btnAddUser', function (e) {
            var user_id = $('#user_id').val();
            return saveUser(user_id);//call the save user function

        });

        function saveUser(user_id = null){
            var name = $('#name').val()
            var email = $('#email').val()
            var password = $('#password').val()
            var cpassword = $('#cpassword').val()
            var role_id = $('input[name="user_type"]:checked').val();
            console.log(user_id);

            if (name == "" || email == "" || password == "" || role_id == "") {
                return Swal.fire('Error!', 'Please fill in all fields with *', 'error');
            }
            if (password != cpassword) {
                return Swal.fire('Error!', 'Passwords do not match!!', 'error');
            }

            return Swal.fire({
                title: "Save user!",
                text: "Are you sure to save this user?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Save!"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('save-user') }}',
                        data: {
                        'user_id': user_id,
                        'name': name,
                        'email': email,
                        'password': password,
                        'role_id': role_id,
                    },
                        cache: false,
                        beforeSend: function () {
                            $("#loading").fadeIn("slow");
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.res == 'success') {
                                Swal.fire("Success!",
                                    "Cheers! User saved successfully.!",
                                    "success");

                                setTimeout(function () {
                                    location.reload();
                                
                                }, 3000)
                            } else if (response.res == 'error') {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong when saving this user. Please try again......!",
                                    "error");
                            } else if (response.res == 'validation_error') {
                                Swal.fire("Validation Error(s)!",
                                response.errors,
                                    "error");
                            } else {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong with the server. Check if your are logged in and try again please......!",
                                    "error");

                            }
                        },
                        complete: function () {
                            $("#loading").fadeOut("slow");
                        }
                    });

                }

            });
        }

        
        function loadAddUserModal(user_id = null) {
            // alert(user_id)
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route('load-add-user-modal') }}',
                data: {
                'user_id': user_id,
            },
                cache: false,
                beforeSend: function () {
                    $("#loading").fadeIn("slow");
                    $('#my-modals').html("")
                },
                success: function (response) {
                    $('#my-modals').html(response)
                    return $('#modalLoadAddUser').modal('show')
                },
                complete: function () {
                    $("#loading").fadeOut("slow");
                }
            });
        }


        $(".clickable_user").unbind().bind('click', function(e){
            e.preventDefault();

            var user_id = $(this).closest('tr').find('.user_id').text()
            // console.log(user_id);
            loadAddUserModal(user_id);//call the user add load pop up function

        });

        $(".btnDeleteUser").unbind().bind('click', function(e){
            e.preventDefault();

            var user_id = $(this).closest('tr').find('.user_id').text()
            // console.log(user_id);
            deleteUser(user_id);//call the user delete function

        });

        function deleteUser(user_id = null){
            return Swal.fire({
                title: "Delete user!",
                text: "Are you sure to delete this user?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete!"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('delete-user') }}',
                        data: {
                        'user_id': user_id,
                        
                    },
                        cache: false,
                        beforeSend: function () {
                            $("#loading").fadeIn("slow");
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.res == 'success') {
                                Swal.fire("Success!",
                                    "Cheers! User deleted successfully.!",
                                    "success");

                                setTimeout(function () {
                                    location.reload();
                                
                                }, 3000)
                            } else if (response.res == 'error') {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong when deleting this user. Please try again......!",
                                    "error");
                            } else if (response.res == 'validation_error') {
                                Swal.fire("Validation Error(s)!",
                                response.errors,
                                    "error");
                            } else {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong with the server. Check if your are logged in and try again please......!",
                                    "error");

                            }
                        },
                        complete: function () {
                            $("#loading").fadeOut("slow");
                        }
                    });

                }

            });
        }


    });
</script>