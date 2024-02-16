$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Initialize table                              */
    /* -------------------------------------------------------------------------- */
    $('#tableTrainTickets').dataTable();
    /* -------------------------------------------------------------------------- */
    /*                            On close_ticket click                           */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.close_ticket', function () {

        /* Variables */
        const uuid = $(this).attr('data-uuid');
        const fd = new FormData();

        /* Confirm action */
        if (confirm('Do you want to close this ticket?') == false) {
            return false;
        }

        fd.append('uuid',uuid);
        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/admin/training/tickets/close',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;
                switch (res.status) {
                    case 'error':
                    toastr.error(res.message);
                        break;

                        case 'warning':
                    toastr.warning(res.message);
                        break;

                        case 'success':
                    toastr.success(res.message);
                    location.reload();
                        break;

                    default:
                        break;
                }
            }
        });
    });


});
