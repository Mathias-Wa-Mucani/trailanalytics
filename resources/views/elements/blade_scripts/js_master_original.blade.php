<script type="text/javascript">
	var actionAuthorized = false;
	$(document).on('click', 'button[value=Delete],button[value=Deactivate],button[value="Auto Deactivate"]', function(e) {
		var action = $(this).val();
		var btn = $(this);
		if (actionAuthorized) {
			actionAuthorized = false;
			return;
		}
		e.preventDefault();
		if (action == 'Deactivate') {
			bootbox.prompt("Give reasons for Deactivation?", function(result) {
				if (result === null) {
					alert('Please specify reason for deactivation');
				} else {
					$('.reason_text').val(result);
					actionAuthorized = true;
					btn.trigger('click');
				}
			});
		} else {
			bootbox.confirm('Are you sure you want to ' + action + '!', function(result) {
				if (result) {
					actionAuthorized = true;
					btn.trigger('click');
				}
			});
		}

	});

	/*keep track of open tabs*/
	/* $(document).on('click','.accordion-toggle',function(){

	}) */
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

	$(window).on('resize.ace.top_menu', function() {
		/* $(document).triggerHandler('settings.ace.top_menu', ['sidebar_fixed' , $sidebar.hasClass('sidebar-fixed')]);*/
	});

	function InitializePhoneNumberPicker() {
		/** 
		$('.phone_number').mask('(999) 999-9999');
		*/
		// $('.phone_number').mask('9999999999');
	}

	function resetGlobalActionAnchor() {
		GLOBAL_ACTION_ANCHOR.attr('href', "").attr('title', "").attr('class', 'hide');
	}

	/*Stylize our selects*/
	function selectize() {
		
	}

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
</script>


<!-- query analyzer code -->
<script type="text/javascript">
	var $validation = true;

	$(document).on('change', '.query_operator', function() {
		try {
			/**$(this).parents('tr').find('.calendar').datepicker('destroy')*/
			$(this).parents('tr').find('.calendar').data('datepicker').remove();
		} catch (error) {
			console.log(error);
		}
		try {
			$(this).parents('tr').find('.calendar').data('daterangepicker').remove();
		} catch (error) {
			console.log(error);
		}

		if ($(this).val() == 'BETWEEN') {
			/**$(this).parents('tr').find('.date-picker').removeClass('date-picker').addClass('date-range-picker').off()*/
			$(this).parents('tr').find('.calendar').daterangepicker({
				'applyClass': 'btn-sm btn-success',
				'cancelClass': 'btn-sm btn-default',
				format: "D MMM YYYY",
				locale: {
					applyLabel: 'Apply',
					cancelLabel: 'Cancel',
				}
			});
		} else {
			/**$(this).parents('tr').find('.date-range-picker').removeClass('date-range-picker').removeClass('hasDatepicker').addClass('date-picker').off()*/
			/**alert('am in')*/
			$(this).parents('tr').find('.calendar').datepicker({
				autoclose: true,
				todayHighlight: true,
				format: "d M yyyy"
			});
		}
		/**initiateDateRangePicker()*/
	});

	$(document).on("change", ".chk_select_all", function() {
		if ($(this).prop('checked')) {
			$('.chk_fields').prop('checked', true);
		} else {
			$('.chk_fields').prop('checked', false);
		}
	});

	function export_to(tableId) {
		var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
		var textRange;
		var j = 0;
		tab = document.getElementById(tableId); // id of table

		for (j = 0; j < tab.rows.length; j++) {
			tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
		}

		tab_text = tab_text + "</table>";
		tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); /**remove if u want links in your table*/
		tab_text = tab_text.replace(/<img[^>]*>/gi, ""); /**remove if u want images in your table*/
		tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); /**reomves input params*/

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf("MSIE ");

		if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) /**If Internet Explorer*/ {
			txtArea1.document.open("txt/html", "replace");
			txtArea1.document.write(tab_text);
			txtArea1.document.close();
			txtArea1.focus();
			sa = txtArea1.document.execCommand("SaveAs", true, "save report.xls");
		} else /**other browser not tested on IE 11*/
			sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

		return (sa);
	}
</script>

