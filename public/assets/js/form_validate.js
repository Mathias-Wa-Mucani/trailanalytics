$("body").on("blur change keyup checked", "input,select,textarea", function () {
    return validate_control($(this));
});

/**
 * This is called when you press the submit/save button on the form.
 * This does the general sweeping...
 * to check whether we are submitting the form but with errors
 * it checks the entire form frm
 * @param frm
 */
let message_list = $(".validation-error-message-list");
let error_elements = [];
function validate_form(frm) {
    message_list.empty();
    $("#" + frm)
        .find(".panel-heading a")
        .removeClass("accordion-panel-form-error");
    var valid = true;
    var errors = 0;
    var requiredFieldElements = "input,select, textarea";
    var ignoredFieldElements = ":submit, :reset, :image, [disabled],:hidden";
    $("#" + frm)
        .find(requiredFieldElements)
        .not(ignoredFieldElements)
        .each(function () {
            errors += validate_control($(this)) ? 0 : 1;
            // if ($(this).attr("required") && !$(this).val()) {
            //     let message = `${$(this).parent("div").find("label").text()}`;

            //     $("<li>" + message + "</li>").appendTo(message_list);

            //     error_elements.push($(this));
            // }
        });
    // valid = false
    // return valid;
    // reorganize_accordion_sections(frm,requiredFieldElements,ignoredFieldElements);

    valid = errors == 0 ? true : false;

    if (!valid && error_elements.length) {
        // pushNotificationError(
        //     message_list,
        //     "The following fields are required"
        // );
        message_list.empty();
    }

    if (!valid) {
        pushNotificationError(
            `<div class="mb-10 text-danger"> Please fill required fields </div>`
        );
    }
    return valid;
}

function reorganize_accordion_sections(
    frm,
    requiredFieldElements,
    ignoredFieldElements
) {
    let accordionSection = $("#" + frm).find(".panel-group");
    let form_sections = accordionSection.find(".panel");
    console.log("form_sections count", form_sections.length);
    form_sections.each(function () {
        let panel_section = $(this);
        let panel_heading = panel_section.find(".panel-heading a");

        let is_valid_section = true;
        panel_section.find(requiredFieldElements).each(function () {
            let el = $(this);
            if (el.attr("required") && !el.val()) {
                is_valid_section = false;
            }
        });

        console.log("Valid Section :: ", is_valid_section);
        if (is_valid_section) {
            // panel_heading.addClass("collapsed").attr("aria-expanded", false);
            // panel_section.find('panel-collapse').removeClass('in');
            if (!panel_heading.hasClass("collapsed")) {
                panel_heading.trigger("click");
            }
        }
    });
}

/**
 * This is the end function that is called on an individual control
 * (input, select, textarea, checkbox, radio)
 * @param el jquery-element
 */
