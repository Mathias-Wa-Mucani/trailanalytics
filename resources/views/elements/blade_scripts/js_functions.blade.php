<script>
    /**function to load datatable lists on pages*/
    function loadListing() {
        // $('table.dataTable').DataTable().fnDestroy().ajax.reload();
    }

    loadListing();

    function loadPart(ele, url) {
        $.get(url, function(response) {
            ele.html(response);
            initiateDateRangePicker();
            initializeTimePicker();
            selectize();
            form_element_show_hide();
            $('#' + sessionStorage.getItem('openTab')).collapse('show');
        })
    }

    function InitializeDatePicker() {
        $(".datepicker").datepicker({
            format: "d-M-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOnFocus: true,
        });
        $(".date-month-year").datepicker({
            format: "M-yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }

    InitializeDatePicker();

    function isJson(str) {
        try {
            var MyJSON = JSON.stringify(MyTestStr);
            var json = JSON.parse(MyJSON);
            if (typeof(MyTestStr) == 'string')
                if (MyTestStr.length == 0)
                    return false;
        } catch (e) {
            return false;
        }
        return true;
    }

    function resetGlobalActionAnchor() {
        GLOBAL_ACTION_ANCHOR.attr('href', "").attr('title', "").attr('class', 'hide');
    }

    function initiateWYSIWYG() {
        $('textarea.wysiwyg').tinymce({
            width: '100%',
            height: 300,
            toolbar: "responsivefilemanager  undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image table fullscreen | forecolor backcolor | code | mybutton",
            menubar: false,

            setup: function(editor) {
                editor.addButton('mybutton', {
                    type: 'menubutton',
                    text: 'Place holders',
                    icon: false,
                    // menu: [{
                    //     text: 'Insert New Section',
                    //     onclick: function() {
                    //         editor.insertContent('&nbsp;&nbsp;');
                    //     }
                    // }, ]
                });
            }
        });
    }

    initiateWYSIWYG();

    function number_format(num) {
        return num.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }


    function InitializePhoneNumberPicker() {
        /** 
        $('.phone_number').mask('(999) 999-9999');
        */
        $('.phone_number').mask('9999999999');
    }

    InitializePhoneNumberPicker();

    function selectize() {
        // $('.chosen-select, .selectize').chosen({
        //     allow_single_deselect: true
        // });

        $('.selectize').select2();
    }

    selectize();


    function changeInput(str) {
        alert(str);
    }

    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var cellContent = '';
        if (rowCount < 100) {
            /** limit the user from creating fields more than your limits*/
            var row = table.insertRow(rowCount);
            row.id = (rowCount - 1) + '_rowdata';
            var colCount = table.rows[0].cells.length;
            for (var i = 0; i < colCount; i++) {
                cellContent = '';
                var newcell = row.insertCell(i);

                if (tableID == "dataTable3") {
                    cellContent = table.rows[1].cells[i].innerHTML;
                } else if (tableID == "activity_dates_table" && i == true) {
                    cellContent = table.rows[1].cells[i].innerHTML;
                    cellContent = cellContent.replace("[DAY]", "Day " + (rowCount - 1));
                } else if (tableID == "capacity_gaps_table") {
                    cellContent = table.rows[1].cells[i].innerHTML;
                    cellContent = cellContent.replace("[ROWID]", (rowCount - 1));
                } else if (tableID == 'none_gov_entities_table') {
                    cellContent = table.rows[1].cells[i].innerHTML;
                    cellContent = cellContent.replace(/\[ADD_NEW_ID]/g, (rowCount - 1));
                    $('#current_cell_count').val(rowCount - 1);
                } else {
                    cellContent = table.rows[1].cells[i].innerHTML;
                }


                /**$(cellContent).find('.chosen-container').remove()*/
                /**$(cellContent).find('select').css('display','block')*/
                /**cellContent = cellContent*/

                newcell.innerHTML = cellContent;


            }
            if (tableID == "activity_dates_table" || tableID == 'hearings_table') {
                initiateDateRangePicker(); /**add calendar for dates*/
                initializeTimePicker();
            }
        } else {
            alert("Maximum is 100.");
        }

        /**style_select()*/
        selectize();
    }

    function deleteRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        for (var i = 1; i < rowCount; i++) {
            /**0*/
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if (null != chkbox && true == chkbox.checked) {
                if (rowCount <= 2) {
                    /**limit the user from removing all the fields*/
                    alert("Cannot Remove all.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
    }


    function bootbox_confirm(box_title, url, table, reload_page = null, body_message = null) {
        Swal.fire({
            icon: 'warning',
            title: box_title,
            // html: extra_text || "Caution: This action wont be reversed!",
            html: body_message || "",
            confirmButtonText: 'Yes- Delete Record',
            cancelButtonText: 'No- Retain Record',
            showCancelButton: true,
            allowOutsideClick: false,
            backdrop: swalBuzyBackground
        }).then(async (result) => {
            // if user confirms then submit the form
            if (result.value) {
                pushNotificationLoader("deleting record")
                return fetch(url)
                    .then(response => {
                        /**console.log("response :: ",response)*/
                        if (response.ok) {
                            $('.modal').modal('hide');
                            pushNotification("Success", `${table} deleted successfully`, 'success');

                            if (reload_page) {
                                window.location.reload();
                                return;
                            }

                            loadListing()
                        } else {
                            pushNotificationError(response.statusText);
                        }
                    }).catch((error) => {
                        pushNotificationError('Something went wrong. Please contact system adminstrator');
                    });
            }

        });
    }


    function initiateDataTable(selector, table, id, extraParam) {
        // var url = listing[table]['url'].replace("%5BID%5D", id);
        // url = url.replace("%5BEXTRA%5D", extraParam);
        // var cols = listing[table]['cols'];

        // if ($.fn.DataTable.isDataTable('.' + selector)) {
        // 	$('.' + selector).DataTable().ajax.reload();
        // 	return;
        // }

        // $('.' + selector).DataTable({
        // 	"bDestroy": true,
        // 	responsive: false,
        // 	"bProcessing": true,
        // 	serverSide: true,
        // 	ajax: url,
        // 	columns: cols,
        // 	/* "autoWidth": true, */

        // 	/* dom: 'lSBftip', */
        // 	dom: "<'row'<'col-sm-3'l><'col-sm-3'S><'col-sm-6'f>>" +
        // 		"<'row'<'col-sm-12'tr>>" +
        // 		"<'row'<'col-sm-5'i><'col-sm-7'p>>",
        // 	buttons: [{
        // 			extend: 'copyHtml5',
        // 			text: 'Copy Table Details'
        // 		},
        // 		{
        // 			extend: 'excelHtml5',
        // 			text: 'Export To Excel'
        // 		},
        // 		{
        // 			extend: 'csvHtml5',
        // 			text: 'Export To CSV'
        // 		},
        // 		{
        // 			extend: 'pdfHtml5',
        // 			text: 'Generate PDF'
        // 		},
        // 	]
        // }, function(data) {
        // 	console.log("Data :::", data);
        // });

    }

    function initializeFilePicker() {
        $('.input-file').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false /**| true | large*/
            /**whitelist:'gif|png|jpg|jpeg'*/
            /**blacklist:'exe|php'*/
            /**onchange:''*/
        });
    }

    // initializeFilePicker();

    function form_element_show_hide() {
        /**.mgt-letter-section-select*/
        $('.section-exceptions-select').children("option").hide();
        var section = $('.mgt-letter-section-select').val();
        $('.section-exceptions-select').children("option[data-section=" + section + "]").show();
        $('.section-exceptions-container').show();

        /**file upload sections*/
        $('.module-sections-select').children("option").hide();
        var module = $('.attachment-module-select').val();
        $('.module-sections-select').children("option[data-module='" + module + "']").show();
        $('.module-sections-container').show();

        /**entity_type_selector*/
        $('.entity_type_category').children("option").hide();
        var entity_id = $('.entity_type_selector').val();
        $('.entity_type_category').children("option[data-type='" + entity_id + "']").show();
        $('.entity_type_selected_row').show();

        /**module_radio_checked*/
        $('.module_radio_checked input[type=radio]:checked').each(function() {
            var container = $(this).parents('.module_radio_checked').attr('data-module');
            $('.' + container).toggle(/grant_access/.test($(this).val()));
        });

        /**alert($(this).children("option:selected").text()); org_type_select*/
        var selected = $('.org_type_select').children("option:selected").val();
        $('.gov_entity_select,.non_gov_entity_select').removeAttr('name').attr('disabled', 'disabled').parents('.form-group.row').hide();
        if (selected == 'App\\Entity') {
            $('.gov_entity_select').removeAttr('disabled').attr('name', 'r_fld[organizable_id]').parents('.form-group.row').show();
        } else if (selected == 'App\\Provider') {
            $('.non_gov_entity_select').removeAttr('disabled').attr('name', 'r_fld[organizable_id]').parents('.form-group.row').show();
        }
        $('.chosen-container').css('width', '100%');


    }

    function form_element_show_hide_2() {
        /**file upload sections*/
        $('.module-sections-select-2').children("option").hide();
        var module = $('.attachment-module-select-2').val();
        $('.module-sections-select-2').children("option[data-module='" + module + "']").show();
        $('.module-sections-container').show();
    }


    function generate_entities_selected_form() {
        $.each(data, function(key, value) {
            html += '<div class="dcell">';
            html += '<img src="images/' + value.product + '.png"/>';
            html += '<label for="' + value.product + '">' + value.name + ':</label>';
            html += '<input type="text" id="' + value.product + '" name="' + value.product + '" value="0" stock="' + value.stock + '" price="' + value.price + '" required>';
            html += '</div>';
        });
        $('#yourContainerId').html(html);

    }

    function removeNumberCommas(value) {
        return parseInt(value.replace(/,/g, ''));
    }

    function showLoader() {
        Swal.fire({
            icon: 'info',
            title: '<span class="text-primary"><i class="fa fa-spinner fa-spin"></i></span>',
            html: 'Please Wait!!',
            showConfirmButton: false,
            allowOutsideClick: false,
            showCancelButton: true,
            backdrop: `rgb(113 176 230 / 40%)`
        })
    }

    function closeLoader() {
        Swal.close();
    }
</script>