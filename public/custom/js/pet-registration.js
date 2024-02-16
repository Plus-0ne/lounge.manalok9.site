
function UploadReceipt(button, type, asset_path) {
    $('#upload_receipt').modal('toggle');
    $('#receipt_pet_uuid').val(button.attr('data-uuid'));
    $('#receipt_pet_type').val(type);
    $('#receipt_img').attr('src', '');

    let receipt_path = button.attr('data-receipt-path');

    if (receipt_path == null || receipt_path == '') {
        $('#receipt_img').hide();
    } else {
        $('#receipt_img').attr('src', asset_path + receipt_path);
        $('#receipt_img').show();
    }
}

// $('.image_btn').on('click', function (e) {
//     $(this).siblings('.image_input').trigger('click');
//     $(this).siblings('.image_input').removeClass('d-none');
//     $(this).siblings('.image_preview').removeClass('d-none');
// });
$('.image_input').on('change', function (e) {
    var img = this.files[0];
    if (img) {
        $(this).siblings('.image_preview').attr('src', URL.createObjectURL(img));
        $(this).siblings('.image_preview').removeClass('d-none');
    } else {
        $(this).siblings('.image_preview').addClass('d-none');
    }
});

// $('.file_btn').on('click', function (e) {
//     $(this).siblings('.file_input').trigger('click');
//     $(this).siblings('.file_input').removeClass('d-none');
// });

$('#pet_update_form').on('submit', function(e) {
    if (!confirm('Once applied for verification, updating pet data/information is not allowed. Proceed?')) {
        e.preventDefault();
    }
});

// $('.download_file').on('click', function() {
//     $.ajax({
//         type: "POST",
//         url: "/download_file",
//         data: {
//             'uuid': $(this).data('file_uuid'),
//             'token': $('#file_token').val(),
//         },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function (response) {
//             let file_link = JSON.parse(response)[0];
//             // console.log(file_link);
//             // window.location.href = file_link;
//             window.open(file_link, '_blank').focus();
//         }
//     });
// });

$('.pet_add_form').on('submit', function(e) {
    $(this).find('button[type="submit"]').attr('disabled', '');
});


$('.cancel-registration').on('click', function(e) {
    if (!confirm('Cancel registration?')) {
        e.preventDefault();
    }
});