function validate_control(el) {
    var frm = el.parents("form");
    //reset form validation information
    if (/input-file/i.test(el.attr("class"))) {
        el.parent("label")
            .parent("div")
            .removeClass("empty-input invalid-input has-error")
            .addClass("valid-input")
            .find(".error")
            .remove();
    } else if (el.is(":radio")) {
        frm.find('input[name="' + el.attr("name") + '"]').each(function () {
            $(this)
                .closest("div")
                .removeClass("empty-input invalid-input has-error")
                .addClass("valid-input")
                .find(".error")
                .remove();
        });
        // console.log("radios", radios);
        // for (var i = 0, length = radios.length; i < length; i++) {
        //     console.log("radios[i]", radios[i]);
        //     let radio = radios[i];
        //     radio
        //         .closest("div")
        //         .removeClass("empty-input invalid-input has-error")
        //         .addClass("valid-input")
        //         .find(".error")
        //         .remove();
        // }
        // el.closest("div")
        //     .removeClass("empty-input invalid-input has-error")
        //     .addClass("valid-input")
        //     .find(".error")
        //     .remove();
    } else {
        el.parent("div")
            .removeClass("empty-input invalid-input has-error")
            .addClass("valid-input")
            .find(".error")
            .remove();
    }
    //end reset

    /**
     * Define your validation rules here
     * You can use selector classes to impose certain validation rules
     * Remember we are dealing with the input element directly
     */

    //check if required and empty
    if (el.attr("required") && isEmpty(el.val())) {
        // check if input if file
        if (/input-file/i.test(el.attr("class"))) {
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append('<span class="error">This file is required!!</span>');
        } else {
            el.closest("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append('<span class="error">This is required!!</span>');
        }
        NotifyAccordionError(el);
        // message += "oops";
        return false;
    }

    // check radio inputs
    // el[0].checked
    // && !el.is(':checked')
    if (el.attr("required") && el.is(":radio")) {
        var radios = frm.find('input[name="' + el.attr("name") + '"]');
        var checked = false;
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                checked = true;
                // only one radio can be logically checked, don't check the rest
                break;
                // return true;
            }
        }

        if (!checked) {
            el.closest("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    '<span class="ml-12 error"> This is required!!!</span>'
                );
            var validation_label = el
                .closest("div")
                .find("label.validation-message");
            if (
                validation_label &&
                validation_label.data("validation-message")
            ) {
                $(
                    "<li>" +
                        validation_label.data("validation-message") +
                        "</li>"
                ).appendTo(message_list);
                error_elements.push(el);
            }

            NotifyAccordionError(el);
            return false;
        }
    }

    if (el.attr("required") && el.is(":checkbox") && !el.is(":checked")) {
        el.closest("div")
            .removeClass("valid-input")
            .addClass("empty-input has-error")
            .append('<span class="error"> This is required!!!</span>');
        NotifyAccordionError(el);
        return false;
    }

    //check phone number
    if (
        /phone_number/i.test(el.attr("class")) &&
        !validPhone(el.val()) &&
        !isEmpty(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append(
                '<span class="error">This is not a valid phone number! Enter in the format <em> 07XXXXXXXX </em></span>'
            );
        NotifyAccordionError(el);
        return false;
    }
    //check email
    if (
        /email/i.test(el.attr("class")) &&
        !validEmail(el.val()) &&
        !isEmpty(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append(
                '<span class="error">This is not a valid email address!</span>'
            );
        NotifyAccordionError(el);
        return false;
    }

    //check password confirmation
    if (el.attr("name") == "confirm_password" && !isEmpty(el.val())) {
        console.log("Element value ::: ", el.val());
        if (frm.find('input[name="r_fld[password]"]').val() != el.val()) {
            el.parent("div")
                .removeClass("valid-input")
                .addClass("invalid-input")
                .append('<span class="error">Passwords dont match!</span>');
            NotifyAccordionError(el);
            return false;
        }
    }

    //check sex
    if (
        /sex/i.test(el.attr("class")) &&
        !validSex(el.val()) &&
        !isEmpty(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append('<span class="error">This is not a valid sex!</span>');
        NotifyAccordionError(el);
        return false;
    }

    //check name
    if (
        /name/i.test(el.attr("class")) &&
        !isEmpty(el.val()) &&
        !validName(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append('<span class="error">This is not a valid name!</span>');
        NotifyAccordionError(el);
        return false;
    }

    //check nin
    if (
        /nin/i.test(el.attr("class")) &&
        !isEmpty(el.val()) &&
        !validNiN(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append('<span class="error">This is not a valid nin!</span>');
        NotifyAccordionError(el);
        return false;
    }

    //check tin number
    if (
        /tin_number/i.test(el.attr("class")) &&
        !isEmpty(el.val()) &&
        !validTin(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append(
                '<span class="error">This is not a valid tin number!</span>'
            );
        NotifyAccordionError(el);
        return false;
    }

    //check website
    if (
        /website/i.test(el.attr("class")) &&
        !validWebsite(el.val()) &&
        !isEmpty(el.val())
    ) {
        el.parent("div")
            .removeClass("valid-input")
            .addClass("invalid-input")
            .append('<span class="error">This is not a valid Website!</span>');
        NotifyAccordionError(el);
        return false;
    }

    //check images
    if (/image-file/i.test(el.attr("class")) && !isEmpty(el.val())) {
        if (!validImage(el) || !allowedFileSize(el)) {
            // alert('not valid image');
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    `<span class="error"> Only Images (png, jpeg, jpg, gif) and maximum ${MAX_FILE_UPLOAD_SIZE_MBS}mb !!</span>`
                );
            NotifyAccordionError(el);
            return false;
        }
    }

    //check images
    if (/doc-file/i.test(el.attr("class")) && !isEmpty(el.val())) {
        if (!validDocFile(el)) {
            // alert('not valid image');
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    `<span class="error"> Only PDF files are alllowed !!</span>`
                );
            NotifyAccordionError(el);
            return false;
        }

        if (!allowedFileSize(el)) {
            // alert('not valid image');
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    `<span class="error"> Only PDF and maximum ${MAX_FILE_UPLOAD_SIZE_MBS}mb !!</span>`
                );
            NotifyAccordionError(el);
            return false;
        }
    }

    //check doc or images
    if (/image_doc_file/i.test(el.attr("class")) && !isEmpty(el.val())) {
        if (!validImage(el) && !validDocFile(el)) {
            // alert('not valid image');
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    '<span class="error"> Only PDF and Images (png, jpeg, jpg, gif) are accepted !!</span>'
                );
            NotifyAccordionError(el);
            return false;
        }

        if (!allowedFileSize(el)) {
            // alert('not valid image');
            el.parent("label")
                .parent("div")
                .removeClass("valid-input")
                .addClass("empty-input has-error")
                .append(
                    `<span class="error"> Maximum file size should be ${MAX_FILE_UPLOAD_SIZE_MBS}mb !!</span>`
                );
            NotifyAccordionError(el);
            return false;
        }
    }

    return true;
}

function NotifyAccordionError(el) {
    el.parents(".panel")
        .find(".panel-heading h4 a")
        .addClass("accordion-panel-form-error");
}

/**
 * These are validation functions
 * Just call them in the script lines above as you may wish
 */
function validEmail(email) {
    return /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,100}$/.test(
        email
    );
}
function isValidPassword(input) {
    var reg = /^[^%\s]{6,}$/;
    var reg2 = /[a-zA-Z]/;
    var reg3 = /[0-9]/;
    return reg.test(input) && reg2.test(input) && reg3.test(input);
}
function isEmpty(str) {
    return str == "";
}
function validName(name) {
    // return true;
    name = name.trim();
    return /^[a-zA-Z]+(\s{0,3}[a-zA-Z-])*$/.test(name);
}
function validPhone(phone) {
    phone = phone.trim();
    // return /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(phone);
    return /^\d{3}\d{3}\d{4}( x\d{1,6})?$/.test(phone);
    // return /^\+[0-9]{3}[0-9]{3}[0-9]{6}$/.test(phone)
    // return /^\+[0-9]{3}\s[0-9]{3}\s[0-9]{6}$/.test(phone)
}

