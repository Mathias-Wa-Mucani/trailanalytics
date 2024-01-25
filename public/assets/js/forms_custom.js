var next_action = false;
var next_action_new_window = false;
var new_provider_from_form = false;
var origin = "";
var select_value = "";
var select_text = "";
var thisForm = "";
var thisBtn = "";

$("body").on(
    "click",
    "#randomActionModal .btnSubmit,.btnSubmit",
    function (event) {
        event.preventDefault();

        thisForm = $(this).parents("form");
        thisBtn = $(this);

        if ($(this).hasClass("btnApproval")) {
            var action_ = $(this).data("action");
            var recipient_ = $(this).data("recipient");

            thisForm.find(".app_recipient").val(recipient_);
            thisForm.find(".app_action").val(action_);
        }

        if ($(this).hasClass("submit-draft")) {
            thisForm.find("input,select,textarea").each(function () {
                if ($(this).hasClass("draft")) {
                    console.log("is draft");
                    $(this).removeAttr("required");
                }
            });

            thisForm.find(".is-final").val(0);
        } else {
            thisForm.find("input,select,textarea").each(function () {
                if ($(this).data("is-required")) {
                    $(this).attr("required", "required");
                }
            });
            thisForm.find(".is-final").val(1);
        }

        var formId = thisForm.attr("id");
        console.log("form id ", formId);

        var whatNext = thisForm.data("next");
        var whatNextNewWindow = thisForm.data("next-new-window");

        next_action = whatNext == "1" ? true : false;
        next_action_new_window = whatNextNewWindow == "1" ? true : false;

        // console.log("next_action", next_action);

        origin = $(this).attr("data-origin");
        if (/person_select/i.test(origin)) {
            select_text =
                $("#" + formId + " #c_f_name").val() +
                " " +
                $("#" + formId + " #c_l_name").val();
        } else {
            select_text = $("#" + formId + " #orgname").val();
        }

        new_provider_from_form = /from_form/i.test(origin);

        //if validation fails return false else save_frm()
        if (!validate_form(formId)) {
            return false;
        }

        // confirm form submission
        if ($(this).hasClass("confirm-submission")) {
            var ConfirmText = "Confirm Submission";
            // check where confirmation text is embeded
            var ConfirmSubmissionElement = thisForm.find(
                ".confirm-submission-element"
            );
            // console.log("ConfirmSubmissionElement ::: ", ConfirmSubmissionElement);
            var ConfirmWithCaution =
                ' <br/> <div class="text-danger"> Caution: This action wont be reversed! </div> ';
            if (
                ConfirmSubmissionElement &&
                ConfirmSubmissionElement.data("confirm-element-type") ==
                    "select"
            ) {
                ConfirmText =
                    "Confirm you want to : " +
                    ConfirmSubmissionElement.children("option:selected").data(
                        "confirm-text"
                    );
                ConfirmText = `${ConfirmText} ${ConfirmWithCaution}`;
            }

            Swal.fire({
                icon: "info",
                title: "Confirm",
                html: ConfirmText,
                showCancelButton: true,
                confirmButtonText: `Confirm`,
                backdrop: swalBuzyBackground,
            }).then((result) => {
                // if user confirms then submit the form
                if (result.value) {
                    save_frm(formId);
                }
            });
            return false;
        }

        save_frm(formId);
    }
);

$("body").on(
    "click",
    ".btnGenerateReport,.btnGenerateReport",
    function (event) {
        event.preventDefault();
        var formId = $(this).parents("form").attr("id");

        //alert(formId)
        //if validation fails return false else save_frm()
        if (!validate_form(formId)) {
            return false;
        }
        generate_report(formId);
    }
);

$("body").on("change", ".btn-condition", function () {
    //alert('open')
    if ($(".btn-condition:checked").val() == "Bad") {
        $(".bad-condition").toggle(true);
    } else {
        $(".bad-condition").toggle(false);
    }
});

$("body").on("change", ".btn-sticker", function () {
    //alert('open')
    if ($(".btn-sticker:checked").val() == "Damaged") {
        $(".bad-sticker").toggle(true);
    } else {
        $(".bad-sticker").toggle(false);
    }
});

