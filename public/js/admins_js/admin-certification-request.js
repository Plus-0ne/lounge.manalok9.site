$(function () {
    /* -------------------------------------------------------------------------- */
    /*                               Find the table                               */
    /* -------------------------------------------------------------------------- */
    if ($('#tablecert').length > 0) {
        $('#tablecert').dataTable();
    }

    /* -------------------------------------------------------------------------- */
    /*                      Fix dropdown not responsive table                     */
    /* -------------------------------------------------------------------------- */
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "inherit");
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "auto");
    });
    /* -------------------------------------------------------------------------- */
    /*                  Show certification request modal details                  */
    /* -------------------------------------------------------------------------- */
    $('.certActionView').on('click', function () {
        $('#modalCertificationRequestDetails').modal('toggle');
    });

    /* -------------------------------------------------------------------------- */
    /*                        Reject certificate request                          */
    /* -------------------------------------------------------------------------- */
    $('.certActionReject').on('click', function () {
        /*
            Todo : Reject function for certification request
        */
        alert($(this).attr('data-uuid'));
    });
})