function validSex(sex) {
    return ["Male", "Female"].indexOf(sex) >= 0 ? true : false;
}

function validNiN(nin) {
    var size = nin.length;
    return size == 14 && alphanumeric(nin) ? true : false;
}

function validTin(value) {
    var size = value.length;
    return size == 10 && is_numeric(value) ? true : false;
}

// Function to check letters and numbers
function alphanumeric(inputtxt) {
    return /^[0-9a-zA-Z]+$/.test(inputtxt);
}

function is_numeric(inputtxt) {
    return /^[0-9a-zA-Z]+$/.test(inputtxt);
}

function validWebsite(website) {
    // return true;
    var pattern = new RegExp(
        "^(https?:\\/\\/)?" + // protocol
            "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
            "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
            "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
            "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
            "(\\#[-a-z\\d_]*)?$",
        "i"
    ); // fragment locator
    return !!pattern.test(website);
}

function isValidPostcode(p) {
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postcodeRegEx.test(p);
}

function validImage(el) {
    var validImageTypes = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
    var fileType = el[0].files[0].type;
    // console.log(fileType);
    return validImageTypes.indexOf(fileType) >= 0 ? true : false;
}

function validDocFile(el) {
    var validDocTypes = ["application/pdf"];
    var fileType = el[0].files[0].type;
    return validDocTypes.indexOf(fileType) >= 0 ? true : false;
}

function allowedFileSize(el) {
    var fileSize = el[0].files[0].size / 1024 / 1024;
    return fileSize < MAX_FILE_UPLOAD_SIZE_MBS ? true : false;
}
