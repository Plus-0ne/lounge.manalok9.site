<div class="modal fade" id="upload_img_pet" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <form id="frm_upload_img_pet" action="{{ route('user.upload_pet_image') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-9">
                                <div class="croper-container">
                                    <img id="img-prof" class="image-prof" src="" style="width:100%;">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                <div class="p-2">
                                    <input id="file_image" class="form-control" type="file" name="">
                                    <input id="image" type="hidden" name="image" required>
                                    <input id="pet_no" type="hidden" name="pet_no" required>
                                    <input id="pet_type" type="hidden" name="pet_type">
                                </div>
                                <div class="p-2 text-sm-center text-lg-center">
                                    <button id="cropped_data" class="btn btn-primary my-2" type="submit">
                                        <i class="mdi mdi-check"></i> Change
                                    </button>
                                    <button class="btn btn-secondary thismodal-close my-2" type="button">
                                        <i class="mdi mdi-close"></i> Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
