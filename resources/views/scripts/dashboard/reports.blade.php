<script>
    $(document).ready(function() {

        $(document).on('click', '.clickable-user', function(e) {
            e.preventDefault();

            // return alert($(this)[0].id);
            var ActiveUser = $(this)[0].id;

            $('.user-details' + ActiveUser).css({'background': 'rgb(143 239 186)', 'border': '2px solid red'});
            $('.clicked-user' ).not($('.user-details' + ActiveUser)).css({'background':'', 'border':''});

            // $('.user-details').not($('.user-details' + ActiveUser)).removeClass('active'); //remove active class from all other a tags except clicked one
            // $('.user-details' + ActiveUser).addClass('active');

            // console.log(activeAnchor);
            user_id = $(this)[0].id;

            if (user_id > 0) {


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "{{route('get-user-clocking-details')}}",
                    data: {
                        'user_id': user_id
                    },
                    beforeSend: function() {
                        $("#loading").fadeIn("slow");
                        $('body').css('overflow', 'hidden');
                    },

                    success: function(response) {
                        console.log(response);
                        $('.clocking-details').html(response);
                        // Show content
                        // $('.curriclum-content').removeClass('d-none');

                    },
                    complete() {
                        $("#loading").fadeOut("slow");
                        $('body').css('overflow', 'scroll');
                    }
                });

            }
        });
    });
</script>
