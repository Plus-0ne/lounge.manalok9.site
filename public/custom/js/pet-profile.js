$(document).ready(function() {
    // function LoadCropper() {
    //     var $image = $('#img-prof');
    //     $image.cropper('destroy');

    //     $image.cropper({
    //         aspectRatio: 1 / 1,
    //         dragMode: 'move',
	// 	    autoCropArea: 0.65,
	// 	    restore: false,
	// 	    guides: false,
	// 	    center: false,
	// 	    highlight: false,
	// 	    cropBoxMovable: false,
	// 	    cropBoxResizable: false,
	// 	    toggleDragModeOnDblclick: false,
    //         zoomOnWheel: false,
	// 	    data:{ //define cropbox size
	// 	      width: 1000,
	// 	      height:  1000,
	// 	    },
    //     });
    //     var cropper = $image.data('cropper');
    // }

    // function DestroyCropper() {
    //     var $image = $('#img-prof');
    //     $image.cropper('destroy');
    // }
    // $('#upload_img_pet').modal({
    //     backdrop: 'static',
    //     keyboard: false
    // });
    // $('.thismodal-close').on('click' , function (){
    //     $('#upload_img_pet').modal('toggle');
    // });
    // $(document).on('click', '.btn-pet-image', function (){
    //     $('#upload_img_pet').data('pet_image', $(this).data('image'));
    //     $('#pet_no').val($(this).data('pet_no'));
    //     $('#pet_type').val($(this).data('pet_type'));
    // });
    // $('#upload_img_pet').on('shown.bs.modal', function () {
    //     DestroyCropper();
    //     var source_img = $('#pet-img').attr('src');
    //     $('.image-prof').attr('src', source_img);
    // });
    // $('#upload_img_pet').on('hidden.bs.modal', function () {
    //     DestroyCropper();
    //     $('.image-prof').attr('src', '');
    // });
    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             $('#img-prof').attr('src', e.target.result);
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }
    // $("#file_image").change(function(){
    //     readURL(this);
    //     setTimeout(function() {
    //         LoadCropper();
    //     }, 1000);
    // });
    // $('#frm_upload_img_pet').on('submit', function (e) {
    //     var image = $('#img-prof');
    //     var img_cropped = image.cropper('getCroppedCanvas').toDataURL("image/png");
    //     $('#image').val(img_cropped);

    //     if (!img_cropped) {
    //          e.preventDefault();
    //     }
    // });


    $('.adtl_info_label').on('click', function (e) {
        $(this).next('.adtl_info').toggleClass('d-none');
    });

    $('.toggle-visibilityPublic').on('click', function (e) {
        togglePetVisibility('public');
    });
    $('.toggle-visibilityPrivate').on('click', function (e) {
        togglePetVisibility('private');
    });

    function togglePetVisibility(visibility) {
        toastr.options.timeOut = 1000;
        toastr.options.onHidden = function() { location.reload(); };
        $.ajax({
            type: "POST",
            url: "/ajax/toggle_pet_visibility",
            data: {
                pet_no: js_var.pet_no,
                pet_uuid: js_var.pet_uuid,
                pet_type: js_var.pet_type,
                visibility: visibility,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                toastr[res.custom_alert](res.message);
            },
            error: function(jqxhr, status, exception) {
                toastr['error']('Something\'s wrong! Please try again.');
            }
        });
    }
});
