$(document).ready(function () {

    /* Limit contact number input accept only numbers and digit should not exceed 11 */
    $('#inp_contact_number').keypress(function(e) {
        if ($(this).val().length > 10) {
            e.preventDefault();
        }
        var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
        if (verified) {e.preventDefault();}
    });

    /* Submit new registration */
    $('#register_newMember').on('click', function (e) {
        e.preventDefault();

        var inp_first_name = $('#inp_first_name');
        var inp_last_name = $('#inp_last_name');
        var inp_middle_initial = $('#inp_middle_initial');
        var inp_email_address = $('#inp_email_address');
        var inp_contact_number = $('#inp_contact_number');
        var inp_address = $('#inp_address');
        var inp_ship_address = $('#inp_ship_address');
        var inp_near_lblc = $('#inp_near_lblc');
        var inp_name_card = $('#inp_name_card');
        var inp_fb_url = $('#inp_fb_url');

        var membership_package = $('#inp_membership_package');
        var referral_code = $('#inp_referral_code');

        var inp_valid_id = $('#inp_valid_id')[0];
        var inp_clear_11image = $('#inp_clear_11image')[0];
        var inp_payment_proof = $('#inp_payment_proof')[0];

        var formData = new FormData();

        formData.append('first_name',inp_first_name.val());
        formData.append('last_name',inp_last_name.val());
        formData.append('middle_initial',inp_middle_initial.val());
        formData.append('email_address',inp_email_address.val());
        formData.append('contact_number',inp_contact_number.val());
        formData.append('address',inp_address.val());
        formData.append('ship_address',inp_ship_address.val());
        formData.append('near_lblc',inp_near_lblc.val());
        formData.append('name_card',inp_name_card.val());
        formData.append('fb_url',inp_fb_url.val());
        formData.append('referral_code',referral_code.val());
        formData.append('membership_package',membership_package.val());

        /* Count total valid id selected and create post request for each valid ids */
        let totaValidIDs = inp_valid_id.files.length;
        let valid_id = inp_valid_id;
        for (let i = 0; i < totaValidIDs; i++) {
            formData.append('valid_id[]', valid_id.files[i]);
        }
        formData.append('totaValidIDs', totaValidIDs);

        /* Count total valid id selected and create post request for each valid ids */
        let totalClear_11image = inp_clear_11image.files.length;
        let clear_11image = inp_clear_11image;
        for (let i = 0; i < totalClear_11image; i++) {
            formData.append('clear_11image[]', clear_11image.files[i]);
        }
        formData.append('totalClear_11image', totalClear_11image);

        /* Count total valid id selected and create post request for each valid ids */
        let totalpayment_proof = inp_payment_proof.files.length;
        let payment_proof = inp_payment_proof;
        for (let i = 0; i < totalpayment_proof; i++) {
            formData.append('payment_proof[]', payment_proof.files[i]);
        }
        formData.append('totalpayment_proof', totalpayment_proof);



        $.ajax({
            type: "post",
            url: "/ajax/register_as_a_member",
            data: formData,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                switch (res.status) {
                    case 'error':
                    $('.reg_prompts').html('<p class="text-danger"> <i class="mdi mdi-alert"></i> '+res.message+'</p>');
                    break;

                    case 'info':
                    $('.reg_prompts').html('<p class="text-info"> <i class="mdi mdi-information"></i> '+res.message+'</p>');
                    break;

                    case 'warning':
                    $('.reg_prompts').html('<p class="text-warning"> <i class="mdi mdi-alert-circle"></i> '+res.message+'</p>');
                    break;

                    case 'success':
                    $('.reg_prompts').html('<p class="text-success"> <i class="mdi mdi-check-circle"></i> '+res.message+'</p>');
                    break;

                    default:
                    break;
                }
                // console.log(response);
            }
        });
    });

    /* PACKAGE INFO */
    let package_info = '';
    $('#inp_membership_package').on('change', function() {
        switch ($(this).val()) {
            case '0':
                package_info = '\
                <ol class="mt-2">\
                    <li> 3-year Premium Membership</li>\
                    <li> 1 Free Animal Registration with Pedigree Certificate</li>\
                </ol>';
                break;
            case '1':
                package_info = '\
                <ol class="mt-2">\
                    <li> 5-year Premium Membership</li>\
                    <li> 1 Free Animal Registration with a Pedigree Certificate</li>\
                    <li> 1 Free Animal Facility Registration (5 years)</li>\
                </ol>';
                break;
            case '2':
                package_info = '\
                <ol class="mt-2">\
                    <li> 10-year Premium Membership</li>\
                    <li> 1 Free Animal Registration with a Pedigree Certificate</li>\
                    <li> 1 Free Animal Facility Registration with Certificate (10 years)</li>\
                </ol>';
                break;
            default:
                package_info = 'Select a package to know more about it\'s contents.';
                break;
        }
        $('#helpId-package').html(package_info);
    });

});
