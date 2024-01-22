<script>
    var reportPreloader = `<div class="text-center mt-40" style="font-size:13px"> <img src="{{asset('public/assets/img/ajax-loader-report.gif')}}" /> Generating report! Please wait... </div>`;
    $('body').on('click', '.btnReport', async function(event) {
        event.preventDefault();
        var frm = $(this).parents('form');

        var formId = frm.attr('id');
        console.log("validate_form(formId) ", validate_form(formId));
        if (!validate_form(formId)) {
            return false;
        }

        var formData = frm.serialize();
        var url = '{{route("report-filter")}}';

        $('.display-report').html(reportPreloader);
        let response = await axios.get(`${url}?${formData}`);
        response = response.data;
        if (response.message && !response.success) {
            pushNotificationError(response.message);
        } else {
            $('.display-report').html(response);
            selectize();
        }
    });

    $('body').on('change', '.aggregation_level', async function(event) {
        var aggregation = $(this).children("option:selected");
        var required_suppliments = aggregation.data('required-suppliments');

        $('.aggregation-child-filter').addClass('hide').find('select').removeAttr('required').removeClass('end-selection');
        if (required_suppliments) {
            var required_suppliments_array = required_suppliments.split('|');
            console.log("required_suppliments_array ", required_suppliments_array);

            for (let suppliment of required_suppliments_array) {
                $(`.aggregation-child-filter.${suppliment}-filter`).removeClass('hide').find('select').attr('required', 'required');
            }

            var last_suppliment = required_suppliments_array[required_suppliments_array.length - 1];
            $(`.aggregation-child-filter.${last_suppliment}-filter`).find('select').addClass('end-selection')
        }
    });
</script>