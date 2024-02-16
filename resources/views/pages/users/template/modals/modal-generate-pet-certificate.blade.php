<form action="{{ route('users.Create_certificate_animal_registration') }}" method="post" target="_blank">
    @csrf
    <div class="modal fade" id="generate_certificate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Generate Certificate
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <input id="pet_type_cert" type="hidden" name="pet_type">

                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    NAME:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_name_cb">
                                        </label>
                                    </div>
                                    <input id="pet_name" class="form-control" type="text" name="pet_name">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    BREED:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_breed_cb">
                                        </label>
                                    </div>
                                    <input id="pet_breed" class="form-control" type="text" name="pet_breed">
                                </div>
                            </div>

                        {{-- INFO --}}
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    NO:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_no_cb">
                                        </label>
                                    </div>
                                    <input id="pet_no" class="form-control" type="text" name="pet_no">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    BIRTHDATE (yyyy-mm-dd):
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_birthdate_cb">
                                        </label>
                                    </div>
                                    <input id="pet_birthdate" class="form-control" type="text" name="pet_birthdate">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    GENDER:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_gender_cb">
                                        </label>
                                    </div>
                                    <input id="pet_gender" class="form-control" type="text" name="pet_gender">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    OWNER:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_owner_cb">
                                        </label>
                                    </div>
                                    <input id="pet_owner" class="form-control" type="text" name="pet_owner">
                                </div>
                            </div>
                        {{--  --}}
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    HOME:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_home_cb">
                                        </label>
                                    </div>
                                    <input id="pet_home" class="form-control" type="text" name="pet_home">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    BREEDER:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_breeder_cb">
                                        </label>
                                    </div>
                                    <input id="pet_breeder" class="form-control" type="text" name="pet_breeder">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    MICROCHIP_NO:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_microchip_no_cb">
                                        </label>
                                    </div>
                                    <input id="pet_microchip_no" class="form-control" type="text" name="pet_microchip_no">
                                </div>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label fw-bold">
                                    VERIFICATION_LEVEL:
                                </label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-text p-0 m-0">
                                        <label class="px-3 py-2">
                                            <input class="form-check-input" type="checkbox" checked name="pet_verification_level_cb">
                                        </label>
                                    </div>
                                    <input id="pet_verification_level" class="form-control" type="number" name="pet_verification_level">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <i>(Payment of PHP 500.00 is required. * amount is subject to change)</i>
                    <button type="submit" class="btn btn-primary btn-size-95-rem">
                        GENERATE CERTIFICATE
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
