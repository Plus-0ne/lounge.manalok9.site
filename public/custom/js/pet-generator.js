
$(document).on('click', '.btn-cert_gen', function() {
    $('#generate_certificate').modal('toggle');
    $.ajax({
        url: '/ajax_get_details_pet?id=' + $(this).data('id') + '&type=' + pType,
        type: "get",
        dataType: 'json'
    })
    .done(function(response) {
        if (response != 0) {
            $('#pet_type_cert').val(pType);

            $('#pet_name').val((response.PetName == null) ? '' : response.PetName);
            $('#pet_breed').val((response.Breed == null) ? '' : response.Breed);
            $('#pet_no').val((response.PetNo == null) ? '' : response.PetNo);
            $('#pet_birthdate').val((response.BirthDate == null) ? '' : response.BirthDate);
            $('#pet_gender').val((response.Gender == null) ? '' : response.Gender);
            $('#pet_owner').val((response.Owner == null) ? '' : response.Owner);
            $('#pet_home').val((response.CoopName == null) ? '' : response.CoopName);
            $('#pet_breeder').val((response.Breeder == null) ? '' : response.Breeder);
            $('#pet_microchip_no').val((response.MicrochipNo == null) ? '' : response.MicrochipNo);
            $('#pet_verification_level').val((response.VerificationLevel == null) ? '' : response.VerificationLevel);
        } else {
            toastr["warning"]("Something's wrong, Please try again.");
        }
    })
    .fail(function(jqXHR, ajaxOptions, thrownError) {
        console.log(thrownError);
    });
});

$(document).on('click', '.btn-pedi_gen', function() {
    $('#generate_pedigree').modal('toggle');
    $.ajax({
        url: '/ajax_get_details_pet?id=' + $(this).data('id') + '&type=' + pType,
        type: "get",
        dataType: 'json'
    })
    .done(function(response) {
        if (response != 0) {
            $('#pedi_pet_type').val(pType);
            $('#pedi_pet_id').val((response.ID == null) ? '' : response.ID);

            $('#pedi_pet_name').val((response.PetName == null) ? '' : response.PetName);
            $('#pedi_pet_no').val((response.PetNo == null) ? '' : response.PetNo);
            $('#pedi_pet_birthdate').val((response.BirthDate == null) ? '' : response.BirthDate);
            $('#pedi_pet_breed').val((response.Breed == null) ? '' : response.Breed);
            $('#pedi_pet_gender').val((response.Gender == null) ? '' : response.Gender);
            $('#pedi_pet_owner').val((response.Owner == null) ? '' : response.Owner);
            $('#pedi_pet_home').val((response.KennelName == null) ? '' : response.KennelName);
            $('#pedi_pet_breeder').val((response.Breeder == null) ? '' : response.Breeder);

            $('.pedi_pet_sirename_0').val((response.SireName == null) ? '' : response.SireName);
            $('.pedi_pet_sirebreed_0').val((response.SireBreed == null) ? '' : response.SireBreed);

            $('.pedi_pet_damname_0').val((response.DamName == null) ? '' : response.DamName);
            $('.pedi_pet_dambreed_0').val((response.DamBreed == null) ? '' : response.DamBreed);


            $.each(response.gens, function(i,v) {
                if (v != null) {
                    if (v.sire_name != null) $('.pedi_pet_sirename_' + v.pair_no).val(v.sire_name);
                    if (v.sire_breed != null) $('.pedi_pet_sirebreed_' + v.pair_no).val(v.sire_breed);

                    if (v.dam_name != null) $('.pedi_pet_damname_' + v.pair_no).val(v.dam_name);
                    if (v.dam_breed != null) $('.pedi_pet_dambreed_' + v.pair_no).val(v.dam_breed);
                }
            });
        } else {
            toastr["warning"]("Something's wrong, Please try again.");
        }
    })
    .fail(function(jqXHR, ajaxOptions, thrownError) {
        console.log(thrownError);
    });
});

$(document).on('click', '.btn-toggle-gen', function() {
    $(this).toggleClass('btn-info btn-warning');
    $('.ped-gen-div[data-gen="' + $(this).data('gen') +'"]').toggleClass('d-none');
});
