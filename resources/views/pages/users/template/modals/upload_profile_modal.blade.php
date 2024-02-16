<div class="modal fade" id="upload_profileimage" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                            </div>
                            <div class="p-2 text-sm-center text-lg-end">
                                <button id="cropped_data" class="btn btn-primary" type="button">
                                    <i class="mdi mdi-check"></i> Change
                                </button>
                                <button class="btn btn-secondary thismodal-close" type="button">
                                    <i class="mdi mdi-close"></i> Close
                                </button>
                                @csrf
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
