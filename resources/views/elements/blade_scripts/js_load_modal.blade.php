<script type="text/javascript">
	jQuery(function($) {

		$('body').on('click', '.dynamic-modal', function(event) {
			event.preventDefault();
			let add_modal_bg = $(this).data('modal-bg');
			var modal_target = $(this).data('modal-target') || 'modal-default';
			var modal_selector = `#${modal_target}`
			var $msg_load_preview_wait = "" +
				"<div class='float-alert'>" +
				"<div class='float-alert-container'>" +
				"<div class='col-sm-9-'>" +
				"<h5 class='text-primary text-center'><i class='fa fa-globe'></i>&nbsp;Loading </h5>" +
				"<p class='text-center text-orange'>" + ModalPreloader +
				"</p>" +
				"</div>" +
				"</div>" +
				"</div>";

			$(modal_selector + ' .modal-body').removeClass('modal-body-bg').html($msg_load_preview_wait);
			/**$(modal_selector + ' .modal-title').html('Please wait...');*/
			$(modal_selector).removeClass('new-entry');
			$(modal_selector).modal('show');
			// return;

			var url = $(this).attr('href');
			var title = $(this).attr('title');
			$(modal_selector + ' .modal-title').html(title);

			resetGlobalActionAnchor();

			/**
			if ($(this).hasClass('new-entry')) {
				GLOBAL_ACTION_ANCHOR.attr('href', url);
				GLOBAL_ACTION_ANCHOR.attr('title', title).attr('class', "hide").addClass(`new-entry ${class_selected}`);
				$(modal_selector).addClass('new-entry');
			}
			 */

			$.get(url, function(result) {
				if (result.message) {
					if (result.success) {
						pushNotification('<span class="text-success">Success</span>', result.message, 'success')
					} else {
						pushNotification('<span class="text-danger">Error</span>', result.message, 'error')
					}
					$(modal_selector).modal('hide');
					return;
				}

				if (add_modal_bg) $(modal_selector + ' .modal-body').addClass('modal-body-bg');

				$(modal_selector + ' .modal-body').html(result);
				InitializeDatePicker();
				// initSelect2();
				/**activateForm()*/
				// initiateDateRangePicker();
				// initializeTimePicker();
				// selectize();
				loadListing();
				initiateWYSIWYG();
				// initializeFilePicker();
				// form_element_show_hide();
				// InitiateImageColorBox();
				// InitializePhoneNumberPicker();
			});

		});
	});
</script>