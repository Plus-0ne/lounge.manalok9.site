$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                           Enroll pet button event                          */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#enrollPetBtn', function (e) {
        /*
            * Declare variables
        */
        const thisBtn = $(this);
        const fd = new FormData();
        const petName = $('#petName');
        const petBreed = $('#petBreed');
        const petColor = $('#petColor');
        const petAge = $('#petAge');
        const petGender = $('#petGender');
        const petOwner = $('#petOwner');
        const currentAddress = $('#currentAddress');
        const contactNumber = $('#contactNumber');
        const mobileNumber = $('#mobileNumber');
        const emailAddress = $('#emailAddress');
        const fbAccountLink = $('#fbAccountLink');
        const personalBelongings = $('#personalBelongings');
        const textAreaDogToClass = $('#textAreaDogToClass');
        const textAreaWhatToAccomplish = $('#textAreaWhatToAccomplish');
        const textAreaWhereAboutUs = $('#textAreaWhereAboutUs');

        /*
            * Append input values to form data
        */
        fd.append('petName', petName.val());
        fd.append('petBreed', petBreed.val());
        fd.append('petColor', petColor.val());
        fd.append('petAge', petAge.val());
        fd.append('petGender', petGender.val());

        fd.append('petOwner', petOwner.val());
        fd.append('currentAddress', currentAddress.val());
        fd.append('contactNumber', contactNumber.val());
        fd.append('mobileNumber', mobileNumber.val());
        fd.append('emailAddress', emailAddress.val());
        fd.append('fbAccountLink', fbAccountLink.val());
        fd.append('personalBelongings', personalBelongings.val());

        fd.append('textAreaDogToClass', textAreaDogToClass.val());
        fd.append('textAreaWhatToAccomplish', textAreaWhatToAccomplish.val());
        fd.append('textAreaWhereAboutUs', textAreaWhereAboutUs.val());

        /*
            * Disable button
        */
        thisBtn.attr('disabled', true);
        e.preventDefault();

        /*
            * Ajax post request
        */
        $.ajax({
            method: "post",
            url: window.currentBaseUrl + '/services/enrollment/add',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {

            },
            success: function (response) {
                const res = response;
                toastrPrompt(res);
                if (res.status == 'success') {
                    setTimeout(() => {
                        window.location = window.currentBaseUrl+ '/services';
                    }, 5000);
                }
            },
            complete: function () {
                thisBtn.attr('disabled', false);
            }
        });

    });

    /* -------------------------------------------------------------------------- */
    /*                          Number only in input text                         */
    /* -------------------------------------------------------------------------- */
    $(document).on('keydown', '.numberOnlyInput', function (e) {
        // Allow: backspace, delete, tab, escape, and enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
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
    /*                       Check if mobile number is valid                      */
    /* -------------------------------------------------------------------------- */
    $(document).on('keydown', '.contactNumberValidation', function (e) {
        checkifNumberIsValid(e);
    });
    /* -------------------------------------------------------------------------- */
    /*                           Mobile number validator                          */
    /* -------------------------------------------------------------------------- */
    function checkifNumberIsValid(e) {

        const validKeys = ['+', '-', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        if ((e.ctrlKey && e.key === 'v') || validKeys.includes(e.key) || e.key === 'Backspace') {
            return true;
        }

        e.preventDefault();
        return false;
    }

    /* -------------------------------------------------------------------------- */
    /*                   Only paste number and allowed charactes                  */
    /* -------------------------------------------------------------------------- */
    $(document).on('paste forcePaste', '.contactNumberValidation', function (e) {
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
    /*                           Add required to inputs                           */
    /* -------------------------------------------------------------------------- */
    const makeThisRequired = $('.makeThisRequired');
    makeThisRequired.attr('required', true);

    /* -------------------------------------------------------------------------- */
    /*                      Get all service in cart for form                      */
    /* -------------------------------------------------------------------------- */
    function getServiceCartForEnrollment() {
        /*
            * Ajax request get
        */
        $.ajax({
            method: "get",
            url: window.currentBaseUrl + '/services/enrollment/cart',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
            },
            success: function (response) {
                const res = response;
                console.log(res);
                if (res.status == 'success') {
                    fillApplyingForSection(res);
                }
            }
        });
    }
    getServiceCartForEnrollment();

    /* -------------------------------------------------------------------------- */
    /*                     fill applying for section with data                    */
    /* -------------------------------------------------------------------------- */
    function fillApplyingForSection(res) {
        /*
            * Declare variables
        */
        const serviceApplyFor = $('#serviceApplyFor');
        // serviceApplyFor.html("");
        /*
            * Check if res.servicesOrdered is null
        */
        if (res.servicesOrdered == null) {
            return false;
        }
        /*
            * For each res.servicesOrdered
        */
        $.each(res.servicesOrdered, function (soI, soVal) {
            /*
                * Service status
            */
            let serviceStatus = null;
            // 1 = in cart ; 2 = ordering ; 3 = verified order ; 4 = packing; 5 = delivering ; 6 = received ; 7 = cancelled
            switch (soVal.status) {
                case 2:
                    serviceStatus = '<span class="badge rounded-pill bg-success">Ordered</span>';
                    break;
                case 3:
                    serviceStatus = '<span class="badge rounded-pill bg-success">Order verified</span>';
                    break;
                case 4:
                    serviceStatus = '<span class="badge rounded-pill bg-success">Packed</span>';
                    break;
                case 5:
                    serviceStatus = '<span class="badge rounded-pill bg-success">On deliver</span>';
                    break;
                case 6:
                    serviceStatus = '<span class="badge rounded-pill bg-secondary">Received</span> ';
                    break;
                case 7:
                    serviceStatus = '<span class="badge rounded-pill bg-danger">Cancelled</span>';
                    break;

                default:
                    serviceStatus = '<span class="badge rounded-pill bg-success">In cart</span>';
                    break;
            }
            /*
                * Format price
            */
            let sprice = null;
            sprice = Number(soVal.price).toLocaleString();
            /*
                * Set image
            */
            let simage = window.assetUrl + 'img/no-preview.jpeg';
            let simageAltName = 'No image';
            if (soVal.service_details !== undefined || soVal.service_details != null || soVal.service_details.image != null) {
                simage = window.assetUrl + '/' + soVal.service_details.image;
                simageAltName = soVal.service_details.name;
            }

            serviceApplyFor.append(
                $('<div>', {
                    class: 'card p-2 p-lg-3 cardCustomService'
                }).append(
                    $('<div>', {
                        class: 'd-flex flex-row align-items-center'
                    }).append(
                        $('<div>', {
                            class: 'service-image'
                        }).append(
                            $('<div>', {
                                class: 'simage-container'
                            }).append(
                                $('<img>', {
                                    class: 'img-fluid',
                                    src: simage,
                                    alt: simageAltName
                                })
                            )
                        )
                    ).append(
                        $('<div>', {
                            class: 'service-details w-100 ps-2 ps-lg-3 d-flex flex-column justify-content-center',
                        }).append(
                            $('<div>', {
                                class: 'lead',
                                text: (soVal.service_details !== undefined || soVal.service_details != null) ? soVal.service_details.name : 'Service name'
                            })
                        ).append(
                            $('<div>', {
                                text: '₱ ' + sprice
                            })
                        ).append(
                            $('<div>', {
                                html: '<small>' + serviceStatus + '</smal>'
                            })
                        )
                    ).append(
                        $('<div>', {
                            class: 'service-action-control d-flex flex-column justify-content-center'
                        }).append(
                            $('<button>', {
                                type: 'button',
                                class: 'card-service-delete'
                            }).append(
                                $('<span>', {
                                    class: 'mdi mdi-delete'
                                })
                            ).on('click', function () {
                                const fd = new FormData();
                                const id = soVal.id;
                                const thisEl = $(this);

                                fd.append('id', id);

                                $.ajax({
                                    method: "post",
                                    url: window.currentBaseUrl + '/services/enrollment/cart/remove',
                                    data: fd,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (response) {
                                        const res = response;
                                        console.log(res);

                                        toastrPrompt(res);
                                        if (res.status == 'success') {
                                            thisEl.parent().parent().parent().remove();
                                        }
                                    }
                                });
                            })
                        )
                    )
                )
            );
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                               Toastr template                              */
    /* -------------------------------------------------------------------------- */
    function toastrPrompt(res) {
        toastr[res.status](res.message);
    }

});
