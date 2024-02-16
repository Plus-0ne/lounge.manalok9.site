$(document).ready(function() {
	function LoadCropper() {
		var $image = $('#img-prof');
		$image.cropper('destroy');

		$image.cropper({
			aspectRatio: 1 / 1,
			crop: function(event) {
				// console.log(event.detail.x);
				// console.log(event.detail.y);
				// console.log(event.detail.width);
				// console.log(event.detail.height);
				// console.log(event.detail.rotate);
				// console.log(event.detail.scaleX);
				// console.log(event.detail.scaleY);
			}
		});
		var cropper = $image.data('cropper');
	}

	function DestroyCropper() {
		var $image = $('#img-prof');
		$image.cropper('destroy');
	}
	$('#upload_profileimage').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('.thismodal-close').on('click' , function (){
		$('#upload_profileimage').modal('toggle');
	});
	$('#upload_profileimage').on('shown.bs.modal', function () {
		DestroyCropper();
		var source_img = $('#prof-img').attr('src');
		$('.image-prof').attr('src', source_img);
	});
	$('#upload_profileimage').on('hidden.bs.modal', function () {
		DestroyCropper();
		$('.image-prof').attr('src', '');
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#img-prof').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#file_image").change(function(){
		readURL(this);
		setTimeout(function() {
			LoadCropper();
		}, 1000);
	});

    $('#cropped_data').on('click', function () {
        var upImageUrl = upImageUrl;
		var image = $('#img-prof');
		var img_cropped = image.cropper('getCroppedCanvas').toDataURL("image/jpg");
		$.ajax({
			url: 'upload_cropped_image',
            type: "POST",
            data: { 'image': img_cropped },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                toastr["success"]("Profile updated!");
            },
            complete: function () {
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
		});
	});
});