<script>
	$(document).ready(function() {
		/**data tables*/
		loadListing();

		/**chosen select*/
		selectize();

		/** control for image upload*/
		$('body').on('change', '.uploadimg', function() {
			var selObj = $(this).attr('class').split(' ');
			var frm = selObj[1];
			/**var ele = selObj[3]; var plan = selObj[2];*/
			var ele = $(this).parents('.input-control');
			var plan = $(this).parents('td').find('span.formImageInput');
			var url = "{{ route('upload_file','[FRM]') }}";
			url = url.replace("%5BFRM%5D", frm);
			uploadImage(url, ele, plan);
		});


		/**Delete row in a table*/
		$('body').on('click', '.delete-row', function() {
			var $this = $(this);
			var details = $(this).attr('class').split(' ');
			var route = details[1];
			var table = details[2];
			var pK = details[3];
			var id = details[4];
			var url = '/dashboard/delete/' + table + '/' + id;
			var $output_str = "";
			var $output_str_blocked = "";
			var $output_str_warning = "";
			var $general_message = 'Are you sure you want to delete ' + table + '!';
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
				bootbox_confirm($output_str, url, table);
			}
			return false;
		});

		function bootbox_confirm(body_message, url, table) {
			Swal.queue([{
				title: '<span class="text-danger">Confirm Delete</span>',
				confirmButtonText: 'Yes- Delete Record',
				cancelButtonText: 'No- Retain Record',
				text: body_message,
				showLoaderOnConfirm: true,
				showCancelButton: true,
				icon: 'error',
				backdrop: swalBuzyBackground,
				preConfirm: () => {
					return fetch(url)
						.then(response => {
							/**console.log("response :: ",response)*/
							if (response.ok) {
								pushNotificationInsertQueueStep('<span class="text-success">Success</span>', table + " deleted successfully", 'success');
								loadListing()
							} else {
								pushNotificationInsertQueueStep('<span class="text-danger">Error</span>', response.statusText, 'error');
							}
						}).catch((error) => {
							pushNotificationInsertQueueStep('<span class="text-danger">Error</span>', 'Something went wrong. Please contact system adminstrator', 'error');
						});
				}
			}]);
		}


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
						pushNotification('<span class="text-danger">Error</span>', "" + response.message, 'error');
					}

				},
				error: function(error) {
					pushNotification('<span class="text-danger">Error</span>', 'Seems like something went wrong!!<br>', 'error');
				}
			});
		});


	});

	/**function to load datatable lists on pages*/
	function loadListing() {
		if ($('.data-table').length > 0) {
			$('.data-table,.inner-table').each(function() {
				var table = $(this).attr('class').split(' ')[1];
				var id = $(this).attr('class').split(' ')[2];
				var extraParam = $(this).attr('class').split(' ')[3];
				$(this).css('width', '100%');
				initiateDataTable(table, table, id, extraParam);
			});
		}
		if ($('.ajaxLoad').length > 0) {
			$('.ajaxLoad').each(function() {
				var route = $(this).attr('data-route');
				if (route != '') loadPart($(this), route);
			});
		}
	}

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
</script>

@include('partials.listings');

