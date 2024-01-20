<script type="text/javascript">
    var actionAuthorized = false;
    $(document).on('shown.bs.collapse', '.panel-collapse', function() {
        /*alert($(this).attr('id'))*/
        sessionStorage.setItem('openTab', $(this).attr('id'));
    });

    $(document).on('change', '.chk-other', function() {
        if ($(this).prop('checked')) {
            $(this).parents('label').find('.specify-other').show();
        } else {
            $(this).parents('label').find('.specify-other').val('').hide();

        }
    });

    $(document).on('change', '.multi-chk', function() {
        var target = $(this).data('target');
        if ($(this).prop('checked')) {
            $(`.${target}`).prop('checked', true);
        } else {
            $(`.${target}`).prop('checked', false);
        }
    });

    $(document).on("change", ".chk_select_all", function() {
        if ($(this).prop('checked')) {
            $('.chk_fields').prop('checked', true);
        } else {
            $('.chk_fields').prop('checked', false);
        }
    });



    $('body').on('click', '.switcher-checkbox', async function() {
        // console.log("switcher-checkbox value ", value);
        if ($(this).prop('checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    $('body').on('click', '.delete-row', async function() {
        var $this = $(this);
        var details = $(this).attr('class').split(' ');
        var route = details[1];
        var table = $this.data('model');
        var reload_page = $this.data('reload-page');
        var delete_text = $this.data('delete-text');
        var body_message = $this.data('message');
        var pK = details[3];
        var id = $this.data('model-id');

        var url = "{{ route('delete') }}";
        url = `${url}/${table}/${id}`;

        delete_text = delete_text || table;

        var $output_str = "";
        var $output_str_blocked = "";
        var $output_str_warning = "";
        var $general_message = 'Are you sure you want to delete :- ' + delete_text + '!';
        var is_warning = false;
        var is_blocked = false;
        var eleId = $('#info-message-' + id);

        if (table == 'CbActivity') {} else if (table == "CbActivityParticipants") {
            url = '/delete_table_parts/' + 'CbActivity/' + table + '/' + id;
        } else {
            $output_str = $general_message;
        }

        if (is_blocked) {
            $output_str = $output_str_blocked + $output_str_warning;
            eleId.html($output_str);
            info_dialog(eleId, title, '');
        } else {
            $output_str.replace(/alert-danger/g, 'alert-warning');
            await bootbox_confirm($output_str, url, table, reload_page, body_message);
        }


        return false;
    });


    $('body').on('click', '.btnUploadPicture', function(event) {
        event.preventDefault();
        var formId = $(this).parents('form').attr('id');
        var url = $(this).parents('form').attr('action');
        /**var formData = new FormData($(this)[0]);*/
        var formData = new FormData($('#' + formId)[0]);
        /**console.log("formData "+ formData);*/
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            /**dataType:'JSON',*/
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(data) {
                pushNotificationLoader();
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    completeHandler(formId, response);
                } else {
                    pushNotification('<span class="text-danger">Error</span>', "" + response
                        .message, 'error');
                }

            },
            error: function(error) {
                pushNotification('<span class="text-danger">Error</span>',
                    'Seems like something went wrong!!<br>', 'error');
            }
        });
    });


    $('body').on('click', '.module-radio-select', function() {
        console.log("radio clicked");
        var frm = $(this).parents('form');
        var module = $(this).data('module');
        console.log("selected module ::: ", module);
        frm.find('.module-radio-sections').find('input[type="checkbox"]').each(function() {
            if ($(this).prop('checked')) {
                $(this).prop('checked', false);
            }
            $(this).parent('label').hide();
        });
        frm.find('.module-radio-sections').removeClass('hide');
        frm.find(".input[data-module='" + module + "']").parent('label').removeClass('hide');
    });


    $('body').on('click', '.load-data', function() {
        var displayElement = $(this).data('display-element');
        var url = $(this).data('load-url');
        pushNotificationLoadingData();
        $.get(url, function(response) {
            $(displayElement).html(response);
            pushNotificationClose();
        });

    });


    $('body').on('click', '.has-next', function() {
        var frm = $(this).parents('form');
        var btnSubmit = frm.find('button.btnSubmit');
        var btnHtmlNext = 'Save/Next <i class="fa fa-arrow-circle-right"></i>';
        btnSubmit.removeAttr('data-next');
        btnSubmit.html(btnHtmlNext);
        frm.find('input.is_usable').val('');
        if ($(this).attr('data-next') == true) {
            btnSubmit.attr('data-next', 1);
        } else {
            frm.find('input.is_usable').val(1);
            btnSubmit.html('Save');
        }
    });

    $('body').on('change', '.select-location-district', function() {
        var districtCode = $(this).val();
        var url = "{{ route('model_options', '[Model]') }}";
        url = `${url.replace("%5BModel%5D", "County")}?ParentModel=District&ParentModelId=${districtCode}`;
        $.get(url, function(result) {
            console.log(result);
            $('.select-location-county').html(result);
            selectize();
        });
    });

    $('body').on('change', '.select-location-county', function() {
        var countyCode = $(this).val();
        var url = "{{ route('model_options', '[Model]') }}";
        url = `${url.replace("%5BModel%5D", "SubCounty")}?ParentModel=County&ParentModelId=${countyCode}`;
        $.get(url, function(result) {
            console.log(result);
            $('.select-location-sub-county').html(result);
            selectize();
        });
    });

    $('body').on('keyup change', '.comma_separated', function(evt) {
        var $input = $(this);
        var $value = $(this).val();
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            $value = $input.val($input.val().replace(/[^\d]+/g, '').replace(/,/g, "")).val();
        } else {
            $value = ($value != null) ? $value.replace(/,/g, "") : $value;
        }
        $value = parseInt($value);
        console.log("value :: ", $value);
        if (isNaN($value)) {
            $input.val(0);
        } else {
            $(this).val(number_format(parseInt($value)));
            if (!parseInt($value)) $value = 0;
        }
    });



    $('body').on('keyup change', '.remove_characters', function(evt) {
        var $input = $(this);
        $input.val($input.val().replace(/[^\d]+/g, ''));
    });


    $('body').on('keyup', '.budget_items_table .quantity, .budget_items_table .unit_price', function() {
        var $parentTable = $(this).parents("table.budget_items_table");
        var $tblrows = $(this).parents(".budget_items_table tbody > tr");
        $tblrows.each(function(index) {
            var $tblrow = $(this);
            var quantity = removeNumberCommas($tblrow.find(".quantity").val());
            var unit_price = removeNumberCommas($tblrow.find(".unit_price").val());
            var subTotal = parseInt(quantity) * parseInt(unit_price);
            if (!isNaN(subTotal)) {
                $tblrow.find('.sub_total').val(number_format(subTotal));
            }
            computeBudgetTotal($parentTable);
        });
    });


    $('body').on('keyup', '.projection_sales_table .quantity, .projection_sales_table .unit_price', function() {
        var $parentTable = $(this).parents("table.projection_sales_table");
        var $tblrows = $(this).parents(".projection_sales_table tbody > tr");
        $tblrows.each(function(index) {
            var $tblrow = $(this);
            var quantity = removeNumberCommas($tblrow.find(".quantity").val());
            var unit_price = removeNumberCommas($tblrow.find(".unit_price").val());
            var subTotal = parseInt(quantity) * parseInt(unit_price);
            if (!isNaN(subTotal)) {
                $tblrow.find('.sub_total').val(number_format(subTotal));
            }
            computeSalesTotal($parentTable);
        });
    });

    function computeSalesTotal($parentTable) {
        var grandTotal = 0;
        $parentTable.find(".sub_total").each(function() {
            var stval = parseFloat(removeNumberCommas($(this).val()));
            grandTotal += isNaN(stval) ? 0 : stval;
        });

        $('.project_total_sales').val(number_format(grandTotal));
        console.log("sales grandTotal ", grandTotal);
        /**return grandTotal;*/
        computeGrossProfits($parentTable);
    }


    function computeBudgetTotal($parentTable) {
        var grandTotal = 0;
        $parentTable.find(".sub_total").each(function() {
            console.log("sub total ::: ", $(this).val());
            var stval = parseFloat(removeNumberCommas($(this).val()));
            grandTotal += isNaN(stval) ? 0 : stval;
        });

        $('.project_cost').val(number_format(grandTotal));
        $('.total_project_cost').val(number_format(grandTotal));
        console.log("grandTotal ", grandTotal);
        /**return grandTotal;*/
        computeGrossProfits($parentTable);
        if ($('.financial_group_contribution').length) {
            updateFundingSourceStatistics();
        }
    }

    function computeGrossProfits($parentTable) {
        var project_cost = parseInt(removeNumberCommas($('.total_project_cost').val()));
        var project_total_sales = parseInt(removeNumberCommas($('.project_total_sales').val()));
        var gross_profits = project_total_sales - project_cost;
        gross_profits = isNaN(gross_profits) ? 0 : gross_profits;
        $('.total_gross_profit').val(number_format(gross_profits));
    }


    $('body').on('change', '.location_selection', function() {

        var isTextOutPut = $(this).data('selection-text');
        if (isTextOutPut) {
            var tsuSelector = $(this).data('selection-tsu');
            var wsdfSelector = $(this).data('selection-wsdf');
            var umbrellaSelector = $(this).data('selection-umbrella');

            var selectedOption = $(this).children('option:selected');
            var tsu = selectedOption.data('tsu');
            var wsdf = selectedOption.data('wsdf');
            var umbrella = selectedOption.data('umbrella');

            $(`.${tsuSelector}`).val(tsu.name);
            $(`.${wsdfSelector}`).val(wsdf.name);
            $(`.${umbrellaSelector}`).val(umbrella.name);

            return;
        }

        var TargetModel = $(this).data('selection-target-model');
        var filterField = $(this).data('filter-field');
        var filterFieldID = $(this).val();
        var fillElement = $(`.location_selection.${TargetModel}`);

        console.log("TargetModel", TargetModel);
        console.log("filterFieldID", filterFieldID);
        console.log("filterField", filterField);
        console.log("fillElement", fillElement);
        if (!fillElement.length) {
            // return;
        }

        if (TargetModel == "AdminUnitLevelTwo") {
            $('.location_selection.AdminUnitLevelTwo, .location_selection.AdminUnitLevelThree, .location_selection.AdminUnitLevelFour, .location_selection.AdminUnitLevelFive')
                .html('');
        } else if (TargetModel == "AdminUnitLevelThree") {
            $('.location_selection.AdminUnitLevelThree, .location_selection.AdminUnitLevelFour, .location_selection.AdminUnitLevelFive')
                .html('');
        } else if (TargetModel == "AdminUnitLevelFour") {
            $('.location_selection.AdminUnitLevelFour, .location_selection.AdminUnitLevelFive').html('');
        } else if (TargetModel == "AdminUnitLevelFive") {
            $('.location_selection.AdminUnitLevelFive').html('');
        }

        if ($(this).hasClass('end-selection') || $(this).hasClass('last-selection') || !filterFieldID) {
            return;
        }

        var url =
            `{{ route('location_helper') }}?TargetModel=${TargetModel}&filterField=${filterField}&filterFieldID=${filterFieldID}`;
        pushNotificationLoader("Loading sections");
        $.get(url, function(result) {
            selectize();
            KTApp.init();
            console.log("fillElement.data('allow-all') ::: ", fillElement.data('allow-all'));
            fillElement.html(result);
            if (fillElement.data('allow-all')) {
                fillElement.children("option[data-value='default']").remove();
                fillElement.prepend(`<option value="" selected>All</option>`);
            }
            pushNotificationClose();
        });
    });


    $('body').on('change', '.select_model_options', function() {

        var childModel = $(this).data('child-model');
        var childModelField = $(this).data('child-field');
        var parentModel = $(this).data('parent-model');
        var parentModelRelationship = $(this).data('parent-relationship');
        var parentModelId = $(this).val();
        var fillElement = $(`.select_model_options.${childModel}Model`);

        console.log("childModel", childModel);
        console.log("parentModelId", parentModelId);
        console.log("childModelField", childModelField);
        console.log("fillElement", fillElement);

        if ($(this).hasClass('end-selection') || $(this).hasClass('last-selection') || !parentModelId) {
            return;
        }

        var url =
            `{{ route('model_selection_helper') }}?parentModel=${parentModel}&parentModelId=${parentModelId}&childModel=${childModel}&childModelField=${childModelField}&parentModelRelationship=${parentModelRelationship}`;
        pushNotificationLoader("Loading sections");
        $.get(url, function(result) {
            selectize();
            KTApp.init();
            console.log("fillElement.data('allow-all') ::: ", fillElement.data('allow-all'));
            fillElement.html(result);
            if (fillElement.data('allow-all')) {
                fillElement.children("option[data-value='default']").remove();
                fillElement.prepend(`<option value="" selected>All</option>`);
            }
            pushNotificationClose();
        });
    });


    $('body').on('change', '.auto-fill-select', async function(event) {
        var value = $(this).val();
        var target = $(this).data('auto-fill-target');
        $(`.${target}`).val(value);
    });


    $('body').on('change', '.shows_sections', async function(event) {
        // console.log("show sections", $(this).val());
        var _this = $(this);
        var fields_required = true;
        var section = _this.data('section');
        var content_target = _this.data('content-target');
        var multi_select = _this.data('multi-select');
        var remove_input_names_single = _this.data('remove-input-names-single');
        var input_target_name = _this.data('input-target-name');
        var content_target_element = $(`.${content_target}`)

        $(`.${section}_field`).removeAttr('required');
        var section_content = $(`.${section}`);

        if (!multi_select) {
            content_target_element.addClass('hide');
        }

        if (multi_select) {
            if ($(this).prop('checked')) {
                // console.log("checked");
                fields_required = true;
            } else {
                // console.log("un checked");
                fields_required = false;
            }
        }

        content_target_element.find('input,select,textarea').removeAttr('required');
        // $(`.${section}_section`).addClass('hide');

        // console.log("section", section);
        // console.log("content_section", content_section);

        if (remove_input_names_single && !multi_select) {
            content_target_element.find('input,select,textarea').attr('name', '');
            $(`.${section}_field`).attr('name', input_target_name);
        }

        if (content_target && section_content) {
            if (multi_select) {
                if ($(this).prop('checked')) {
                    $(`.${section}`).removeClass('hide');
                } else {
                    $(`.${section}`).addClass('hide');
                }

            } else {
                $(`.${section}`).removeClass('hide');
            }
            $(`.${section}_field`).each(function() {
                if ($(this).data("is-required") && fields_required) {
                    $(this).attr("required", "required");
                }
            });
        }
    });


    $('body').on('change', '.toggle_section_content', async function(event) {
        var contentHolder = $(this).data('content-holder');
        var displayElement = $(this).data('display-element');
        $(`${displayElement}`).removeClass('hide').html('').html($(contentHolder).html());
        var selectField = $(displayElement).find('select');
        if (selectField.length && !selectField.hasClass('selectize')) {
            selectField.addClass('selectize');
        }
        selectize();
    });

    $('body').on('change', '.reset-original-value', async function(event) {
        $(this).val($(this).data('original-value'));
    });

    $('body').on('keyup', '.reset-original-value', async function(event) {
        $(this).val($(this).data('original-value'));
    });

    $('body').on('change keyup click', '.dynamic-content-setter', async function(event) {
        let $this = $(this);
        let dynamic_content_source = $this.data('dynamic-content-source');
        let dynamic_content_target = $this.data('dynamic-content-target');
        let dynamic_content_clear = $this.data('dynamic-content-clear');
        let reset_content = $this.data('reset-content');

        // if (reset_content) {
        $(dynamic_content_clear).html('');
        $(dynamic_content_target).html($(dynamic_content_source).html());
        // }
    });


    $('body').on('change keyup click', '.fields-summation', async function(event) {
        let $this = $(this);
        let target_classes = $this.data('target-classes');
        let target_result = $this.data('target-result');

        var result = 0;
        $(`.${target_classes}`).each(function() {
            var stval = parseInt($(this).val());
            result += isNaN(stval) ? 0 : stval;
        });

        $(`.${target_result}`).val(result);
    });

    $('body').on('submit', '.dynamic-content-form', async function(event) {
        event.preventDefault();
        let form = $(this);
        let action = form.attr('action');
        let conentWrapper = form.parents('.content-wrapper');
        let formData = form.serialize()
        let selectedMain = form.find('.selected-main');
        // let optionIndex = selectedMain.children('option:selected').val();
        let url = selectedMain.children('option:selected').data('route') || action;

        console.log("url ", url);
        conentWrapper.find('.dynamic-content-wrapper').addClass('hide')
        conentWrapper.find('.dynamic-content-wrapper .dynamic-content').html('')
        showLoader();
        let response = await $.get(url, formData);
        closeLoader();
        // let response = await axios.get(`${url}?${formData}`);
        // response = response.data;
        conentWrapper.find('.dynamic-content-wrapper .dynamic-content').html(response)
        conentWrapper.find('.dynamic-content-wrapper').removeClass('hide');
        initiateWYSIWYG();

    });

    $('body').on('change', '.select-report-time', async function(event) {
        let $this = $(this);
        let form = $this.parents('form');
        let show_years = $(this).children('option:selected').data('show-years')
        console.log(show_years);
        let yearElement = form.find('.year');
        yearElement.attr('disabled', 'diasabled');
        yearElement.parent('div').find('span.error').addClass('hide');
        if (show_years) {
            yearElement.removeAttr('disabled').attr('required', 'required');
        }

    });


    $('body').on('change', '.checked-items', function(event) {
        let targeted_items = $(this).data('target-items');
        targeted_items = $(`.${targeted_items}`);
        console.log('targeted_items', targeted_items);
        if ($(this).prop('checked')) {
            targeted_items.each(function() {
                $(this).attr('name', $(this).data('field-name'));
            });
        } else {
            targeted_items.each(function() {
                $(this).removeAttr('name');
            });
        }
    });

    $('body').on('change keyup', '.fill-data-multiple', function(event) {
        console.log($(this).attr('type'));
		let data_element = $(this).data('fill-elements');
		if($(this).is('select')) {
			var selected = $(this).children("option:selected");
			var selected_text = selected.text();
			$(`.${data_element}`).val(selected.val());
		} else {
			$(`.${data_element}`).val($(this).val());
		}
    });


    $('.modal').on('hidden.bs.modal', function() {})
</script>
