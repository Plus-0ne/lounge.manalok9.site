$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                                  Variables                                 */
    /* -------------------------------------------------------------------------- */
    const animalUuid = window.pet_uuid;
    /* -------------------------------------------------------------------------- */
    /*                      Create new certification request                      */
    /* -------------------------------------------------------------------------- */
    $('#submitNewRequestCert').on('click', function (e) {

        const withCertificateHolder = $('#withCertificateHolder');
        const certificateOnly = $("#certificateOnly");
        const fb_account = $('#fb_account');
        const animal_type = window.AnimalType;
        const thisBtn = $(this);
        const fd = new FormData();



        fd.append('animalUuid', animalUuid);
        fd.append('withCertificateHolder', (withCertificateHolder.prop('checked')) ? 1 : 0);
        fd.append('certificateOnly', (certificateOnly.prop('checked')) ? 1 : 0);


        fd.append('fb_account', fb_account.val());
        fd.append('animal_type',animal_type);

        thisBtn.attr('disabled',true);

        $.ajax({
            type: "post",
            url: window.thisUrl + '/user/certificate/request/create',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;
                console.log(res);
                if (res.status == 'success') {
                    setTimeout(() => {

                        window.location = window.previousUrl;
                        thisBtn.attr('disabled',false);
                    }, 5000);
                }
                toastr[res.status](res.message);
            },
            complete: function () {
                thisBtn.attr('disabled',false);
            }
        });
    });

});
