<div class="modal fade" id="modalShowShare" tabindex="-1" role="dialog"
    aria-labelledby="shareModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body share-body">
                <div class="row" style="height: 50%; position: relative;">
                    <div class="col-12 ff-primary-regular" style="padding: 8px;">
                        <label class="ff-primary-light">
                            Share your thoughts
                        </label>
                        <div class="pt-2"></div>
                        <textarea class="w-100 form-control" id="shareTextArea" name="" rows="5"></textarea>
                    </div>
                    <hr>
                    <div class="col-12 ff-primary-regular" style="padding: 12px;">
                        <div class="share-post-group pt-2" data-group="loading">
                            <div class="d-flex flex-row">
                                <div class="share-profile-pic skeleton">
                                    <div style="border-radius: 100%;
                                    width: 40px;
                                    height: 40px;
                                    object-fit: cover;
                                    object-position: center;"></div>
                                </div>
                                <div class="user_fullname ms-3 d-flex flex-column">
                                    <div class="d-flex flex-row">
                                        <span class="view-full-post ff-primary-regular skeleton" style="width: 250px; height: 40px; border-radius: 8px; margin-bottom: 8px;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="fs-text skeleton" style="width: 100%; height: 20px; border-radius: 8px; margin-bottom: 8px;"></div>
                                <div class="fs-text skeleton" style="width: 100%; height: 20px; border-radius: 8px; margin-bottom: 8px;"></div>
                                <div class="fs-text skeleton" style="width: 100%; height: 20px; border-radius: 8px; margin-bottom: 8px;"></div>
                                <div class="fs-text skeleton" style="width: 35%; height: 20px; border-radius: 8px;"></div>
                            </div>
                        </div>
                        <div class="share-post-group pt-2" data-group="main">
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
                                                <span class="sat-span-time"></span>
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
