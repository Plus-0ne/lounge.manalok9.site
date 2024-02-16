<form action="{{ route('user.upload_receipt') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="upload_receipt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Upload Receipt
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">
                        <input type="hidden" name="pet_uuid" id="receipt_pet_uuid">
                        <input type="hidden" name="pet_type" id="receipt_pet_type">

                        <div class="row">
                            <div class="col text-center">
                                Payment of PHP 200.00 is required. (* amount is subject to change)
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-6 py-1">
                                <img class="w-100" src="" id="receipt_img">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-6 py-1">
                                <input class="form-control" type="file" name="receipt_image">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <button type="submit" class="btn btn-primary btn-size-95-rem">
                        <i class="mdi mdi-check"></i> ADD
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
