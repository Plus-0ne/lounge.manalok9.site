{{-- Dealers details modal --}}
<div class="modal fade" id="modalViewDealerDetails" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Dealer Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="container-fluid">
                        <dl class="row">
                            <dt class="col-12 col-lg-3">
                                Name
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="dealersName">

                                </span>
                            </dd>
                            <dt class="col-12 col-lg-3">
                                Email address
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="emailAddress"></span>
                            </dd>
                            <dt class="col-12 col-lg-3 text-truncate">
                                Mobile number
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="mobileNumber"></span>
                            </dd>
                            <dt class="col-12 col-lg-3">
                                Telephone number
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="telephoneNumber"></span>
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Store location
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="storeLocation"></span>
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Valid ID
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <img id="validImageID" class="img-fluid" src="" alt="">
                            </dd>
                        </dl>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
