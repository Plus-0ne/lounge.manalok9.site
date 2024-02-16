$(document).ready(function () {
    /* GET TIMEZONE */
    var tmzz = moment.tz.guess();
    $("#timezzz").val(tmzz);

    /* INPUT TEXT TO DATE */
    $(".dateInput").on("focus", function () {
        $(this).attr("type", "date");
    });

    /* BACK TO LAST URL */
    $("#backBtn_reg").on("click", function () {
        window.location = backUrl;
    });

    /* CLOSE PROMPT */
    $(document).on("click", ".prompt-closes", function () {
        $(this).parent().addClass("animate__flipOutX");

        setTimeout(() => {
            $(this).parent().remove();
        }, 500);
    });
    /* SHOW PASSWORD */
    $(".show_pass").on("click", function () {
        $("#password").attr("type", function (index, value) {
            // return value == 'password' ? 'text' : 'password';
            if (value == "password") {
                $(".show_pass").html('<i class="mdi mdi-eye-off-outline"></i>');
                return (value = "text");
            } else {
                $(".show_pass").html('<i class="mdi mdi-eye-outline"></i>');
                return (value = "password");
            }
        });
    });

    /* CREATE ACCOUNT */
    $("#submit_account").on("click", function (e) {
        e.preventDefault();

        var first_name = $("#first_name");
        var last_name = $("#last_name");
        var gender = $("#gender");
        var birth_date = $("#birth_date");
        var contact_number = $("#contact_number");
        // var email_address = $('#email_address');
        var password1 = $("#password1");
        var password2 = $("#password2");
        var timez = moment.tz.guess();
        var referral_code = $("#referral_code");
        $.ajax({
            type: "POST",
            url: "/ajax/create-account",
            data: {
                first_name: first_name.val(),
                last_name: last_name.val(),
                gender: gender.val(),
                birth_date: birth_date.val(),
                contact_number: contact_number.val(),
                password1: password1.val(),
                password2: password2.val(),
                referral_code: referral_code.val(),
                timez: timez,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $("#submit_account").html("CREATING...");
            },
            success: function (response) {
                if (response.status == "account_created") {
                    $(".promptss-v2").html(
                        '<div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                        <div class="d-flex align-items-center">\
                        <div class="prompt-img">\
                        <i class="mdi mdi-check"></i>\
                        </div>\
                        <div class="prompt-text ms-3">\
                        ' +
                            response.message +
                            '\
                        </div>\
                        </div>\
                        <div class="prompt-img prompt-closes">\
                        <i class="mdi mdi-close"></i>\
                        </div>\
                        </div>'
                    );

                    first_name.val("");
                    last_name.val("");
                    birth_date.attr("type", "text");
                    birth_date.val("");
                    contact_number.val("");
                    $("#email_address").val("");
                    password1.val("");
                    password2.val("");
                    referral_code.val("");

                    setTimeout(() => {
                        window.location = response.redirecToUrl;
                    }, 4000);
                } else {
                    $(".promptss-v2").html(
                        '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                            response.message +
                            '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                    );
                    if (response.redirecToUrl) {
                        setTimeout(() => {
                            window.location = response.redirecToUrl;
                        }, 4000);
                    }
                }
            },
            complete: function () {
                $("#submit_account").html("SIGN UP");
            },
        });
    });

    /* LOGIN */
    $(document).on("click", "#submit_logincred", function (e) {
        var thisBtn = $(this);

        e.preventDefault();
        thisBtn.prop("disabled", true);

        var uid = $("#unique_id");
        var pass = $("#password");

        var fd = new FormData();
        fd.append("unique_id", uid.val());
        fd.append("password", pass.val());

        $.ajax({
            type: "POST",
            url: window.thisUrl + "/user_loginvalidation",
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                switch (response.status) {
                    case "key_error":
                        $(".promptss-v2").html(
                            '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                response.message +
                                '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                        );

                        break;

                    case "validate_error":
                        $(".promptss-v2").html(
                            '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                response.message +
                                '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                        );

                        break;

                    case "incorrect_cred":
                        $(".promptss-v2").html(
                            '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                response.message +
                                '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                        );

                        break;

                    case "user_is_onlineeee":
                        window.location = response.message;

                        break;

                    default:
                        break;
                }
                thisBtn.prop("disabled", false);
            },
        });
    });

    $(document).on("keyup", function (e) {
        if (e.key === "Enter" || e.code === 13) {
            var uid = $("#unique_id");
            var pass = $("#password");

            if (uid.val().length < 1 || pass.val().length < 1) return false;

            var thisBtn = $(this);

            e.preventDefault();
            thisBtn.prop("disabled", true);

            var fd = new FormData();
            fd.append("unique_id", uid.val());
            fd.append("password", pass.val());

            $.ajax({
                type: "POST",
                url: window.thisUrl + "/user_loginvalidation",
                data: fd,
                processData: false,
                contentType: false,
                enctype: "application/x-www-form-urlencoded",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    switch (response.status) {
                        case "key_error":
                            $(".promptss-v2").html(
                                '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                    response.message +
                                    '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                            );

                            break;

                        case "validate_error":
                            $(".promptss-v2").html(
                                '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                    response.message +
                                    '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                            );

                            break;

                        case "incorrect_cred":
                            $(".promptss-v2").html(
                                '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                                    response.message +
                                    '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                            );

                            break;

                        case "user_is_onlineeee":
                            window.location = response.message;

                            break;

                        default:
                            break;
                    }
                    thisBtn.prop("disabled", false);
                },
            });
        }
        return false;
    });
    /* BUTTON VERIFY EMAIL ADDRESS */
    $("#verify_emailAddress").on("click", function (e) {
        e.preventDefault();

        var email_address = $("#email_address");
        var timez = moment.tz.guess();
        $.ajax({
            type: "POST",
            url: "/ajax/verify-email-address",
            data: {
                email_address: email_address.val(),
                timez: timez,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $("#verify_emailAddress").html(
                    '<i class="mdi mdi-loading mdi-spin"></i>'
                );
            },
            success: function (response) {
                if (response.status == "mail_sent_to_email") {
                    $(".promptss-v2").html(
                        '<div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-check"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                            response.message +
                            '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                    );
                } else {
                    $(".promptss-v2").html(
                        '<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                    <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                    <i class="mdi mdi-alert"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                    ' +
                            response.message +
                            '\
                    </div>\
                    </div>\
                    <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                    </div>\
                    </div>'
                    );
                }
            },
            complete: function () {
                $("#verify_emailAddress").html("Create");
            },
        });
    });
    /*
        LINK GOOGLE ACCOUNT TO IAGD ACCOUNT
    */
    $("#linkMyGaccount").on("click", function () {
        var linkmyAccount = "linkmyaccount";
        var timez = moment.tz.guess();
        $.ajax({
            type: "POST",
            url: "/ajax/linkmyAccount",
            data: {
                linkmyAccount: linkmyAccount,
                timez: timez,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == "success") {
                    window.location = response.redirectUrl;
                } else {
                    window.location = response.redirectUrl;
                }
            },
        });
    });
    /* REFERRAL CODE HANDLER */
    function handle_referral_code() {
        let url_params = new URLSearchParams(window.location.search);

        if (url_params.has("ref")) {
            localStorage.setItem("ref", url_params.get("ref"));
        }

        let stored_referral_code = localStorage.getItem("ref");
        if (stored_referral_code !== null) {
            // Check if the referral input exists in the page
            if ($('input[name="referral_code"]').length) {
                $('input[name="referral_code"]').val(stored_referral_code);
            }
        }
    }

    handle_referral_code();
});
