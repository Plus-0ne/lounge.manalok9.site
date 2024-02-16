$(document).ready(function () {

    /* BACK TO LAST URL */
    $('#backBtn_reg').on('click', function () {
        window.location.href = backUrl;
    });

    /* CLOSE PROMPT */
    $(document).on('click','.prompt-closes', function () {
        $(this).parent().addClass('animate__flipOutX');

        setTimeout(() => {
            $(this).parent().remove();
        }, 500);

    });
    var scrollToElement = (elem) => {
        $('html, body').animate({
            scrollTop: elem.offset().top
        }, 1000);
    };
    var showAlert = (message,type,icon) => {
        $('.prompts-container').html('\
            <div class="custom-alert ca-'+ type +' d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                <div class="d-flex align-items-center">\
                    <div class="prompt-img">\
                        <i class="mdi mdi-'+ icon +'"></i>\
                    </div>\
                    <div class="prompt-text ms-3">\
                        '+ message +'\
                    </div>\
                </div>\
                <div class="prompt-img prompt-closes">\
                    <i class="mdi mdi-close"></i>\
                </div>\
            </div>');
    };


    /* CREATE ACCOUNT */
    $('#pet_registration').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($('#email_address').val()) == false && $('#email_address').val().length > 0) {
            showAlert('Please enter a valid email address.', 'warning', 'alert');
            scrollToElement($('.prompts-container'));
        } else if (typeof formData !== 'undefined') {
            $.ajax({
                type: 'POST',
                url: '/ajax/register-pet',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#submit_registration').html('SUBMITTING...');
                    showAlert('Submitting, please wait....', 'secondary', 'alert');
                },
                success: function (response) {
                    if (response.status == 'registration_success') {
                        showAlert(response.message, 'success', 'check');

                        $('.input-control').val('');

                        $('#pet_gender').val('0');

                        $('.image_input').addClass('d-none');
                        $('.image_preview').attr('src', '#').addClass('d-none');

                        $('.file_input').addClass('d-none');
                    }
                    else
                    {
                        showAlert(response.message, 'warning', 'alert');
                    }
                },
                error: function(error) {
                    showAlert('Something went wrong. Please try again later.', 'error', 'alert');
                },
                complete: function () {
                    $('#submit_registration').html('REGISTER PET');
                }
            });
            scrollToElement($('.prompts-container'));
        } else {
            showAlert('Something went wrong. Please try again later.', 'warning', 'alert');
            scrollToElement($('.prompts-container'));
        }
    });

    
    $('.image_btn').on('click', function (e) {
        $(this).siblings('.image_input').trigger('click');
        $(this).siblings('.image_input').removeClass('d-none');
        $(this).siblings('.image_preview').removeClass('d-none');
    });
    $('.image_input').on('change', function (e) {
        var img = this.files[0];
        if (img) {
            $(this).siblings('.image_preview').attr('src', URL.createObjectURL(img));
        } else {
            $(this).siblings('.image_preview').addClass('d-none');
        }
    });

    $('.file_btn').on('click', function (e) {
        $(this).siblings('.file_input').trigger('click');
        $(this).siblings('.file_input').removeClass('d-none');
    });
    // $('.file_input').on('change', function (e) {
    //     if ($(this).get(0).files.length > 2) {
    //         $(this).val(null);
    //         showAlert('Only 2 files can be uploaded.', 'warning', 'alert');
    //         scrollToElement($('.prompts-container'));
    //     }
    // });
});
