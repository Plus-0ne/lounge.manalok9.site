$(document).ready(function() {
    /* -------------------------------------------------------------------------- */
    /*                          Initialize product table                          */
    /* -------------------------------------------------------------------------- */
    $('#products').dataTable();

    /* -------------------------------------------------------------------------- */
    /*                           Show add product modal                           */
    /* -------------------------------------------------------------------------- */
    $('#addNewProduct').on('click', function () {
        $('#addNewProductModal').modal('toggle');
    });

    /* -------------------------------------------------------------------------- */
    /*                                Accept order                                */
    /* -------------------------------------------------------------------------- */
    $('.acceptOrder').on('click', function (e) {
        /*
            * Set variables
        */
        const thisBtn = $(this);
        const uuid = thisBtn.attr('data-uuid');
        const fd = new FormData();
        /*
            * Disabled the button
        */
        thisBtn.attr('disabled',true);
        e.preventDefault();

        /*
            * Append values to form data
        */
        fd.append('uuid',uuid);
        /*
            * Prompt confirmation
        */
        if (!confirm('Do you want to fulfill this order ?')) {
            thisBtn.attr('disabled',false);
            return;
        }
        /*
            * Ajax post
        */
        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/admin/products/accept',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;
                alert(res.message);
                window.location.reload();
            },
            complete: function () {
                thisBtn.attr('disabled',false);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                                Cancel order                                */
    /* -------------------------------------------------------------------------- */
    $('.cancelOrder').on('click', function (e) {
        /*
            * Set variables
        */
        const thisBtn = $(this);
        const uuid = thisBtn.attr('data-uuid');
        const fd = new FormData();
        /*
            * Disabled the button
        */
        thisBtn.attr('disabled',true);
        e.preventDefault();

        /*
            * Append values to form data
        */
        fd.append('uuid',uuid);
        /*
            * Prompt confirmation
        */
        if (!confirm('Do you want to cancel this order ?')) {
            thisBtn.attr('disabled',false);
            return;
        }
        /*
            * Ajax post
        */
        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/admin/products/cancel',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;
                alert(res.message);
                window.location.reload();
            },
            complete: function () {
                thisBtn.attr('disabled',false);
            }
        });
    });
});
