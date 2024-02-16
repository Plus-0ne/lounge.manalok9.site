$(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Global variables                              */
    /* -------------------------------------------------------------------------- */
    let insurance_uuid = window.insuranceUuid;

    $('#availThisInsurance').on('click', function (e) {
        /*
            * Disable the button on click to avoid multiple click
        */
        const thisBtn = $(this);
        e.preventDefault();
        thisBtn.attr('disabled', true);

        /*
            * Set request values
        */
        const fd = new FormData();
        fd.append('insuranceUuid',insurance_uuid);
        $.ajax({
            method: "post",
            url: window.currentBaseUrl + '/user/insurance/avail',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                thisBtn.html('<span class="mdi mdi-loading mdi-spin"></span> Processing');
            },
            success: function (response) {
                const res = response;

                toastr[res.status](res.message);

                // if (res.status == 'success') {
                //     window.location = window.currentBaseUrl+ '/user/insurance';
                // }
            },
            complete: function (result) {
                const res = result.responseJSON;

                if (res.status != 'success') {
                    thisBtn.attr('disabled', false);
                    thisBtn.html('<span class="mdi mdi-card-plus-outline"></span> Avail now');
                    return;
                }

                thisBtn.html('<span class="mdi mdi-card-plus-outline"></span> Availed');
                thisBtn.removeClass('btn-success');
                thisBtn.addClass('btn-secondary');

            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                            On click view details                           */
    /* -------------------------------------------------------------------------- */
    $('.viewInsuranceDetails').on('click', function () {
        const thisBtn = $(this);
        window.location = window.currentBaseUrl + '/user/insurance/details?insuranceUuid='+thisBtn.attr('data-insurance_uuid')
    });

    /* -------------------------------------------------------------------------- */
    /*                     On click show modal insurance plans                    */
    /* -------------------------------------------------------------------------- */
    $('#showInsurancePlanAvailed').on('click', function () {
        $('#modalInsurancePlansAvailed').modal('toggle');
    });

    /* -------------------------------------------------------------------------- */
    /*                     On modalInsurancePlansAvailed show                     */
    /* -------------------------------------------------------------------------- */
    $('#modalInsurancePlansAvailed').on('show.bs.modal', function () {
        /*
            * AJAX request get insurance availed plans
        */
        $.ajax({
            type: "get",
            url: window.currentBaseUrl + '/user/insurance/availed',
            success: function (response) {
                const res = response;
                console.log(res);
                createInsurancePlansAvailedContent(res);
            }
        });
    });

    /*
        * Create availed insurance plans content
    */
    function createInsurancePlansAvailedContent(res) {
        /*
            * Create variables
        */
        const content = $('#insuranceAvailedContent');

        /*
            * Check if insurancePlans data is valid
        */
        if (res.insurancePlans === undefined || res.insurancePlans.length < 1 || res.insurancePlans == null) {
            return;
        }

        /*
            Todo : create content dynamically
        */
    }

    /* -------------------------------------------------------------------------- */
    /*                     On modalInsurancePlansAvailed hide                     */
    /* -------------------------------------------------------------------------- */
    $('#modalInsurancePlansAvailed').on('hide.bs.modal', function () {
        /*
            * Create variables
        */
        const content = $('#insuranceAvailedContent');
        // content.html("");
    });
});
