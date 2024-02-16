<form action="{{ route('user.update_other_animal') }}" method="post">
    @csrf
    <div class="modal fade" id="update_other_animal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Other Animal
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
                                    <i class="mdi mdi-format-list-bulleted-type mdi-24px pe-1"></i> Type:
                                </label>
                                <select class="form-control" name="pet_animaltype" required>
                                    <option value="reptile" {{ ($data['pet_data']->AnimalType == 'reptile' ? 'selected' : '' ) }}>Reptile</option>
                                    <option value="arachnid" {{ ($data['pet_data']->AnimalType == 'arachnid' ? 'selected' : '' ) }}>Arachnids</option>
                                    <option value="aquatic" {{ ($data['pet_data']->AnimalType == 'aquatic' ? 'selected' : '' ) }}>Aquatic</option>
                                    <option value="mammalia" {{ ($data['pet_data']->AnimalType == 'mammalia' ? 'selected' : '' ) }}>Mammalia</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-format-letter-case mdi-24px pe-1"></i> Common Name:
                                </label>
                                <input class="form-control" type="text" name="pet_commonname" placeholder="*" required
                                    @if (!empty($data['pet_data']->CommonName))
                                        value="{{ $data['pet_data']->CommonName }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-family-tree mdi-24px pe-1"></i> Family / Strain:
                                </label>
                                <input class="form-control" type="text" name="pet_familystrain" placeholder="*" required
                                    @if (!empty($data['pet_data']->FamilyStrain))
                                        value="{{ $data['pet_data']->FamilyStrain }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-ruler mdi-24px pe-1"></i> Length:
                                </label>
                                <input class="form-control" type="text" name="pet_sizelength"
                                    @if (!empty($data['pet_data']->SizeLength))
                                        value="{{ $data['pet_data']->SizeLength }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-arrow-left-right mdi-24px pe-1"></i> Width:
                                </label>
                                <input class="form-control" type="text" name="pet_sizewidth"
                                    @if (!empty($data['pet_data']->SizeWidth))
                                        value="{{ $data['pet_data']->SizeWidth }}"
                                    @endif
                                    >
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-arrow-up-down mdi-24px pe-1"></i> Height:
                                </label>
                                <input class="form-control" type="text" name="pet_sizeheight"
                                    @if (!empty($data['pet_data']->SizeHeight))
                                        value="{{ $data['pet_data']->SizeHeight }}"
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
                                    <i class="mdi mdi-palette mdi-24px pe-1"></i> Color / Marking:
                                </label>
                                <input class="form-control" type="text" name="pet_colormarking"
                                    @if (!empty($data['pet_data']->ColorMarking))
                                        value="{{ $data['pet_data']->ColorMarking }}"
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
