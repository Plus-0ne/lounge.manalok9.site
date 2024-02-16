<div class="modal fade" id="newAdminFormModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Create new admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row justify-content-center align-items-center">

                    </div>
                    <div class="px-3">
                        <div class="frm-img-container img-dt-round">
                            <img id="img-user-profile" class="img-dt-round" src="{{ asset('img/user/user.png') }}" alt="">
                        </div>
                        <hr>
                        <dl class="row">
                            <dt class="col-12 col-lg-3">
                                Name
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="user_name"></span>
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Email address
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="user_email"></span>
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Date registered
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <span id="user_dregister"></span>
                            </dd>

                        </dl>

                        <hr>

                        <dl class="row">
                            <dt class="col-12 col-lg-3">
                                Department
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <input id="department" type="text" class="form-control form-control-sm" autocomplete="off">
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Position
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <input id="position" type="text" class="form-control form-control-sm" autocomplete="off">
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Role
                            </dt>
                            <dd class="col-12 col-lg-9">
                                <select id="roles" class="form-select form-select-sm">
                                    <option selected value="user">User</option>
                                    <option value="superuser">Superuser</option>

                                </select>
                            </dd>

                            <dt class="col-12 col-lg-3">
                                Password
                            </dt>
                            <dd class="col-12 col-lg-9 d-flex flex-column">
                                <div>
                                    <input id="password" type="text" class="form-control form-control-sm mb-2" autocomplete="off" placeholder="Password">
                                    <input id="verifyPassword" type="text" class="form-control form-control-sm mb-2" autocomplete="off" placeholder="Verify password">
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <button id="generatePassword" type="button" class="btn btn-primary btn-sm">
                                        <span class="mdi mdi-key"></span> Generate password
                                    </button>
                                    <small class="ms-2 text-danger">
                                        <span class="mdi mdi-information"></span> Please copy and secure your password.
                                    </small>
                                </div>
                            </dd>

                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="createNewAdmin" type="button" class="btn btn-primary btn-sm">
                    <span class="mdi mdi-plus"></span> Create admin
                </button>
            </div>
        </div>
    </div>
</div>
