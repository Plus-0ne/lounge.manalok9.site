$(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.pet-delete').on('click', function () {
        var rid = $(this).attr('data-id');

        $('#delete_pet_btn').attr('data-id', rid);

        $('#delete_this_pet').modal('toggle');

    });
    $(document).on('click', '#delete_pet_btn', function () {

        var rid = $(this).attr('data-id');

        $.ajax({
            type: "post",
            url: "delete_this_pet_record",
            data: { rid: rid },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('.delete_pet_btnnn').html('<i class="mdi mdi-loading mdi-spin"></i> Removing');
            },
            success: function (response) {
                switch (response.status) {
                    case 'key_error':
                        toastr["warning"](response.msg);
                        break;


                    case 'error':
                        toastr["error"](response.msg);
                        break;

                    case 'success':
                        toastr["success"](response.msg);
                        break;

                    case 'error_deleting':
                        toastr["success"](response.msg);

                    default:
                        toastr["warning"]('Something\'s wrong! Please try agaim');
                    break;
                }

                $('.delete_pet_btnnn').html('<i class="mdi mdi-check"></i> Yes');
            },
            error: function(xhr) {
                console.log(xhr.statusText + xhr.responseText);
                $('.delete_pet_btnnn').html('<i class="mdi mdi-check"></i> Yes');
            },
            complete: function() {
                $('.delete_pet_btnnn').html('<i class="mdi mdi-check"></i> Yes');
                setTimeout(function () {
                            location.reload();
                        }, 2000);
            },
        });
    });
});
