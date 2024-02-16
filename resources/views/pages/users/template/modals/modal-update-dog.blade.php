<form action="{{ route('user.update_dog') }}" method="post">
    @csrf
    <div class="modal fade" id="update_dog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Dog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <input type="hidden" name="pet_petno" value="{{ $data['pet_data']->PetNo }}">

                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Name:
                                </label>
                                <input class="form-control" type="text" name="pet_petname" placeholder="*" required
                                    @if (!empty($data['pet_data']->PetName))
                                        value="{{ $data['pet_data']->PetName }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-cake-variant-outline mdi-24px pe-1"></i> Birth Date:
                                </label>
                                <input class="form-control" type="date" name="pet_birthdate" placeholder="*" required
                                    @if (!empty($data['pet_data']->BirthDate))
                                        value="{{ date('Y-m-d', strtotime($data['pet_data']->BirthDate)) }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-gender-male-female mdi-24px pe-1"></i> Gender:
                                </label>
                                <input class="form-control" type="text" name="pet_gender" placeholder="*" required
                                    @if (!empty($data['pet_data']->Gender))
                                        value="{{ $data['pet_data']->Gender }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-map-marker mdi-24px pe-1"></i> Location:
                                </label>
                                <input class="form-control" type="text" name="pet_location" placeholder="*" required
                                    @if (!empty($data['pet_data']->Location))
                                        value="{{ $data['pet_data']->Location }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_breed" placeholder="*" required
                                    @if (!empty($data['pet_data']->Breed))
                                        value="{{ $data['pet_data']->Breed }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-account mdi-24px pe-1"></i> Owner:
                                </label>
                                <input class="form-control" type="text" name="pet_owner"
                                    @if (!empty($data['pet_data']->Owner))
                                        value="{{ $data['pet_data']->Owner }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-account mdi-24px pe-1"></i> Co-Owner:
                                </label>
                                <input class="form-control" type="text" name="pet_co_owner"
                                    @if (!empty($data['pet_data']->Co_Owner))
                                        value="{{ $data['pet_data']->Co_Owner }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-account mdi-24px pe-1"></i> Breeder:
                                </label>
                                <input class="form-control" type="text" name="pet_breeder"
                                    @if (!empty($data['pet_data']->Breeder))
                                        value="{{ $data['pet_data']->Breeder }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-star-half-full mdi-24px pe-1"></i> Markings:
                                </label>
                                <input class="form-control" type="text" name="pet_markings"
                                    @if (!empty($data['pet_data']->Markings))
                                        value="{{ $data['pet_data']->Markings }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-palette mdi-24px pe-1"></i> Color:
                                </label>
                                <input class="form-control" type="text" name="pet_petcolor"
                                    @if (!empty($data['pet_data']->PetColor))
                                        value="{{ $data['pet_data']->PetColor }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-eye mdi-24px pe-1"></i> Eye Color:
                                </label>
                                <input class="form-control" type="text" name="pet_eyecolor"
                                    @if (!empty($data['pet_data']->EyeColor))
                                        value="{{ $data['pet_data']->EyeColor }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-arrow-up-down mdi-24px pe-1"></i> Height:
                                </label>
                                <input class="form-control" type="text" name="pet_height"
                                    @if (!empty($data['pet_data']->Height))
                                        value="{{ $data['pet_data']->Height }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-weight mdi-24px pe-1"></i> Weight:
                                </label>
                                <input class="form-control" type="text" name="pet_weight"
                                    @if (!empty($data['pet_data']->Weight))
                                        value="{{ $data['pet_data']->Weight }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-gender-male mdi-24px pe-1"></i> Sire Name:
                                </label>
                                <input class="form-control" type="text" name="pet_sirename"
                                    @if (!empty($data['pet_data']->SireName))
                                        value="{{ $data['pet_data']->SireName }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-gender-female mdi-24px pe-1"></i> Dam Name:
                                </label>
                                <input class="form-control" type="text" name="pet_damname"
                                    @if (!empty($data['pet_data']->DamName))
                                        value="{{ $data['pet_data']->DamName }}"
                                    @endif
                                    >
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
