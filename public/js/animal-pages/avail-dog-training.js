$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Assistance submit                             */
    /* -------------------------------------------------------------------------- */
    $('#avail_dog_registration').on('click', function (e) {


        const updated_contact = $('#updated_contact');
        const facebook_link = $('#facebook_link');
        const fd = new FormData();
        const thisBtn = $(this);

        fd.append('updated_contact', updated_contact.val());
        fd.append('facebook_link', facebook_link.val());

        thisBtn.attr('disabled', true);

        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/user/training/assitance/create',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                const res = response;
                const psection = $('#prompt_sections');
                psection.html("");

                switch (res.status) {
                    case 'error':
                        psection.append(
                            $('<span>', {
                                class: 'text-danger',
                                text: res.message
                            })
                        );
                        break;

                    case 'warning':
                        psection.append(
                            $('<span>', {
                                class: 'text-warning',
                                text: res.message
                            })
                        );
                        break;

                    case 'success':
                        psection.append(
                            $('<span>', {
                                class: 'text-success',
                                text: res.message
                            })
                        );
                        break;
                    default:
                        break;
                }
                psection.append(
                    $('<span>',)
                );

            }, complete: function () {
                thisBtn.attr('disabled', false);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                          On contact number change                          */
    /* -------------------------------------------------------------------------- */
    $('#updated_contact').val("");
    $(document).on('keypress', '#updated_contact', function (e) {

        const code = (e.key) ? e.key : e.code;
        const keyArr = ['+', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];

        $('#updated_contacthelpText').html("");

        if ($.inArray(code, keyArr) !== -1) {
            console.log(code);
        } else {
            e.preventDefault();
            $('#updated_contacthelpText').append($('<small>',{
                class : 'text-danger',
                text : 'The text you entered is not allowed. ' +'"'+ code+'"'
            }));
        }

    });

    /* -------------------------------------------------------------------------- */
    /*                   Disable paste in contanct number input                   */
    /* -------------------------------------------------------------------------- */
    $(document).on('paste forcePaste', '#updated_contact', function (e) {
        const keyArr = ['+', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];
        const evt = e;

        let pastedData = null;

        catchPaste(evt, this, function (clipData) {
            pastedData = clipData.split("");

            $.each(pastedData, function (pastedDataI, pastedDataVal) {
                if($.inArray(pastedDataVal, keyArr) != -1) {

                } else {
                    e.preventDefault();
                    $('#updated_contact').val("");
                    $('#updated_contacthelpText').html("");
                    $('#updated_contacthelpText').append($('<small>',{
                        class : 'text-danger',
                        text : 'The text you have pasted includes characters that are not allowed. ' +'Not allowed "'+ pastedDataVal+'"'
                    }));
                    return false;
                }
            });

        });
    });

    /* -------------------------------------------------------------------------- */
    /*                              Catch paste data                              */
    /* -------------------------------------------------------------------------- */
    function catchPaste(evt, elem, callback) {
        if (navigator.clipboard && navigator.clipboard.readText) {
            // modern approach with Clipboard API
            navigator.clipboard.readText().then(callback);
        } else if (evt.originalEvent && evt.originalEvent.clipboardData) {
            // OriginalEvent is a property from jQuery, normalizing the event object
            callback(evt.originalEvent.clipboardData.getData('text'));
        } else if (evt.clipboardData) {
            // used in some browsers for clipboardData
            callback(evt.clipboardData.getData('text/plain'));
        } else if (window.clipboardData) {
            // Older clipboardData version for Internet Explorer only
            callback(window.clipboardData.getData('Text'));
        } else {
            // Last resort fallback, using a timer
            setTimeout(function () {
                callback(elem.value)
            }, 100);
        }
    }

});
