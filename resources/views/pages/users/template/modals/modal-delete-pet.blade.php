<!-- Modal -->
<div class="modal" id="delete_this_pet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-column my-5">
                    <h1 class="ms-auto me-auto">
                        <i class="mdi mdi-delete-outline text-danger"></i>
                    </h1>
                    <p class="ms-auto me-auto text-center">
                        Are you sure you want to delete this pet ?
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <button id="delete_pet_btn" type="button" class="btn btn-primary btn-sm delete_pet_btnnn" data-id="">
                        <i class="mdi mdi-check"></i> Yes
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="mdi mdi-cancel"></i> No
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
