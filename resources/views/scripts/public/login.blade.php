<script>
    "use strict";
    var KTSigninGeneral = function() {
        var submitForm, submitButton, validateForm; //t=form, e=button, r=validations
        return {
            init: function() {
                submitForm = document.querySelector("#kt_sign_in_form"), submitButton = document.querySelector(
                    "#kt_sign_in_submit"), validateForm = FormValidation.formValidation(submitForm, {
                    fields: {
                        email: {
                            validators: {
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: "The value is not a valid email address"
                                },
                                notEmpty: {
                                    message: "Email address is required"
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "The password is required"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                }), ! function(submitForm) {
                    try {
                        return new URL(submitForm), !0
                    } catch (submitForm) {
                        return !1
                    }
                }; /*(submitButton.closest("form").getAttribute("action")) ?*/
                submitButton.addEventListener("click", function(e) {
                    // function(i) {
                        console.log(new FormData(submitForm));

                        // i.preventDefault(), 
                        validateForm.validate().then((function(validateForm) {
                            "Valid" == validateForm ? (submitButton.setAttribute(
                                    "data-kt-indicator", "on"), submitButton
                                .disabled = !0, setTimeout((function() {
                                    submitButton.removeAttribute(
                                            "data-kt-indicator"),
                                        submitButton
                                        .disabled = !1, axios.post(submitButton
                                            .closest("form")
                                            .getAttribute("action"),
                                            new FormData(submitForm))
                                        .then((
                                            function(e) {
                                                if (e) {
                                                    submitForm.reset(), Swal
                                                        .fire({
                                                            text: "You have successfully logged in!",
                                                            icon: "success",
                                                            buttonsStyling:
                                                                !1,
                                                            confirmButtonText: "Ok, got it!",
                                                            customClass: {
                                                                confirmButton: "btn btn-primary"
                                                            }
                                                        });
                                                    const e = submitForm
                                                        .getAttribute(
                                                            "data-kt-redirect-url"
                                                        );
                                                    e && (location.href = e)
                                                } else Swal.fire({
                                                    text: "Sorry, the email or password is incorrect, please try again.",
                                                    icon: "error",
                                                    buttonsStyling:
                                                        !1,
                                                    confirmButtonText: "Ok, got it!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                })
                                            })).catch((function(t) {
                                            Swal.fire({
                                                text: "Sorry, looks like there are some errors detected, please try again.",
                                                icon: "error",
                                                buttonsStyling:
                                                    !1,
                                                confirmButtonText: "Ok, got it!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            })
                                        })).then((function(submitButton) {
                                            if (submitButton
                                                .isConfirmed) {
                                                submitForm
                                                    .querySelector(
                                                        '[name="email"]'
                                                    ).value = "",
                                                    submitForm
                                                    .querySelector(
                                                        '[name="password"]'
                                                    ).value = "";
                                                var r = submitForm
                                                    .getAttribute(
                                                        "data-kt-redirect-url"
                                                    );
                                                r && (location.href = r)
                                            }
                                        }))
                                }), 2e3)) : Swal.fire({
                                title: "Error",
                                text: "Sorry, some errors detected, please read the error messages below each field!!",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    // }
                });

            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTSigninGeneral.init()
    }));
</script>
