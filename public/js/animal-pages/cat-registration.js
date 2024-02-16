$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Global variables                              */
    /* -------------------------------------------------------------------------- */
    const animalType = 'cat';

    /* -------------------------------------------------------------------------- */
    /*                  Custom response text to prompt container                  */
    /* -------------------------------------------------------------------------- */
    function promptResStatus(res) {
        const container = $('#reg-prompt-container');

        /* If res is undefined or null return false */
        if (res.status == undefined || res.status.length < 1 || res.status == null) {
            return false;
        }
        /* Switch status for status response */
        switch (res.status) {
            case "error":
                container.html(
                    $('<div>', {
                        class: 'text-danger'
                    }).append(
                        $('<span>', {
                            class: 'mdi mdi-close-thick me-2'
                        })
                    ).append(res.message)
                );
                break;

            case "warning":
                container.html(
                    $('<div>', {
                        class: 'text-danger'
                    }).append(
                        $('<span>', {
                            class: 'mdi mdi-alert me-2'
                        })
                    ).append(res.message)
                );
                break;

            case "success":
                container.html(
                    $('<div>', {
                        class: 'text-success'
                    }).append(
                        $('<span>', {
                            class: 'mdi mdi-check-bold me-2'
                        })
                    ).append(res.message)
                );
                break;

            default:
                container.html("");
                break;
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                          Numeric value validation                          */
    /* -------------------------------------------------------------------------- */
    $(document).on('keypress', '#age,#height,#weight', function (e) {


        let inputText = $(this)
        checkifNumberIsValid(e, inputText);
    });

    function checkifNumberIsValid(e, inputText) {

        const code = (e.key) ? e.key : e.code;
        const keyArr = ['+', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];

        if ($.inArray(code, keyArr) !== -1) {
            return true;
        } else {
            e.preventDefault();

            return false;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                   Only paste number and allowed charactes                  */
    /* -------------------------------------------------------------------------- */
    $(document).on('paste forcePaste', '#age,#height,#weight', function (e) {
        const thisInput = $(this);
        checkIfValidChar(thisInput, e);
    });

    /* -------------------------------------------------------------------------- */
    /*                  Check if char is not allowed using paste                  */
    /* -------------------------------------------------------------------------- */
    function checkIfValidChar(thisInput, e) {
        const keyArr = ['+', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];
        const evt = e;

        let pastedData = null;

        catchPaste(evt, this, function (clipData) {
            pastedData = clipData.split("");

            $.each(pastedData, function (pastedDataI, pastedDataVal) {
                if ($.inArray(pastedDataVal, keyArr) != -1) {
                    return true;
                } else {
                    e.preventDefault();
                    thisInput.val("");
                    return false;
                }
            });

        });
    }

    /* -------------------------------------------------------------------------- */
    /*                              Catch paste data                              */
    /* -------------------------------------------------------------------------- */
    function catchPaste(evt, elem, callback) {
        if (navigator.clipboard && navigator.clipboard.readText) {
            /* modern approach with Clipboard API */
            navigator.clipboard.readText().then(callback);
        } else if (evt.originalEvent && evt.originalEvent.clipboardData) {
            /* OriginalEvent is a property from jQuery, normalizing the event object */
            callback(evt.originalEvent.clipboardData.getData('text'));
        } else if (evt.clipboardData) {
            /* used in some browsers for clipboardData */
            callback(evt.clipboardData.getData('text/plain'));
        } else if (window.clipboardData) {
            /* Older clipboardData version for Internet Explorer only */
            callback(window.clipboardData.getData('Text'));
        } else {
            /* Last resort fallback, using a timer */
            setTimeout(function () {
                callback(elem.value)
            }, 100);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                              Clear all inputs                              */
    /* -------------------------------------------------------------------------- */
    function clearAllInputs() {
        const name = $('#name');
        const microchip = $('#microchip');
        const birth_date = $('#birth_date');
        const age = $('#age');
        const gender = $('#gender');
        const breed = $('#breed');
        const eye_color = $('#eye_color');
        const dog_color = $('#dog_color');
        const dogs_marking = $('#dogs_marking');
        const height = $('#height');
        const weight = $('#weight');
        const address_location = $('#address_location');
        const co_owner = $('#co_owner');
        const pet_image = $('#pet_image');
        const supp_doc = $('#supp_doc');

        const cveterenary_name = $('#eye_color');
        const cveterenary_url = $('#eye_color');
        const cveter_record = $('#cveter_record');


        const kennel_name = $('#kennel_name');
        const kennel_link = $('#kennel_link');

        const breeder_name = $('#breeder_name');
        const breeder_link = $('#breeder_link');

        const sire_name = $('#sire_name');
        const sire_breed = $('#sire_breed');
        const sire_iagd_num = $('#sire_iagd_num');
        const sire_image = $('#sire_image');
        const sire_supp_doc = $('#sire_supp_doc');

        const dam_name = $('#dam_name');
        const dam_breed = $('#dam_breed');
        const dam_iagd_num = $('#dam_iagd_num');
        const dam_image = $('#dam_image');
        const dam_supp_doc = $('#dam_supp_doc');


        name.val("");
        microchip.val("");
        birth_date.val("");
        age.val("");
        gender.val("");
        breed.val("");
        eye_color.val("");
        dog_color.val("");
        dogs_marking.val("");
        height.val("");
        weight.val("");
        address_location.val("");
        co_owner.val("");
        pet_image.val("");
        supp_doc.val("");

        cveterenary_name.val("");
        cveterenary_url.val("");
        cveter_record.val("");


        kennel_name.val("");
        kennel_link.val("");
        breeder_name.val("");
        breeder_link.val("");
        sire_name.val("");
        sire_breed.val("");
        sire_iagd_num.val("");
        sire_image.val("");
        sire_supp_doc.val("");
        dam_name.val("");
        dam_breed.val("");
        dam_iagd_num.val("");
        dam_image.val("");
        dam_supp_doc.val("");

    }

    /* -------------------------------------------------------------------------- */
    /*                      Fill age depends on date of birth                     */
    /* -------------------------------------------------------------------------- */
    $(document).on('change', '#birth_date', function () {
        let years = moment().diff($(this).val(), 'years');
        const age = $('#age');

        age.val(years);
    });

    /* -------------------------------------------------------------------------- */
    /*                        Manual popover for help icon                        */
    /* -------------------------------------------------------------------------- */
    $('.InputhelpIcon').popover({
        trigger: 'manual'
    });


    function showPopover(thisHelpIcon) {
        thisHelpIcon.popover('show');
    }

    // Add event listener to the button to toggle the popover on click
    $('.InputhelpIcon').on('click mouseover', function() {
        let thisHelpIcon = $(this);
        showPopover(thisHelpIcon);
    });
    $('.InputhelpIcon').on('mouseleave', function () {
        $('.InputhelpIcon').popover('hide');
    });
    $('.form-control').on('click focus', function () {
        $('.InputhelpIcon').popover('hide');
    });

    /* -------------------------------------------------------------------------- */
    /*                        Post request for registration                       */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#registerCatButton', function () {
        /*
            * New form data
        */
        const fd = new FormData();

        /*
            * Form data input values
        */
        const name = $('#name');
        const microchip = $('#microchip');
        const birth_date = $('#birth_date');
        const age = $('#age');
        const gender = $('#gender');
        const breed = $('#breed');
        const eye_color = $('#eye_color');
        const color = $('#color');
        const marking = $('#markings');
        const height = $('#height');
        const weight = $('#weight');
        const address_location = $('#address_location');
        const co_owner = $('#co_owner');
        const pet_image = $('#pet_image')[0].files[0];
        const supp_doc = $('#supp_doc')[0].files[0];
        const cveterenary_name = $('#cveterenary_name');
        const cveterenary_url = $('#cveterenary_url');
        const cveter_record = $('#cveter_record')[0].files[0];


        const kennel_name = $('#kennel_name');
        const kennel_link = $('#kennel_link');

        const breeder_name = $('#breeder_name');
        const breeder_link = $('#breeder_link');

        const sire_name = $('#sire_name');
        const sire_breed = $('#sire_breed');
        const sire_iagd_num = $('#sire_iagd_num');
        const sire_image = $('#sire_image')[0].files[0];
        const sire_supp_doc = $('#sire_supp_doc')[0].files[0];

        const dam_name = $('#dam_name');
        const dam_breed = $('#dam_breed');
        const dam_iagd_num = $('#dam_iagd_num');
        const dam_image = $('#dam_image')[0].files[0];
        const dam_supp_doc = $('#dam_supp_doc')[0].files[0];


        fd.append('animalType', animalType);
        fd.append('name', name.val());
        fd.append('microchip', microchip.val());
        fd.append('birth_date', birth_date.val());
        fd.append('age', age.val());
        fd.append('gender', gender.val());
        fd.append('breed', breed.val());
        fd.append('eye_color', eye_color.val());
        fd.append('color', color.val());
        fd.append('marking', marking.val());
        fd.append('height', height.val());
        fd.append('weight', weight.val());
        fd.append('address_location', address_location.val());
        fd.append('co_owner', co_owner.val());
        fd.append('pet_image', pet_image);
        fd.append('supp_doc', supp_doc);


        fd.append('cveter_name', cveterenary_name.val());
        fd.append('cveter_url', cveterenary_url.val());
        fd.append('cveter_record', cveter_record);

        fd.append('kennel_name', kennel_name.val());
        fd.append('kennel_link', kennel_link.val());

        fd.append('breeder_name', breeder_name.val());
        fd.append('breeder_link', breeder_link.val());

        fd.append('sire_name', sire_name.val());
        fd.append('sire_breed', sire_breed.val());
        fd.append('sire_iagd_num', sire_iagd_num.val());
        fd.append('sire_image', sire_image);
        fd.append('sire_supp_doc', sire_supp_doc);

        fd.append('dam_name', dam_name.val());
        fd.append('dam_breed', dam_breed.val());
        fd.append('dam_iagd_num', dam_iagd_num.val());
        fd.append('dam_image', dam_image);
        fd.append('dam_supp_doc', dam_supp_doc);



        /* Disable button */
        const thisBtn = $(this);
        thisBtn.attr('disabled', true);

        $.ajax({
            method: "POST",
            url: window.currentBaseUrl + "/user/pet/register",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                /* Before request is send */
                const container = $('#reg-prompt-container');
                container.html("");
            },
            success: function (response) {
                /* Handle response */
                const res = response;
                console.log(res);

                promptResStatus(res);

                if (res.status == 'success') {

                    /* Enable the button */
                    thisBtn.attr('disabled', false);

                    clearAllInputs();

                }
            },
            complete: function () {
                /* After request is sent */
                thisBtn.attr('disabled', false);
            }
        });
    });
});
