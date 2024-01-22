<script>
    $('body').on('click', 'input[name="person_when_born"]', function() {
        var frm = $(this).parents('form');
        frm.find('.dob_section').addClass('hide').find('input').val(null).removeAttr('required');
        frm.find('.age_section').addClass('hide').find('select').val(null).removeAttr('required');
        if ($(this).val() == 1) {
            frm.find('.dob_section').removeClass('hide').find('input').attr('required');
        } else {
            frm.find('.age_section').removeClass('hide').find('select').attr('required');
        }
    });

    $('body').on('change', '.select_age', function() {
        var currentYear = new Date().getFullYear();
        var yearBorn = currentYear - parseInt($(this).val());
        var dob = `${yearBorn}/01/01`;
        console.log(dob);
        $('.date-of-birth').val(dob);
        $('.dob_section').removeClass('hide');
        $('.age_section').addClass('hide');

        var nin_section = $('.nin-section');
        nin_section.find('label').addClass('required-field');
        nin_section.find('input').attr('required', 'required');
        if (currentYear - yearBorn <= '{{ MINIMUM_AGE_NIN }}') {
            nin_section.find('label').removeClass('required-field');
            nin_section.find('input').removeAttr('required');
            nin_section.find('.error').remove();
        }
    });


    $('body').on('change keyup change', '.date-of-birth', function() {
        var currentYear = new Date().getFullYear();
        var yearBorn = new Date($(this).val()).getFullYear();
        var nin_section = $('.nin-section');
        nin_section.find('label').addClass('required-field');
        nin_section.find('input').attr('required', 'required');
        if (currentYear - yearBorn <= '{{ MINIMUM_AGE_NIN }}') {
            nin_section.find('label').removeClass('required-field');
            nin_section.find('input').removeAttr('required');
            nin_section.find('.error').remove();
        }
    });
</script>
