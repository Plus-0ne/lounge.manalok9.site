<form action="{{ route('user.update_my_profile') }}" method="post">
    @csrf
    <div class="modal fade" id="update_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <div class="col-12 col-lg-5 py-1">
                                <label class="form-label">
                                    Last Name
                                </label>
                                <input class="form-control" type="text" name="last_name"
                                    value="{{ Auth::guard('web')->user()->last_name }}">
                            </div>
                            <div class="col-12 col-lg-5 py-1">
                                <label class="form-label">
                                    First Name
                                </label>
                                <input class="form-control" type="text" name="first_name"
                                    value="{{ Auth::guard('web')->user()->first_name }}">
                            </div>
                            <div class="col-12 col-lg-2 py-1">
                                <label class="form-label">
                                    MI
                                </label>
                                <input class="form-control" type="text" name="mid"
                                    value="{{ Auth::guard('web')->user()->middle_name }}">
                            </div>
                            <div class="col-12 col-lg-5 py-1">
                                <label class="form-label">
                                    Contact Number
                                </label>
                                <input class="form-control" type="text" name="contact_num"
                                    value="{{ Auth::guard('web')->user()->contact_number }}">
                            </div>
                            <div class="col-12 col-lg-7 py-1">
                                <label class="form-label">
                                    Address
                                </label>
                                <input class="form-control" type="text" name="comp_address"
                                    value="{{ Auth::guard('web')->user()->address }}">
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
