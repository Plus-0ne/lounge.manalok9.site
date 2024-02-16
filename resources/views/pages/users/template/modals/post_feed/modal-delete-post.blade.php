<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal" id="del_postModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-column my-5">
                    <h1 class="ms-auto me-auto">
                        <i class="mdi mdi-delete-outline text-danger"></i>
                    </h1>
                    <p class="ms-auto me-auto text-center">
                        Are you sure you want to delete this post ?
                    </p>
                </div>
            </div>
            <div class="modal-footer w-100">
                <div class="d-flex justify-content-between w-100">
                    <button id="delete_post_btn" type="button" class="btn btn-primary btn-sm delete_post_btnnn">
                        <i class="mdi mdi-check"></i> Yes
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm delete_post_btn_close">
                        <i class="mdi mdi-cancel"></i> No
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
