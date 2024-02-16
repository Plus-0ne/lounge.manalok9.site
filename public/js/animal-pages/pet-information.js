$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                            Set global variables                            */
    /* -------------------------------------------------------------------------- */
    const petUuid = window.petUuid;
    const petName = window.petName;
    const species = window.species;
    /* -------------------------------------------------------------------------- */
    /*                     Custom collapse for pet information                    */
    /* -------------------------------------------------------------------------- */
    $('.ccolapse-pet-text').on('click', function () {
        const thisCollapseButton = $(this);
        const collapseThisEl = thisCollapseButton.parent().parent().find('.collapse');

        if (collapseThisEl.hasClass('show')) {
            thisCollapseButton.find('.mdi').removeClass('mdi-chevron-down');
            thisCollapseButton.find('.mdi').addClass('mdi-chevron-right');
        } else {

            thisCollapseButton.find('.mdi').removeClass('mdi-chevron-right');
            thisCollapseButton.find('.mdi').addClass('mdi-chevron-down');
        }
        collapseThisEl.collapse("toggle");
    });

    /* -------------------------------------------------------------------------- */
    /*                         Show pet image in full view                        */
    /* -------------------------------------------------------------------------- */
    $('.petImagePicture').on('click', function () {
        /*
            * Get image modal element
        */
        const myEl = $('#img-preview-full-pet');
        const ImageEl = $('#ipc-element');

        /*
            * Check if image element has class show
        */
        if (myEl.hasClass('show')) {
            return false;
        }

        /*
            * Show element then add animation
        */
        myEl.addClass('show');
        ImageEl.removeClass('animate__animated animate__zoomOut animate__faster');
        ImageEl.addClass('animate__animated animate__zoomIn animate__faster');

        /*
            * Set image source to this source
        */
        ImageEl.attr('src', $(this).attr('src'));


    });

    /* -------------------------------------------------------------------------- */
    /*                      Alert placeholder on development                      */
    /* -------------------------------------------------------------------------- */
    $('.onDevBtn').on('click', function () {
        alert('On development process...');
    });

    /* -------------------------------------------------------------------------- */
    /*                              Close this modal                              */
    /* -------------------------------------------------------------------------- */
    $('.img-close-preview').on('click', function () {

        /*
            * Get elements
        */
        const myEl = $('#img-preview-full-pet');
        const ImageEl = $('#ipc-element');

        /*
            * Check if modal element is shown
        */
        if (myEl.hasClass('show')) {

            /*
                * Remove animation
            */
            ImageEl.removeClass('animate__animated animate__zoomIn animate__faster');
            ImageEl.addClass('animate__animated animate__zoomOut animate__faster');

            /*
                * Timeout remove show class 500 is equal to animation out duration
            */
            setTimeout(() => {
                myEl.removeClass('show');
                ImageEl.attr('src', window.assetUrl + 'img/no_img.jpg');
            }, 500);
        }
        return false;
    });

    /* -------------------------------------------------------------------------- */
    /*                             Download image pet                             */
    /* -------------------------------------------------------------------------- */
    $("#dlPetImage").on("click", function () {
        /*
            * Get the image URL from the <img> element
        */
        const imageURL = $("#ipc-element").attr("src");

        /*
            * Set the download link's href to the image URL
        */
        $("#downloadLink").attr("href", imageURL);

        /*
            * Extract the file name from the image URL (optional, to set a custom file name)
        */
        const fileName = imageURL.substring(imageURL.lastIndexOf("/") + 1);

        /*
            * Set the download link's download attribute to the file name
        */
        $("#downloadLink").attr("download", fileName);

        /*
            * Trigger a click event on the download link to initiate the download
        */
        $("#downloadLink")[0].click();
    });

    /* -------------------------------------------------------------------------- */
    /*                   On click show delete confirmation modal                  */
    /* -------------------------------------------------------------------------- */
    $('#delPetBtn').on('click', function () {
        $('#modalPetDelete').modal('toggle');
    });

    /* -------------------------------------------------------------------------- */
    /*                           on click delete the pet                          */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','#deleteBtnPet', function (e) {
        /*
            * Set variables
        */
        e.preventDefault();
        const thisBtn = $(this);
        const fd = new FormData();
        /*
            * Set form data values
        */
        fd.append('petUuid', petUuid);
        fd.append('petName', petName);
        fd.append('species', species);
        /*
            * Disable button to eliminate user double click
        */
        thisBtn.attr('disabled',true);
        /*
            * Ajax request post
        */
        $.ajax({
            method: "POST",
            url: window.currentBaseUrl + "/user/pet/delete",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            /*
                * Before send event
            */
            beforeSend: function () {
                thisBtn.children().removeClass('mdi-trash');
                thisBtn.children().addClass('mdi-loading mdi-spin');
            },
            /*
                * Success post request event
            */
            success: function (response) {
                const res = response;


                if (res.status == 'success') {
                    window.location = window.currentBaseUrl + '/user/pet/list';
                } else {
                    console.log(res.status + ': '+res.message);
                }
            },
            /*
                * Complete post request event
            */
            complete: function () {
                thisBtn.attr('disabled',false);
                thisBtn.children().removeClass('mdi-loading mdi-spin');
                thisBtn.children().addClass('mdi-trash');
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                         On bs modal delPetBtn hide                         */
    /* -------------------------------------------------------------------------- */
    $('#modalPetDelete').on('hide.bs.modal', function () {
        $('#delPetBtn').attr('disabled',false);
    });

    /* -------------------------------------------------------------------------- */
    /*                          View other image uploads                          */
    /* -------------------------------------------------------------------------- */
    $('.otherImageUploads').on('click', function () {
        /*
            * Get image modal element
        */
        const myEl = $('#img-preview-full-pet');
        const ImageEl = $('#ipc-element');

        /*
            * Check if image element has class show
        */
        if (myEl.hasClass('show')) {
            return false;
        }

        /*
            * Show element then add animation
        */
        myEl.addClass('show');
        ImageEl.removeClass('animate__animated animate__zoomOut animate__faster');
        ImageEl.addClass('animate__animated animate__zoomIn animate__faster');

        /*
            * Set image source to this source
        */
        ImageEl.attr('src', $(this).attr('data-img-url'));


    });
});
