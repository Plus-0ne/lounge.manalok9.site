<div class="modal fade" id="addNewInsuranceModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Add insurance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="promptcontainer">

                </div>

                <div class="d-flex flex-column">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="insurance-img-container">
                            <img id="insuranceImage" class="insurance-img" src="{{ asset('img/no-preview.jpeg') }}"
                                alt="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="imageFile" class="form-label">Choose file</label>
                            <input id="imageFile" type="file" class="form-control form-control-sm"
                                aria-describedby="imageFileHelp" autocomplete="off">
                            <div id="imageFileHelp" class="form-text">Please choose image : Format accepted -
                                JPG,JPEG,PNG</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input id="title" type="text" class="form-control form-control-sm"
                                aria-describedby="titleHelp" placeholder="Enter the title" autocomplete="off">
                            <small id="titleHelp" class="form-text text-muted">E.g. Sample Title</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input id="price" type="text" class="form-control form-control-sm numberOnlyInput"
                                aria-describedby="priceHelp" placeholder="Enter the price" autocomplete="off">
                            <small id="priceHelp" class="form-text text-muted">E.g. 50000</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" class="form-control form-control-sm" rows="3" aria-describedby="descriptionHelp"
                                placeholder="Enter the description" autocomplete="off"></textarea>
                            <small id="descriptionHelp" class="form-text text-muted">E.g. At IAGD, we understand that
                                your furry friend is more than just a pet; they're a beloved member of your
                                family.....</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="submitNewInsurance" type="button" class="btn btn-primary btn-sm">
                    <span class="mdi mdi-plus"></span> Add insurance
                </button>
            </div>
        </div>
    </div>
</div>