//function to save by ajax
function save_frm(frm) {
    var values = $("#" + frm).serialize();
    var frmAction = $("#" + frm).attr("action");

    // Saves all contents
    tinyMCE.triggerSave();
    // tinyMCE.triggerSave(true,true);

    pushNotificationLoader();

    if ($("#" + frm).find($(".import")).length > 0) {
        var formData = new FormData($("#" + frm)[0]);
        $.ajax({
            url: frmAction, //Server script to process data
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            //Options to tell jQuery not to process data or worry about content-type.
            processData: false,
            //Ajax events
            /*beforeSend: beforeSendHandler,*/
            success: function (message) {
                completeHandler(frm, message);
            },
            /*error: errorHandler,*/
            // Form data
        });
    } else {
        $.ajax({
            type: "POST",
            url: frmAction,
            data: "myData=" + values,
            cache: false,
            success: function (message) {
                completeHandler(frm, message);
            },
            error: function (message) {
                //console.log(message.responseJSON)
                var display_msg = "";
                var msg_string = message.responseJSON.message;
                if (/Data too long/i.test(msg_string)) {
                    display_msg = "One of the field strings is too long";
                } else if (/Duplicate entry/i.test(msg_string)) {
                    display_msg =
                        "This Record already exists in the System. It can not be added again!";
                } else {
                    display_msg =
                        "There is an error. Please contact administrator";
                }

                //$('.submit_msg').html('<div class="infomsg alert alert-danger">...There was an error. <br> '+message+'...</div>').show();
                pushNotification(
                    '<span class="text-danger">Error Submission</span>',
                    '<span class="text-danger">' + display_msg + "</span>",
                    "error"
                );

                loadListing();
            },
        });
    }

    setTimeout(function () {
        $(".submit_msg").fadeOut("slow").html("");
    }, 10000);
}

async function completeHandler(frm, response) {
    // alert('success');
    //$('#'+frm+' .saveBtn,#'+frm+' .btnFrm').val('...Submitted');

    let form = $("#" + frm);

    if (response.error_code) {
        pushNotification("Error", response.message, "error");
        return;
    }
    console.log(response);
    var frmModal = $("#" + frm).closest(".modal");
    var btnClass = "alert-success";
    if (/successfully/i.test(response.message)) {
        //window.location.href = _base_path_+"/#";
        if (next_action) {
            loadListing();
            var entry_id = response.id;
            // var route_next = $('#' + frm).attr('data-next')
            var route_next = thisForm.data("next-modal-route");
            var triggerModal = $(".trigger_modal");
            // var currentTriggerModalType = triggerModal.data("modal-target");

            // if (thisForm.attr("data-parent")) {
            // }
            route_next = route_next + "&ModelId=" + response.id;

            console.log("route next", route_next);
            // return;
            triggerModal.attr("href", route_next);
            // triggerModal.attr(thisForm.attr("data-modal-type"));
            triggerModal.attr(
                "data-modal-type",
                thisForm.attr("data-next-modal-type")
            );

            triggerModal.attr("title", thisForm.data("next-modal-title"));
            closeNextModal(frmModal);

            await Swal.fire({
                icon: "success",
                title: "Data successfully saved",
                html: "Continue to Next Part?",
                showCancelButton: true,
                confirmButtonText: `Yes - Continue`,
                cancelButtonText: `No - Discard`,
                allowOutsideClick: false,
                // backdrop: `rgb(113 176 230 / 40%)`
                backdrop: swalBuzyBackground,
            }).then(async (result) => {
                // if user confirms then submit the form
                if (result.value) {
                    if (next_action_new_window) {
                        window.location.href = route_next;
                        return;
                    } else {
                        triggerModal.trigger("click");
                    }
                } else {
                    form.trigger("resest");
                    document.getElementById(frm).reset();
                    pushNotificationClose();
                }
            });

            next_action = false;

            // route_next = route_edit.replace("%5BID%5D", entry_id)
            // $.get(route_next, function(){
            // 	$('.modal-body.ajaxLoad').attr('data-route', route_next);

            // });

            return;
        } else {
            if ($("#" + frm).hasClass("reload_page")) {
                pushNotification(
                    '<span class="text-success">Success</span>',
                    response.message,
                    "success"
                );
                setTimeout(function () {
                    location.reload();
                }, 500);
                return;
            }

            resetFrm(frm);
            if (frmModal.hasClass("new-entry")) {
                loadListing();
                closeNextModal(frmModal);
                Swal.fire({
                    icon: "success",
                    title: "Data successfully saved",
                    html: "Would you like to Add a New Record?",
                    showCancelButton: true,
                    confirmButtonText: `Yes - Add a New Record`,
                    cancelButtonText: `No - Close Instead`,
                    allowOutsideClick: false,
                    // backdrop: `rgb(113 176 230 / 40%)`
                    backdrop: swalBuzyBackground,
                }).then(async (result) => {
                    // if user confirms then submit the form
                    if (result.value) {
                        GLOBAL_ACTION_ANCHOR.trigger("click");
                    }
                    // if (!result.value)
                });
                return;
            } else {
                closeNextModal(frmModal);
                resetGlobalActionAnchor();
            }
        }
        loadListing();
        $(".modal-body.ajaxLoad").attr("data-route", "");
        //$('.modal').modal('hide');
        //load_refresh()
    } else {
        //resetFrm(frm);
        //btnClass = 'alert-danger'
        if (response.success == "warning") {
            pushNotification("Warning", message.message, "warning");
            return 1;
        } else {
            pushNotification(
                '<span class="text-danger">Error</span>',
                response.message,
                "error"
            );
            return 1;
        }
    }

    if (response.message) {
        pushNotification(
            '<span class="text-success">Success</span>',
            response.message,
            "success"
        );
    } else {
        pushNotification(
            '<span class="text-warning">Warning</span>',
            "No action Taken",
            "warning"
        );
    }
}

