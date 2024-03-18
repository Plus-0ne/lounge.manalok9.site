<div class="modal fade" id="modalShowShare" tabindex="-1" role="dialog"
    aria-labelledby="shareModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body share-body">
                <div class="row">
                    <div class="col-12 ff-primary-regular" style="padding: 8px;">
                        <label class="ff-primary-light">
                            Share your thoughts
                        </label>
                        <div class="pt-2"></div>
                        <textarea class="w-100 form-control" id="shareTextArea" name="" rows="5"></textarea>
                    </div>
                    <hr>
                    <div class="col-12 ff-primary-regular" style="padding: 12px;">
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
                    Repost
                </button>
            </div>
        </div>
    </div>
</div>
