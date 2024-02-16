$(function () {
    /* -------------------------------------------------------------------------- */
    /*                            Find insurance table                            */
    /* -------------------------------------------------------------------------- */
    if ($('#insuranceTable').length > 0) {
        $('#insuranceTable').dataTable();
    }

    /* -------------------------------------------------------------------------- */
    /*                          Only number in text input                         */
    /* -------------------------------------------------------------------------- */
    $(document).on('keydown', '.numberOnlyInput', function (e) {
        // Allow: backspace, delete, tab, escape, and enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    /* -------------------------------------------------------------------------- */
    /*                        Create preview for file image                       */
    /* -------------------------------------------------------------------------- */
    $('#imageFile').on('change', function (e) {
        let file = e.target.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $('#insuranceImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(file);

            return false;
        }

        $('#insuranceImage').attr('src', window.assetUrl + '/img/no-preview.jpeg');

        return false;
    });

    /* -------------------------------------------------------------------------- */
    /*                             Input default value                            */
    /* -------------------------------------------------------------------------- */
    function inputDefaultValues() {
        $('#insuranceImage').attr('src', window.assetUrl + '/img/no-preview.jpeg');
        $('input[type="text"]').val("");
        $('input[type="file"]').val("");
        $('textarea').val("");
    }

    /* -------------------------------------------------------------------------- */
    /*                            Submit new insurance                            */
    /* -------------------------------------------------------------------------- */
    $('#submitNewInsurance').on('click', function (e) {
        /*
            * Disabled the button
        */
        const thisBtn = $(this);
        thisBtn.attr('disabled', true);
        e.preventDefault();

        /*
            * Set variables
        */
        const imageFile = $('#imageFile')[0].files[0];
        const title = $('#title');
        const price = $('#price');
        const description = $('#description');
        const notes = $('#notes');
        const coverageType = $('#coverageType');
        const coveragePeriod = $('#coveragePeriod');
        const fd = new FormData();

        /*
            * Append values to form data
        */
        fd.append('imageFile', imageFile);
        fd.append('title', title.val());
        fd.append('price', price.val());
        fd.append('description', description.val());
        fd.append('notes', notes.val());
        fd.append('coverageType', coverageType.val());
        fd.append('coveragePeriod', coveragePeriod.val());



        /*
            * Post formdata using AJAX post
        */
        $.ajax({
            method: "post",
            url: window.currentBaseUrl + '/admin/insurance/create',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;
                console.log(res);
                if (res.status == 'success') {
                    inputDefaultValues();
                    window.location.reload();
                }

                formAlertTemplate(res);
            },
            complete: function () {
                /*
                    * Reenable the button
                */
                thisBtn.attr('disabled', false);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                               alert function                               */
    /* -------------------------------------------------------------------------- */
    function promptAlert(res) {
        const promptcontainer = $('#promptcontainer');
        let statusIcon = null;

        promptcontainer.html("");

        switch (res.status) {
            case 'success':
                statusIcon = 'mdi-check'
                break;
            case 'warning':
                statusIcon = 'mdi-alert'
                break;
            default:
                statusIcon = 'mdi-close-circle'
                break;
        }
        promptcontainer.append(
            $('<div>', {
                class: 'alert alert-' + res.status + ' d-flex align-items-center',
                role: 'alert'
            }).append(
                $('<span>', {
                    class: 'mdi ' + statusIcon + ' me-3'
                })
            ).append(
                $('<div>', {
                    text: res.message
                })
            )
        );

        setTimeout(() => {
            promptcontainer.html("");
        }, 10000);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Delete insurance                              */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.deleteInsuranceOption', function (e) {
        const thisBtn = $(this);
        const uuid = thisBtn.attr('data-uuid');

        thisBtn.attr('disabled', true);
        e.preventDefault();

        if (!confirm('Do you want to delete this insurance')) {
            thisBtn.attr('disabled', false);
            return;
        }

        thisBtn.attr('disabled', false);
        window.location = window.currentBaseUrl + '/admin/insurance/delete?uuid=' + uuid

    });

    /* -------------------------------------------------------------------------- */
    /*                           Alert work in progress                           */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.wipPrompt', function () {
        alert('Work in progress!');
    });

    function formAlertTemplate(res) {
        const formPrompts = $('#formPrompts');
        let alertStatus;
        let alertIcon;

        if (res.status === undefined || res.status == null || res.status.length < 1) {
            return;
        }
        switch (res.status) {
            case 'warning':
                alertStatus = 'text-warning';
                alertIcon = 'mdi-alert-circle'
                break;

                case 'success':
                alertStatus = 'text-success';
                alertIcon = 'mdi-check-circle'
                break;

            default:
            alertStatus = 'text-danger';
            alertIcon = 'mdi-close-circle'
                break;
        }
        formPrompts.html("");

        formPrompts.append(
            $('<div>' , {
                class : 'd-flex flex-wrap align-items-center '+alertStatus
            }).append(
                $('<div>', {
                    class : 'form-wiz-alert-icon me-2'
                }).append(
                    $('<span>', {
                        class : 'mdi '+alertIcon
                    })
                )
            ).append(
                $('<small>', {
                    class : 'text-muted',
                    text : res.message
                })
            )
        );
    }
});
