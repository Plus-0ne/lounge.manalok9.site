$(document).ready(function () {
    $('#accounts_table').dataTable();
    /* -------------------------------------------------------------------------- */
    /*                            Delete admin account                            */
    /* -------------------------------------------------------------------------- */
    $('#rowActionbtn').on('click', function () {
        /* Get admin id */
        let id = $(this).attr('data-id');

        const fd = new FormData();

        fd.append('id',id);

        /* Ajax post */
        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/admin/accounts/delete',
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            data: fd,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                /* Get response */
                const res = response;

                console.log(res);

            }
        });
    });
});
