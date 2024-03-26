$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Declare variables                             */
    /* -------------------------------------------------------------------------- */
    let petPage = 1;

    /* -------------------------------------------------------------------------- */
    /*                                Get all pets                                */
    /* -------------------------------------------------------------------------- */
    function getAllPets(petPage) {
        /* Declare new formdata */
        const fd = new FormData();

        const pet_name = $('#pet_name_search');
        const selectPet = $('#selectPet');
        const sorting = $('#sorting');
        const order_by = $('#order_by');
        const premorn = $('#premorn');

        fd.append('pet_name', pet_name.val());
        fd.append('selectPet', selectPet.val());
        fd.append('sorting', sorting.val());
        fd.append('order_by', order_by.val());
        fd.append('premorn', premorn.val());

        $.ajax({
            type: "post",
            url: window.currentBaseUrl + '/user/pet/get?page=' + petPage,
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                /* Clear pet_card_container */
                const pet_card_container = $('#pet_card_container');
                pet_card_container.html("");
            },
            success: function (response) {
                const res = response;
                const pet_card_container = $('#pet_card_container');

                console.log(res);

                /* Fill pet container with cards */
                if (pet_card_container.children().length < 1) {
                    petCardDisplay(res,selectPet);
                }


            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                            On load get all pets                            */
    /* -------------------------------------------------------------------------- */
    getAllPets(petPage);

    /* -------------------------------------------------------------------------- */
    /*                        On select pet update content                        */
    /* -------------------------------------------------------------------------- */
    $('#selectPet , #sorting ,#order_by').on('change', function () {
        petPage = 1;
        getAllPets(petPage);
    });


    /* -------------------------------------------------------------------------- */
    /*                            Pet templete display                            */
    /* -------------------------------------------------------------------------- */
    function petCardDisplay(res,selectPet) {

        /* Get the container */
        const container = $('#pet_card_container');

        /* Check if json data is empty or not found */
        if (res.pets == undefined || res.pets.length < 1 || res.pets == null) {

            container.append(
                $('<div>', {
                    'class': 'w-100 text-center'
                }).append(
                    $('<h5>', {
                        text: 'Pet not found!'
                    })
                )
            );

            return false;
        }



        /* Get pet data */
        const pets = res.pets;




        $.each(pets.data, function (petI, petVal) {

            /*
                * Status
            */
            let status = null;
            let status_class = null;

            /*
                * Pet Image
            */
            let fileImage = 'img/no_img.png';
            if (petVal.adtl_info != null) {
                if (petVal.adtl_info.pet_image != null) {
                    fileImage = petVal.adtl_info.pet_image.file_path;
                }
            }


            switch (petVal.Status) {
                case 1:
                    status = 'Pending';
                    status_class = 'bg-primary'
                    break;

                case 2:
                    status = 'Approved';
                    status_class = 'bg-success'
                    break;

                case 3:
                    status = 'Rejected';
                    status_class = 'bg-danger'
                    break;

                case 4:
                    status = 'Verify details';
                    status_class = 'bg-info'
                    break;

                default:
                    status = 'Canceled';
                    status_class = 'bg-warning'
                    break;
            }

            container.append(
                $('<div>', {
                    class: 'col-12 col-xxl-4 mb-4'
                }).append(
                    $('<div>', {
                        class: 'd-flex justify-content-center align-items-center',
                    }).append(
                        $('<div>', {
                            class: 'pet-card d-flex flex-row'
                        }).append(
                            $('<div>', {
                                class: 'pet-card-image-container'
                            }).append(
                                $('<img>', {
                                    src: window.assetUrl + fileImage,
                                }).on('error',function () {
                                    /*
                                        * On image not found or error loading replace with default placeholder image
                                    */
                                    $(this).attr("src", window.assetUrl + "img/no_img.png ");
                                })
                            )
                        ).append(
                            $('<div>', {
                                class: 'd-flex flex-column justify-content-between p-3 w-100'
                            }).append(
                                $('<div>', {
                                    class: 'pet-card-details-section'
                                }).append(
                                    $('<div>', {
                                        class: 'pet-card-text'
                                    }).append(
                                        $('<div>', {
                                            class: 'lead',
                                            text: petVal.PetName
                                        })
                                    )
                                ).append(
                                    $('<div>', {
                                        class: 'pet-card-text'
                                    }).append(
                                        $('<small>', {
                                            text: (petVal.Breed == undefined || petVal.Breed == null) ? ' ' : petVal.Breed
                                        })
                                    )
                                )
                            ).append(
                                $('<div>', {
                                    class: 'pet-card-status-section'
                                }).append(
                                    $('<div>', {
                                        class: 'pet-card-text'
                                    }).append(
                                        $('<span>', {
                                            class: 'badge rounded-pill ' + status_class + '',
                                            text: status
                                        })
                                    )
                                )
                            )
                        ).on('click',function() {

                            window.location = window.currentBaseUrl + "/user/pet/details?petUuid="+petVal.PetUUID+"&petName="+petVal.PetName+"&type="+selectPet.val();
                            return false;
                        })
                    )
                )
            );
        });


        if (pets.prev_page_url == null) {
            $('#prevPage').addClass('disabled');
        } else {
            $('#prevPage').removeClass('disabled')
        }

        if (pets.next_page_url == null) {
            $('#nextPage').addClass('disabled');
        } else {
            $('#nextPage').removeClass('disabled')
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                               Next page show                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#nextPage', function () {
        petPage++;
        getAllPets(petPage);
    });

    /* -------------------------------------------------------------------------- */
    /*                               Prev page show                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#prevPage', function () {
        petPage--;
        getAllPets(petPage);
    });

    /* -------------------------------------------------------------------------- */
    /*                               On search fill                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('keyup', '#pet_name_search', function () {
        petPage = 1;
        getAllPets(petPage);
    });

    /* -------------------------------------------------------------------------- */
    /*                       Onclick add new pet show modal                       */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#addPetModalBtn', function () {
        $('#selectPetAddModal').modal('show');
    });

    /* -------------------------------------------------------------------------- */
    /*                       Onclick continue go to pet form                      */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#continueAddPetBtn', function () {
        const radioSelected = $('.checkBoxPetType:checked').val();

        switch (radioSelected) {
            case 'bird':
                window.location = window.currentBaseUrl + '/user/pet/form/bird';
                break;

            case 'cat':
                window.location = window.currentBaseUrl + '/user/pet/form/cat';
                break;

            case 'dog':

                window.location = window.currentBaseUrl + '/user/pet/form/dog';
                break;

            case 'rabbit':
                window.location = window.currentBaseUrl + '/user/pet/form/rabbit';
                break;

            case 'others':
                toastr['error']("Other pet page form is in development.");
                break;

            default:
                toastr['error']("Something\'s wrong! Please try again later.");
                break;
        }
    });

    /* -------------------------------------------------------------------------- */
    /*                       Check box imitate radio button                       */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#birdCheckb,#catCheckb,#dogCheckb,#rabbitCheckb,#othersCheckb', function () {

        /*
            * Current checkbox set to variable
        */
        let thisChkBox = $(this);

        /*
            * Check the clicked checkbox
        */
        thisChkBox.prop('checked', true);

        /*
            * Remove other checkbox checked status
        */
        $('.checkBoxPetType').not(thisChkBox).prop('checked', false);

    });
});