<script>
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

	$(document).ready(function() {
		// $('#example').DataTable({
		// 	dom: 'Bfrtip',
		// 	buttons: [{
		// 			extend: 'copyHtml5',
		// 			exportOptions: {
		// 				columns: [0, ':visible']
		// 			}
		// 		},
		// 		{
		// 			extend: 'excelHtml5',
		// 			exportOptions: {
		// 				columns: ':visible'
		// 			}
		// 		},
		// 		{
		// 			extend: 'pdfHtml5',
		// 			exportOptions: {
		// 				columns: [0, 1, 2, 5]
		// 			}
		// 		},
		// 		'colvis'
		// 	]
		// });
	});


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

	function form_selector_checkbox() {
		/**console.log(data.topics)*/
		data.items = [];
		var item_count = 0;
		$('.form_selector_checkbox:checked').each(function() {
			item_count += 1;
			var item = {
				brief_table_type: $(this).data('table-type'),
				brief_table_id: $(this).data('table-id'),
				brief_section: $(this).data('section'),
				pm_activity_id: $(this).data('activity-id'),
				id: ""
			};
			data.items.push(item);
			/**console.log(data)*/
		});
		$("#items").html(Mustache.to_html(issues_template, data));
		$("#item_count").html("(" + item_count + ")");
	}

	function entity_selector_checkbox() {
		/**console.log(data.topics)*/
		data.entities = [];
		var item_count = 0;
		$('.entity_selector_checkbox:checked').each(function() {
			item_count += 1;
			var item = {
				entity_id: $(this).data('entity-id'),
				audit_type: $(this).data('audit-type'),
				pm_plan_id: $(this).data('pm-plan-id'),
				previous_performance_score: $(this).data('prev-rating'),
				previous_performance_category: $(this).data('prev-category'),
				id: "",
			};
			data.entities.push(item);
			/**console.log(data)*/
		});
		$("#entities").html(Mustache.to_html(entities_template, data));
		$("#item_count").html("(" + item_count + ")");
	}


	function drawReportAnalysisGraph() {
		$('.report_analysis_bar_graph').highcharts({
			data: {
				table: 'report_graph_data'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			xAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			tooltip: {
				formatter: function() {
					return '' + this.point.name + '<br/>' +
						this.series.name + '<br/>' +
						'<b>' + this.point.y.toLocaleString() + '</b> ';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}
			},
		});
		$('.report_analysis_graph').highcharts({
			data: {
				table: 'report_graph_data'
			},
			chart: {
				type: 'pie'
			},
			title: {
				text: ''
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			xAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			tooltip: {
				formatter: function() {
					return '' + this.point.name + '<br/>' +
						'<b>' + this.point.y.toLocaleString() + '</b> ';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}
			},
		});
		$('.report_analysis_pie_graph').highcharts({
			data: {
				table: 'report_graph_data'
			},
			chart: {
				type: 'pie'
			},
			title: {
				text: ''
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			xAxis: {
				allowDecimals: false,
				title: {
					text: ''
				}
			},
			tooltip: {
				formatter: function() {
					return '' + this.point.name + '<br/>' +
						'<b>' + this.point.y.toLocaleString() + '</b> ';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}
			},
		});
	}
</script>

<script>
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
		var url = "{{ route('model_options','[Model]') }}";
		url = `${url.replace("%5BModel%5D", "County")}?ParentModel=District&ParentModelId=${districtCode}`;
		$.get(url, function(result) {
			console.log(result);
			$('.select-location-county').html(result);
			selectize();
		});
	});

	$('body').on('change', '.select-location-county', function() {
		var countyCode = $(this).val();
		var url = "{{ route('model_options','[Model]') }}";
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

	function removeNumberCommas(value) {
		return parseInt(value.replace(/,/g, ''));
	}

	$('body').on('change', '.location_selection', function() {
		var Target = $(this).data('selection-target');
		var filterField = $(this).data('filter-field');
		var filterFieldID = $(this).val();
		var fillElement = $(`.location_selection.${Target}`);
		if (Target == "County") {
			$('.location_selection.County, .location_selection.SubCounty, .location_selection.Parish, .location_selection.Village').html('');
		} else if (Target == "SubCounty") {
			$('.location_selection.SubCounty, .location_selection.Parish, .location_selection.Village').html('');
		} else if (Target == "Parish") {
			$('.location_selection.Parish, .location_selection.Village').html('');
		} else if (Target == "Village") {
			$('.location_selection.Village').html('');
		}

		if ($(this).hasClass('end-selection') || $(this).hasClass('last-selection') || !filterFieldID) {
			return;
		}

		var url = `{{ route('location_helper') }}?Target=${Target}&filterField=${filterField}&filterFieldID=${filterFieldID}`;
		pushNotificationLoader("Loading sections");
		$.get(url, function(result) {
			selectize();
			console.log("fillElement.data('allow-all') ::: ", fillElement.data('allow-all'));
			fillElement.html(result);
			if (fillElement.data('allow-all')) {
				fillElement.children("option[data-value='default']").remove();
				fillElement.prepend(`<option value="0" selected>All</option>`);
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
		var _this = $(this);
		var section = _this.data('section');
		var show_section = _this.data('show-section');
		console.log("section", section);
		$(`.${section}_section`).addClass('hide');
		$(`.${section}_field`).removeAttr('required');

		if (show_section) {
			$(`.${section}_section`).removeClass('hide');
			$(`.${section}_field`).each(function() {
				if ($(this).data("is-required")) {
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

	$('.modal').on('hidden.bs.modal', function() {})
</script>