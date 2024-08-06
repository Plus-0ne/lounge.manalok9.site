// Import SweetAlert custom module
import { swalConfirmation , swalPrompts } from "/js/jsHelpers.js";

$(function () {
    /**
     * Submit dealers details to endpoint "/dealers/create"
     * @param {any} '#btnSubmitDealerForm'
     * @returns {any}
     */
    $("#btnSubmitDealerForm").on("click", function (e) {
        let swalText = "Do you want to apply as a dealer ?";
        let swalIcon = "info";
        let swalConfirmBtn = "Yes";
        let swalCancelBtn = "No";
        let swalConfirmClass = "btn btn-primary";
        let swalCancelClass = "btn btn-secondary";

        let image_upload = document.querySelector('#image_file');

        let thisBtn = $(this);
        let defaultHtmlContent = $(this).html();
        swalConfirmation(
            swalText,
            swalIcon,
            swalConfirmBtn,
            swalCancelBtn,
            swalConfirmClass,
            swalCancelClass
        ).then((result) => {
            if (result.isConfirmed) {

                const fd = new FormData();
                const endpoint = window.thisUrl + "/dealer/create";

                fd.append("first_name", $("#first_name").val());
                fd.append("last_name", $("#last_name").val());
                fd.append("middle_name", $("#middle_name").val());
                fd.append("email_address", $("#email_address").val());
                fd.append("contact_number", $("#contact_number").val());
                fd.append("telephone_number", $("#telephone_number").val());
                fd.append("store_address", $("#store_address").val());

                fd.append("image_file", image_upload.files[0]);


                $.ajax({
                    url: endpoint,
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function () {
                        thisBtn.html(`<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Applying`);
                        thisBtn.prop('disabled',true);
                    },
                    success: function (response) {
                        const res = response;

                        console.log(res);

                        if (res.status !== undefined) {
                            let swalText = res.message;
                            let swalIcon = res.status;
                            let swalConfirmBtn = "Ok";
                            let swalConfirmClass = "btn btn-primary";
                            swalPrompts(
                                swalText,
                                swalIcon,
                                swalConfirmBtn,
                                swalConfirmClass
                            );
                        }
                    },
                    error: function (error) {

                        let swalText = error.responseJSON.message;
                        let swalIcon = 'error';
                        let swalConfirmBtn = 'Ok';
                        let swalConfirmClass = 'btn btn-primary'
                        swalPrompts(swalText,swalIcon,swalConfirmBtn,swalConfirmClass);
                    },
                    complete: function () {
                        thisBtn.html(defaultHtmlContent);
                        thisBtn.prop('disabled',false);
                    }
                });


            }
        });
    });

    /**
     * On file input change preview image before upload
     * @param {any} '#image_file'
     * @returns {any}
     */
    $('#image_file').on('change', function (event) {
        let previewContainer = $('#previewImageContainer');

        previewContainer.html("");

        if (!event.target.files[0]) {

            previewContainer.append('<i class="bi bi-images" style="font-size: 10rem;"></i>');

            return;
        }

        previewContainer.append($('<img>',{
            class: 'img-fluid img-thumbnail previewImageFile',
            src : URL.createObjectURL(event.target.files[0])
        }));

    });
});
