@php
    if ($data['pet_data']->Status != 4) return;
@endphp

<form id="pet_update_form" action="{{ route('user.update_bird_unregistered') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="update_bird_unregistered" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Verify Bird Registration
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <input type="hidden" name="pet_petuuid" value="{{ $data['pet_data']->PetUUID }}">

                            <div class="col-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Name:
                                </label>
                                <input class="form-control" type="text" name="pet_petname" placeholder="*" required
                                    value="{{ $data['pet_data']->PetName ?? '' }}">
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> Microchip Number:
                                </label>
                                <input class="form-control" type="text" name="pet_microchip_no"
                                    value="{{ $data['adtl_data']->MicrochipNo ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-cake-variant-outline mdi-24px pe-1"></i> Birth Date:
                                </label>
                                <input class="form-control" type="date" name="pet_birthdate" placeholder="*" required
                                    value="{{ $data['pet_data']->BirthDate ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-calendar-month mdi-24px pe-1"></i> Age (in months):
                                </label>
                                <input class="form-control" type="number" name="pet_age"
                                    value="{{ $data['adtl_data']->AgeInMonths ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-gender-male-female mdi-24px pe-1"></i> Gender:
                                </label>
                                <select class="form-control" name="pet_gender" required>
                                    <option value="0" {{ $data['pet_data']->Gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="1" {{ $data['pet_data']->Gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-eye mdi-24px pe-1"></i> Eye Color:
                                </label>
                                <input class="form-control" type="text" name="pet_eyecolor"
                                    value="{{ $data['pet_data']->EyeColor ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-palette mdi-24px pe-1"></i> Pet Color:
                                </label>
                                <input class="form-control" type="text" name="pet_petcolor"
                                    value="{{ $data['pet_data']->PetColor ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-star-half-full mdi-24px pe-1"></i> Markings:
                                </label>
                                <input class="form-control" type="text" name="pet_markings"
                                    value="{{ $data['pet_data']->Markings ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-arrow-up-down mdi-24px pe-1"></i> Height:
                                </label>
                                <input class="form-control" type="text" name="pet_height"
                                    value="{{ $data['pet_data']->Height ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-weight mdi-24px pe-1"></i> Weight:
                                </label>
                                <input class="form-control" type="text" name="pet_weight"
                                    value="{{ $data['pet_data']->Weight ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-map-marker mdi-24px pe-1"></i> Location:
                                </label>
                                <input class="form-control" type="text" name="pet_location"
                                    value="{{ $data['pet_data']->Location ?? '' }}">
                            </div>

                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-account-multiple mdi-24px pe-1"></i> Co-Owner:
                                </label>
                                <input class="form-control" type="text" name="pet_co_owner"
                                    value="{{ $data['pet_data']->Co_Owner ?? '' }}">
                            </div>


                            <div class="col-12"></div>

                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Upload a photo of your bird:
                                </label>
                                <input class="image_input form-control" type="file" name="pet_image" required>
                                <img class="image_preview w-100 d-none">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Other supporting documents:
                                </label>
                                <input class="form-control" type="file" name="pet_supporting_documents">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-hospital-box mdi-24px pe-1"></i> Veterinarian or Clinic's Name:
                                </label>
                                <input class="form-control" type="text" name="pet_vet_name"
                                    value="{{ $data['adtl_data']->VetClinicName ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Veterinarians Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_vet_url"
                                    value="{{ $data['adtl_data']->VetOnlineProfile ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Upload your bird's veterinary record (only when applicable):
                                </label>
                                <input class="form-control" type="file" name="pet_vet_record_documents">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-home mdi-24px pe-1"></i> Kennel Information:
                                </label>
                                <input class="form-control" type="text" name="pet_shelter"
                                    value="{{ $data['adtl_data']->ShelterInfo ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Kennels Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_shelter_url"
                                    value="{{ $data['adtl_data']->ShelterOnlineProfile ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Breeder Information:
                                </label>
                                <input class="form-control" type="text" name="pet_breeder"
                                    value="{{ $data['adtl_data']->BreederInfo ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Breeder Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_breeder_url"
                                    value="{{ $data['adtl_data']->BreederOnlineProfile ?? '' }}">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Sire:
                                </label>
                                <input class="form-control" type="text" name="pet_sirename"
                                    value="{{ $data['adtl_data']->SireName ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Upload Sire Image:
                                </label>
                                <input class="image_input form-control" type="file" name="pet_sire_image">
                                <img class="image_preview w-100 d-none">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Other sire supporting documents:
                                </label>
                                <input class="form-control" type="file" name="pet_sire_supporting_documents">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_sire_breed"
                                    value="{{ $data['adtl_data']->SireBreed ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                </label>
                                <input class="form-control" type="text" name="pet_sireregno"
                                    value="{{ $data['adtl_data']->SireRegNo ?? '' }}">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Dam:
                                </label>
                                <input class="form-control" type="text" name="pet_damname"
                                    value="{{ $data['adtl_data']->DamName ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Upload Dam Image:
                                </label>
                                <input class="image_input form-control" type="file" name="pet_dam_image">
                                <img class="image_preview w-100 d-none">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Other dam supporting documents:
                                </label>
                                <input class="form-control" type="file" name="pet_dam_supporting_documents">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_dam_breed"
                                    value="{{ $data['adtl_data']->DamBreed ?? '' }}">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                </label>
                                <input class="form-control" type="text" name="pet_damregno"
                                    value="{{ $data['adtl_data']->DamRegNo ?? '' }}">
                            </div>



                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <button type="submit" class="btn btn-success btn-size-95-rem">
                        <i class="mdi mdi-checkbox-marked-outline"></i> VERIFY REGISTRATION
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
