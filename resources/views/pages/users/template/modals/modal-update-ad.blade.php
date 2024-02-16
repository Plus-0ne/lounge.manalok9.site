<form action="{{ route('user.update_advertisement') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="update_ad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Advertisement
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <input type="hidden" name="ad_uuid" value="{{ $data['ad_data']->uuid }}">

                            <div class="col-12 col-lg-8 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-format-title mdi-24px pe-1"></i> Title:
                                </label>
                                <input class="form-control" type="text" name="ad_title"
                                    @if (!empty($data['ad_data']->title))
                                        value="{{ $data['ad_data']->title }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-comment-text mdi-24px pe-1"></i> Message:
                                </label>
                                <textarea class="form-control" name="ad_message" rows="7">{{ $data['ad_data']->message }}</textarea>
                            </div>
                            <div class="col-12 col-lg-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-attachment"></i> Image:
                                </label>
                                <input class="form-control" type="file" name="file_path">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <button type="submit" class="btn btn-primary btn-size-95-rem">
                        <i class="mdi mdi-check"></i> UPDATE
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
