<form class="pet_add_form" action="{{ route('user.add_pet_unregistered') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="pet_type" value="rabbit">
    <div class="modal fade" id="add_rabbit_unregistered" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Register Rabbit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="row">
                            <div class="col-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Name:
                                </label>
                                <input class="form-control" type="text" name="pet_petname" placeholder="*" required>
                            </div>
                            <div class="col-12 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> Microchip Number:
                                </label>
                                <input class="form-control" type="text" name="pet_microchip_no">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-cake-variant-outline mdi-24px pe-1"></i> Birth Date:
                                </label>
                                <input class="form-control" type="date" name="pet_birthdate" placeholder="*" required>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-calendar-month mdi-24px pe-1"></i> Age (in months):
                                </label>
                                <input class="form-control" type="number" name="pet_age">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-gender-male-female mdi-24px pe-1"></i> Gender:
                                </label>
                                <select class="form-control" name="pet_gender" required>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-rabbit mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_breed" placeholder="*" required>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-eye mdi-24px pe-1"></i> Eye Color:
                                </label>
                                <input class="form-control" type="text" name="pet_eyecolor">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-palette mdi-24px pe-1"></i> Pet Color:
                                </label>
                                <input class="form-control" type="text" name="pet_petcolor">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-star-half-full mdi-24px pe-1"></i> Markings:
                                </label>
                                <input class="form-control" type="text" name="pet_markings">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-arrow-up-down mdi-24px pe-1"></i> Height:
                                </label>
                                <input class="form-control" type="text" name="pet_height">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-weight mdi-24px pe-1"></i> Weight:
                                </label>
                                <input class="form-control" type="text" name="pet_weight">
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-map-marker mdi-24px pe-1"></i> Location:
                                </label>
                                <input class="form-control" type="text" name="pet_location" placeholder="*" required>
                            </div>

                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-account-multiple mdi-24px pe-1"></i> Co-Owner:
                                </label>
                                <input class="form-control" type="text" name="pet_co_owner">
                            </div>
{{-- 
                            <div class="col-12"></div>

                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Upload a photo of your rabbit:
                                </label>
                                <input class="image_input form-control" type="file" name="pet_image">
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
                                <input class="form-control" type="text" name="pet_vet_name">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Veterinarians Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_vet_url">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Upload your rabbit's veterinary record (only when applicable):
                                </label>
                                <input class="form-control" type="file" name="pet_vet_record_documents">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-home mdi-24px pe-1"></i> Kennel Information:
                                </label>
                                <input class="form-control" type="text" name="pet_shelter">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Kennels Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_shelter_url">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Breeder Information:
                                </label>
                                <input class="form-control" type="text" name="pet_breeder">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Breeder Online Profile (URL/link):
                                </label>
                                <input class="form-control" type="text" name="pet_breeder_url">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Sire:
                                </label>
                                <input class="form-control" type="text" name="pet_sirename">
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
                                <input class="form-control" type="text" name="pet_sire_breed">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                </label>
                                <input class="form-control" type="text" name="pet_sireregno">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-12 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Dam:
                                </label>
                                <input class="form-control" type="text" name="pet_damname">
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
                                <input class="form-control" type="text" name="pet_dam_breed">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                </label>
                                <input class="form-control" type="text" name="pet_damregno">
                            </div>
 --}}

                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <button type="submit" class="btn btn-primary btn-size-95-rem">
                        <i class="mdi mdi-check"></i> ADD
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
