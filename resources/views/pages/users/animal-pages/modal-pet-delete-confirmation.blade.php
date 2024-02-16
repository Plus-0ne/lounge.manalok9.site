<style>
    .modal.fade {
        opacity: 1;
    }

    .modal.fade .modal-dialog {
        -webkit-transform: translate(0);
        -moz-transform: translate(0);
        transform: translate(0);
    }
</style>
<div class="modal fade alertModal animate__animated" id="modalPetDelete" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">

                    Confirm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you want delete this pet ?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteBtnPet" type="button" class="btn btn-primary btn-sm">
                    <span class="mdi mdi-delete"></span> Delete
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <span class="mdi mdi-cancel"></span> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