function resetFrm(frm) {
    $(
        "#" + frm + " input,#" + frm + " select,#" + frm + " checkbox"
    ).removeAttr("disabled");
    $("#" + frm).trigger("reset");
    document.getElementById(frm).reset();
}

function closeNextModal(modal) {
    // if ($('#TertiaryModal').hasClass('in')) $('#TertiaryModal').modal('hide')
    // else if ($('.bs-fill-modal').hasClass('in')) $('.bs-fill-modal').modal('hide')
    // else if ($('#randomActionModal').hasClass('in')) $('#randomActionModal').modal('hide')
    modal.modal("hide");
}

function pushNotification(title, body_text, type) {
    // Swal.fire(title, body_text, type)
    body_text = body_text ?? "No action Taken";
    Swal.fire({
        icon: type,
        title: title,
        html: body_text,
        allowOutsideClick: false,
        showCloseButton: true,
    });
}

function pushNotificationClose() {
    Swal.close();
}

function pushNotificationLoadingData(title) {
    title = title || "Please wait";
    Swal.fire({
        icon: "info",
        title:
            '<span class="text-primary"><i class="fa fa-spinner fa-spin"></i> ' +
            title +
            " </span>",
        html: "Please Wait!!",
        allowOutsideClick: false,
        showCancelButton: true,
        showConfirmButton: false,
    });
}

function pushNotificationLoader(title) {
    title = title || "saving data";
    Swal.fire({
        icon: "info",
        title:
            '<span class="text-primary"><i class="fa fa-spinner fa-spin"></i> ' +
            title +
            "</span>",
        html: "Please Wait!!",
        showConfirmButton: false,
        allowOutsideClick: false,
        showCancelButton: true,
        backdrop: swalBuzyBackground,
    });
}

function pushNotificationError(error = null, title = null) {
    Swal.fire({
        icon: "error",
        title: title || "Error!",
        html: error || "Something went wrong",
        showConfirmButton: false,
        showCloseButton: true,
    });
}

function pushNotificationInsertQueueStep(title, body_text, type) {
    Swal.insertQueueStep({
        icon: type,
        title: title,
        html: body_text,
    });
}
