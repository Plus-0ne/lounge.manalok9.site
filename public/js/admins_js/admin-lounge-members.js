$(function () {
    /* -------------------------------------------------------------------------- */
    /*                                Set variables                               */
    /* -------------------------------------------------------------------------- */
    let user_uuid = null;
    let currentReferralIagdNumber = null;
    /* -------------------------------------------------------------------------- */
    /*                         Show modal update referral                         */
    /* -------------------------------------------------------------------------- */
    $('.showModalUpdateReferral').on('click', function () {
        const thisBtn = $(this);

        $('#updateReferralsModal').modal('toggle');
        user_uuid = thisBtn.attr('data-uuid');
        currentReferralIagdNumber = thisBtn.attr('data-referredBy');

        $('#iagdReferralNumber').val(currentReferralIagdNumber);
    });
    /* -------------------------------------------------------------------------- */
    /*                          On update referral click                          */
    /* -------------------------------------------------------------------------- */
    $('#updateReferralSubmit').on('click', function (e) {
        /*
            * Disable the button
        */
        const thisBtn = $(this);
        thisBtn.attr('disabled', true);
        e.preventDefault();

        /*
            * Create form data
        */
        const fd = new FormData();

        fd.append('uuid', user_uuid);
        fd.append('referred_by', $('#iagdReferralNumber').val());

        /*
            * AJAX post setup
        */
        $.ajax({
            type: 'POST',
            url: window.currentBaseUrl + '/admin/Lounge_Members/referral/update',
            data: fd,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                /*
                    * Handle the response from the server here
                */
                const res = response;
                if (res.status == 'success') {
                    window.location.reload();
                    return;
                }
                formPromptTemplate(res);
            },
            complete: function () {

                /*
                    * Re-enable the button if there was an error
                */
                thisBtn.removeAttr('disabled');
            },
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                              Form promot fill                              */
    /* -------------------------------------------------------------------------- */
    function formPromptTemplate(res) {

        let containerStatus = null;
        let iconStatus = null;
        let alertText = res.message;

        const fp = $('#form-prompt');
        fp.html("");
        switch (res.status) {
            case 'success':
                containerStatus = 'alert-success';
                iconStatus = 'mdi-check-circle';
                break;
                case 'warning':
                containerStatus = 'alert-warning';
                iconStatus = 'mdi-alert';
                break;
            default:
                containerStatus = 'alert-danger';
                iconStatus = 'mdi-alert-circle';
                break;
        }
        fp.append(
            $('<div>',{
                class: 'alert '+containerStatus+' d-flex align-items-center'
            }).append(
                $('<div>',{
                    class: 'me-2 icon-alert-xl'
                }).append(
                    $('<span>',{
                        class : 'mdi '+iconStatus
                    })
                )
            ).append(
                $('<div>',{
                    text : alertText
                })
            )
        );

        setTimeout(() => {
            fp.html("");
        }, 6000);
    }
});
