$(document).ready(function () {

    /* GET TIMEZONE */
    var timez = moment.tz.guess();

    $('#timezzz').val(timez);

    /* CLOSE PROMPT */
    $(document).on('click','.prompt-closes', function () {
        $(this).parent().addClass('animate__flipOutX');

        setTimeout(() => {
            $(this).parent().remove();
        }, 500);

    });

    $('#backBtn_reg').on('click', function () {
        window.location.href = backUrl;
    });

    $('#reset_pass_word').on('click', function (e) {

        e.preventDefault();

        var email_address = $('#email_address');

        $.ajax({
            type: "POST",
            url: "/check_email_address",
            data: {
                'email_address': email_address.val(),
                'timez' : timez
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#reset_pass_word').html('<i class="mdi mdi-loading mdi-spin"></i>');
            },
            success: function (response) {

                if (response.status == 'mail_sent') {
                    $('.promptss-v2').html('<div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                                <div class="d-flex align-items-center">\
                                    <div class="prompt-img">\
                                        <i class="mdi mdi-check"></i>\
                                    </div>\
                                    <div class="prompt-text ms-3">\
                                        '+response.message+'\
                                    </div>\
                                </div>\
                                <div class="prompt-img prompt-closes">\
                                    <i class="mdi mdi-close"></i>\
                                </div>\
                            </div>');
                }
                else
                {
                    $('.promptss-v2').html('<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                                <div class="d-flex align-items-center">\
                                    <div class="prompt-img">\
                                        <i class="mdi mdi-alert"></i>\
                                    </div>\
                                    <div class="prompt-text ms-3">\
                                        '+response.message+'\
                                    </div>\
                                </div>\
                                <div class="prompt-img prompt-closes">\
                                    <i class="mdi mdi-close"></i>\
                                </div>\
                            </div>');
                }
            },
            complete: function () {
                $('#reset_pass_word').html('RESET PASSWORD');
            }
        });
    });

    $('#resend_mail').on('click', function () {
        $.ajax({
            type: "get",
            url: "/resend_mail_passreset",
            beforeSend: function () {
                $('#resend_mail').html('<i class="mdi mdi-loading mdi-spin"></i> Sending');
            },
            success: function (response) {
                var res = response;

                switch (res.status) {
                    case 'email_resent':
                        $('.page_prompts').html('<p class="text-success"><i class="mdi mdi-check-circle"></i> '+res.message+'</p>');

                        break;
                    case 'time_less_than_180_sec':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');

                        break;

                    default:
                        break;
                }

            },
            complete: function () {
                $('#resend_mail').html('<i class="mdi mdi-check"></i> Resend');
            }
        });
    });



    $('#submit_changepassword').on('click', function () {
        var pass1 = $('#pass1');
        var pass2 = $('#pass2');

        $.ajax({
            type: "post",
            url: "/update_new_password",
            data: {
                'pass1': pass1.val(),
                'pass2': pass2.val(),
                'timez':timez
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#submit_changepassword').html('<i class="mdi mdi-loading mdi-spin"></i> Changing');
            },
            success: function (response) {
                var res = response;

                switch (res.status) {
                    case 'key_not_set':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'required_pass':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'invalid_pass_change':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'not_verified':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'request_null':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'page_expired':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'pass_not_matched':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'password_reset':
                        $('.page_prompts').html('<p class="text-success"><i class="mdi mdi-check-circle"></i> ' + res.message + '</p>');

                        setTimeout(() => {
                            window.location.replace(res.redirectTo);
                        }, 3000);

                        break;

                    case 'failed_to_reset':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    case 'user_not_found':
                        $('.page_prompts').html('<p class="text-warning"><i class="mdi mdi-alert"></i> ' + res.message + '</p>');
                        break;

                    default:
                        break;
                }

                pass1.val('');
                pass2.val('');
                console.log(res);
            },
            complete: function () {
                $('#submit_changepassword').html('<i class="mdi mdi-check"></i> Change');
            }
        });
    });
});
