<div class="modal fade" id="modalShowShare" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="shareModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="ff-primary-thin lead" id="shareModal">
                    Share post
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body share-body">
                <div class="d-flex flex-column flex-xl-row justify-content-between">
                    <div class="col-12 col-xl-5 ff-primary-regular pe-0 pe-xl-2 pt-3 pt-xl-0">
                        <label class="ff-primary-light">
                            Write post <i class="mdi mdi-pencil"></i>
                        </label>
                        <div class="pt-2"></div>
                        <textarea class="w-100" id="shareTextArea" name="" rows="10"></textarea>
                    </div>
                    <div class="col-12 col-xl-7 ff-primary-regular ps-0 ps-xl-2 pt-3 pt-xl-0">
                        <label class="ff-primary-light">
                            Post details <span class="mdi mdi-post"></span>
                        </label>
                        <div class="pt-2">
                            <div class="d-flex flex-row">
                                <div class="share-profile-pic">
                                    <img class="img-fluid" src="{{ asset('img/sample_image/klee.png') }}" alt=""
                                        srcset="">
                                </div>
                                <div class="user_fullname ms-3 d-flex flex-column">
                                    <div class="d-flex flex-row">
                                        <span class="view-full-post share-username ff-primary-regular"
                                            data-id=""></span>
                                        <small class="ms-2">
                                            <small>
                                                <span class="badge rounded-pill bg-success sat-span-time"></span>
                                            </small>
                                        </small>
                                    </div>
                                    <small>
                                        <span class="share_post_date_label ff-primary-light"></span>
                                    </small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="fs-text share_txt_content" id="share_txt_content">

                                </div>
                                <div id="share_txt_content_extension">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="share_post_submit" type="button" class="btn btn-primary" data-post_id="">
                    <span class="mdi mdi-share"></span>
                    Share
                </button>
            </div>
        </div>
    </div>
</div>
