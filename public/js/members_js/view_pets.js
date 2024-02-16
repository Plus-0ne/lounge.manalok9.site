$(document).ready(function () {

    /* Global variable */
    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;
    window.lastChatdate = '0000-00-00 00:00:00';
    var fpage = 1;



    /* Get all Pets */
    GetUserPets(fpage,rid)

    /* User pet card template */
    function UserPetTemplate(res) {
        $.each(res.userPet, function (i, val) {

            // console.log(val.PetName);
            // console.log(val);

            let pet_icon = '';
            let pet_url = '';
            switch (val.pet_type) {
                case 'dog_mem':
                    pet_url = 'kennel_unregistered_info/' + val.PetUUID;
                    pet_icon = 'dog'; break;
                case 'cat_mem':
                    pet_url = 'cattery_unregistered_info/' + val.PetUUID;
                    pet_icon = 'cat'; break;
                case 'rabbit_mem':
                    pet_url = 'rabbitry_unregistered_info/' + val.PetUUID;
                    pet_icon = 'rabbit'; break;
                case 'bird_mem':
                    pet_url = 'coop_unregistered_info/' + val.PetUUID;
                    pet_icon = 'bird'; break;
                case 'otheranimal_mem':
                    pet_url = 'other_animal_unregistered_info/' + val.PetUUID;
                    pet_icon = 'help-circle-outline'; break;

                case 'dog_reg':
                    pet_url = (val.PetNo != null && val.PetNo.length > 0 ? 'kennel_info/' + val.PetNo : 'dashboard');
                    pet_icon = 'dog'; break;
                case 'cat_reg':
                    pet_url = (val.PetNo != null && val.PetNo.length > 0 ? 'cattery_info/' + val.PetNo : 'dashboard');
                    pet_icon = 'cat'; break;
                case 'rabbit_reg':
                    pet_url = (val.PetNo != null && val.PetNo.length > 0 ? 'rabbitry_info/' + val.PetNo : 'dashboard');
                    pet_icon = 'rabbit'; break;
                case 'bird_reg':
                    pet_url = (val.PetNo != null && val.PetNo.length > 0 ? 'coop_info/' + val.PetNo : 'dashboard');
                    pet_icon = 'bird'; break;
                case 'otheranimal_reg':
                    pet_url = (val.PetNo != null && val.PetNo.length > 0 ? 'other_animal_info/' + val.PetNo : 'dashboard');
                    pet_icon = 'help-circle-outline'; break;
            }

            let pet_regis = '';
            switch (val.pet_type) {
                case 'dog_mem':
                case 'cat_mem':
                case 'rabbit_mem':
                case 'bird_mem':
                case 'otheranimal_mem':
                    pet_regis = 'pet_mem'; break;
                case 'dog_reg':
                case 'cat_reg':
                case 'rabbit_reg':
                case 'bird_reg':
                case 'otheranimal_reg':
                    pet_regis = 'pet_reg'; break;
            }

            $('.pets_section_area').append('<a href="' + window.baseUrl + '/' + pet_url + '" class="p-section-row">\
                <div class="p-section-content ' + pet_regis + '">\
                    <div class="w-100 row">\
                        <div class="p-img-container col-12 col-xs-auto">\
                            <div class="p-img-pholder text-center mx-auto">\
                                <img class="shadow mw-100 mh-100" src="' + assetUrl + (val.adtl_info != null && val.adtl_info.file_photo != null ? val.adtl_info.file_photo.file_path : 'img/no_img.jpg') + '" alt="">\
                            </div>\
                        </div>\
                        <div class="p-det-container col-12 col-xs align-items-center">\
                            <div class="w-100 p-sect-name mt-2 fw-bold text-center">\
                                <i class="mdi mdi-' + pet_icon + ' mdi-16px pe-1"></i>' + val.PetName + '\
                            </div>\
                            <div class="w-100 p-sect-details ps-2 py-2">\
                                <table class="mx-auto">\
                                    <tbody>' +
                                        (val.PetNo != undefined && val.PetNo != null ? '<tr>\
                                            <td class="pe-2 text-secondary">\
                                                IAGD #:\
                                            </td>\
                                            <td class="p-sect-details pb-1">\
                                                ' + val.PetNo + '\
                                            </td>\
                                        </tr>' : '') + 
                                        (val.Gender != undefined && val.Gender != null ? '<tr>\
                                            <td class="pe-2 text-secondary">\
                                                Gender:\
                                            </td>\
                                            <td class="p-sect-details pb-1">\
                                                ' + val.Gender + '\
                                            </td>\
                                        </tr>' : '') +
                                        (val.BirthDate != undefined && val.BirthDate != null ? '<tr>\
                                            <td class="pe-2 text-secondary">\
                                                Birthday:\
                                            </td>\
                                            <td class="p-sect-details pb-1">\
                                                ' + val.BirthDate + '\
                                            </td>\
                                        </tr>' : '') +
                                    '</tbody>\
                                </table>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </a>');
        });
    }

    function GetUserPets(fpage,rid) {
        $.ajax({
            type: "POST",
            url: "/ajax/get_user_pets?page="+fpage,
            data: {
                rid: rid,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                /* Log response */
                // console.log(res.userPet);

                /* Trigger user pet template function */
                UserPetTemplate(res);
            }
        });
    }

});
