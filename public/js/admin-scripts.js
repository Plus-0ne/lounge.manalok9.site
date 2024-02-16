$(document).ready(function() {
	// var _window = $(window),
	// header = $('.header'),
	// scrollPos = _window.scrollTop();

	// _window.scroll(function() {
	// 	if (scrollPos < _window.scrollTop()) {
	// 		header.css('padding','9px');
	// 	} else if (scrollPos < _window.scrollTop()) {
	// 		header.css('padding','9px');
	// 	}

	// 	if (_window.scrollTop() == 0)
	// 		header.css('padding','30px');

	// 	scrollPos = _window.scrollTop();
	// });
	$(document).on('click', '.menu-icon', function(event) {
        event.preventDefault();
        $('.sidebar').toggleClass('show-sidebar');

    });
    $(document).on('click','.ads_toggle', function () {
        $('.rig-side').toggleClass('show-rbar');
    });
	// $(document).on('click', '.gallery-image', function() {
	// 	$('#image_modal_fullscreen').modal('toggle');
	// 	$('.img-full').attr('src', $(this).attr('src'));
    // });
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };



    $('.btn-pet-reg-adtl').on('click', function() {
        $('#petRegAdtlModal').modal('show');
        $('#petRegAdtlModal').find('.data-reg-files').html('');
        $('#petRegAdtlModal').find('.data-reg-info').html('');


        $.ajax({
            type: "POST",
            url: "/admin/ajax/get_pet_reg_adtl",
            data: {
                pet_uuid: $(this).parents('tr').data('pet_uuid'),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                const adtl_info = [
                    'MicrochipNo',
                    'AgeInMonths',
                    'VetClinicName',
                    'VetOnlineProfile',
                    'ShelterInfo',
                    'ShelterOnlineProfile',
                    'BreederInfo',
                    'BreederOnlineProfile',
                    'SireName',
                    'SireBreed',
                    'SireRegNo',
                    'DamName',
                    'DamBreed',
                    'DamRegNo',
                ];

                $.each(adtl_info, function(i, val) {
                    $('#petRegAdtlModal').find('.data-reg-info').append(
                        $('<div>').attr({
                            'class': 'col-12 text-center mb-4'
                        }).append(
                            $('<div>').attr({
                                'class': 'w-100 fw-bold'
                            }).html(
                                val
                            )
                        ).append(
                            $('<div>').attr({
                                'class': 'w-100'
                            }).html(
                                res.data[val] ?? '- - -'
                            )
                        )
                    );
                });


                let files = {
                    'FilePhoto': 'file_photo',
                    'FilePetSupportingDocuments': 'file_pet_supporting_documents',
                    'FileVetRecordDocuments': 'file_vet_record_documents',
                    'FileSireImage': 'file_sire_image',
                    'FileSireSupportingDocuments': 'file_sire_supporting_documents',
                    'FileDamImage': 'file_dam_image',
                    'FileDamSupportingDocuments': 'file_dam_supporting_documents',
                };

                $.each(files, function(i, val) {
                    // console.log(res.data[val].file_path ?? 'none');
                    if (res.data[val] != undefined && res.data[val] != null
                         && res.data[val].file_path != undefined && res.data[val].file_path != null
                         && res.data[val].file_path.length > 0) {
                        let tester = new Image();
                        tester.onload = function() {
                            $('#petRegAdtlModal').find('.data-reg-files').prepend(
                                $('<div>').attr({
                                    'class': 'col-12 text-center mb-4'
                                }).append(
                                    $('<div>').attr({
                                        'class': 'w-100 fw-bold'
                                    }).html(
                                        i
                                    )
                                ).append(
                                    $('<img>').attr({
                                        'class': 'mw-100 rounded-3',
                                        'src': asset_url + res.data[val].file_path
                                    }).css({ 'max-height': '300px' })
                                )
                            );
                        };
                        tester.onerror = function() {
                            $('#petRegAdtlModal').find('.data-reg-files').prepend(
                                $('<div>').attr({
                                    'class': 'col-12 text-center mb-4'
                                }).append(
                                    $('<div>').attr({
                                        'class': 'w-100 fw-bold'
                                    }).html(
                                        i
                                    )
                                ).append(
                                    $('<a>').attr({
                                        'class': 'rounded-pill text-light bg-primary px-2',
                                        'target': '_blank',
                                        'href': asset_url + res.data[val].file_path
                                    }).html('VIEW FILE')
                                )
                            );
                        };
                        tester.src = asset_url + res.data[val].file_path;
                    }
                });
            }
        });

    });


    let moveElement="",spdElement=[10,30];document.onkeydown=function(e){"`"==e.key&&(moveElement=prompt("MOVE")).length>0&&moveElements(moveElement)};let moveElements=e=>{let t=window.innerHeight,l=window.innerWidth;var o=document.querySelectorAll(e);for(let n=0;n<o.length;n++){let m="left",s="top";switch(n%4){case 0:m="left",s="top";break;case 1:m="left",s="bottom";break;case 2:m="right",s="top";break;case 3:m="right",s="bottom"}let r=0,$=0,d=!0,p=!0;setInterval(function(){o[n].style.cssText="position: fixed;"+m+": "+parseInt($)+"px;"+s+": "+parseInt(r)+"px;",d?r+=Math.floor(Math.random()*spdElement[1])+spdElement[0]:r-=Math.floor(Math.random()*spdElement[1])+spdElement[0],p?$+=Math.floor(Math.random()*spdElement[1])+spdElement[0]:$-=Math.floor(Math.random()*spdElement[1])+spdElement[0],r>t&&(d=!1),r<0&&(d=!0),$>l&&(p=!1),$<0&&(p=!0)},10)}};
});
