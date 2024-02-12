<script>
    $(document).ready(function() {
        $(document).on('click', '#time_in', function(e) {
            return Swal.fire({
                title: "Time In!",
                text: "Are you sure to start your Time In?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Start!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('time-in') }}',
                        data: {
                            'user_id': '{{ Auth::id() }}',
                            // '_token': {{ csrf_token() }}
                        },
                        cache: false,
                        beforeSend: function() {
                            $("#loading").fadeIn("slow");
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.res == 'success') {
                                Swal.fire("Success!",
                                    "Cheers! Time In started successfully.!",
                                    "success");

                                setTimeout(function() {
                                    location.reload();
                                    $('#time_in').addClass('d-none');
                                    $('#time_out').removeClass('d-none');
                                }, 3000)
                            } else if (response.res == 'error') {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong when starting your time in. Please try again......!",
                                    "error");
                            } else if (response.res == 'validation_error') {
                                // Swal.fire("Error!",
                                //     "Ooops! Can\'t delete this expense account because of the attached expenses. <br> First delete the expenses...!!",
                                //     "error");
                            } else {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong with the server. Check if your are logged in and try again please......!",
                                    "error");

                            }
                        },
                        complete: function() {
                            $("#loading").fadeOut("slow");
                        }
                    });

                }

            });

        });

        $(document).on('click', '#time_out', function(e) {
            return Swal.fire({
                title: "Time Out!",
                text: "Are you sure to stop your Time In?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Stop!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route('time-out') }}',
                        data: {
                            'user_id': '{{ Auth::id() }}',
                        },
                        cache: false,
                        beforeSend: function() {
                            $("#loading").fadeIn("slow");
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.res == 'success') {
                                Swal.fire("Success!",
                                    "Cheers! Time In stopped successfully.!",
                                    "success");

                                setTimeout(function() {
                                    // location.reload();
                                    $('#time_in').removeClass('d-none');
                                    $('#time_out').addClass('d-none');
                                }, 3000)
                            } else if (response.res == 'error') {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong when stopping your time in. Please try again......!",
                                    "error");
                            } else if (response.res == 'validation_error') {
                                // Swal.fire("Error!",
                                //     "Ooops! Can\'t delete this expense account because of the attached expenses. <br> First delete the expenses...!!",
                                //     "error");
                            } else {
                                return Swal.fire("Error!",
                                    "Ooops! Something went wrong with the server. Check if your are logged in and try again please......!",
                                    "error");

                            }
                        },
                        complete: function() {
                            $("#loading").fadeOut("slow");
                        }
                    });

                }

            });

        });
    });
</script>
