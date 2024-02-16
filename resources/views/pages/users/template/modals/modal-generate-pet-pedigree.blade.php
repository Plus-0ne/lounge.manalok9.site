<form action="{{ route('users.Create_certificate_animal_pedigree') }}" method="post" target="_blank" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="generate_pedigree" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Generate Pedigree
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 px-3">
                    <div class="container">

                        <div class="w-100 d-flex align-items-center" style="overflow: auto; display: inline-flex; white-space: nowrap;">
                            <input id="pedi_pet_id" type="hidden" name="pet_id">
                            <input id="pedi_pet_type" type="hidden" name="pet_type">

                            <div class="h-100 pe-5" style="min-width: 500px;">
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        PetImg:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_img_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_img" class="form-control my-auto" type="file" name="pet_img">
                                    </div>
                                </div>

                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        PetName:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_name_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_name" class="form-control" type="text" name="pet_name">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        PetNo:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_no_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_no" class="form-control" type="text" name="pet_no">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        BirthDate:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_birthdate_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_birthdate" class="form-control" type="text" name="pet_birthdate">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        Breed:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_breed_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_breed" class="form-control" type="text" name="pet_breed">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        Gender:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_gender_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_gender" class="form-control" type="text" name="pet_gender">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        Owner:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_owner_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_owner" class="form-control" type="text" name="pet_owner">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        SHELTER:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_home_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_home" class="form-control" type="text" name="pet_home">
                                    </div>
                                </div>
                                <div class="col-12 py-1">
                                    <label class="form-label fw-bold">
                                        Breeder:
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-text p-0 m-0">
                                            <label class="px-3 py-2">
                                                <input class="form-check-input" type="checkbox" checked name="pet_breeder_cb">
                                            </label>
                                        </div>
                                        <input id="pedi_pet_breeder" class="form-control" type="text" name="pet_breeder">
                                    </div>
                                </div>
                            </div>

                            {{-- 2 DAM/SIRE --}}
                            <div class="h-100 pe-5" style="min-width: 500px;">
                                <div class="col-12">
                                    <button class="btn btn-warning fw-bold btn-toggle-gen w-100 pb-0 my-3" type="button" data-gen="2">
                                        <h4>GEN 2</h4>
                                    </button>

                                    {{-- 1ST PAIR --}}
                                    <div class="row ped-gen-div d-none mb-4 pt-2" style="border-left: 3px solid #000; border-top: 3px dotted #000;"  data-gen="2">

                                        {{-- SIRE --}}
                                        <div class="row">
                                            <div class="col-auto">
                                                <label class="rounded-pill bg-warning fw-bold px-2 py-1">#1 <span class="text-primary">SIRE</span></label>
                                            </div>
                                            <div class="col">
                                                <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                            </div>
                                        </div>

                                        <div class="col-12 py-1">
                                            <label class="form-label fw-bold">
                                                SireImg:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-text p-0 m-0">
                                                    <label class="px-3 py-2">
                                                        <input class="form-check-input" type="checkbox" checked name="pet_sireimg_cb">
                                                    </label>
                                                </div>
                                                <input id="pedi_pet_sireimg" class="form-control my-auto" type="file" name="pet_sireimg">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-1">
                                            <label class="form-label fw-bold">
                                                SireName:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input id="pedi_pet_sirename" class="form-control pedi_pet_sirename_0" type="text" name="pet_sirename[]">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-1">
                                            <label class="form-label fw-bold">
                                                SireBreed:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input id="pedi_pet_sirebreed" class="form-control pedi_pet_sirebreed_0" type="text" name="pet_sirebreed[]">
                                            </div>
                                        </div>

                                        {{-- DAM --}}
                                        <div class="row">
                                            <div class="col-auto">
                                                <label class="rounded-pill bg-warning fw-bold px-2 py-1">#1 <span class="text-success">DAM</span></label>
                                            </div>
                                            <div class="col">
                                                <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                            </div>
                                        </div>

                                        <div class="col-12 py-1">
                                            <label class="form-label fw-bold">
                                                DamImg:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-text p-0 m-0">
                                                    <label class="px-3 py-2">
                                                        <input class="form-check-input" type="checkbox" checked name="pet_damimg_cb">
                                                    </label>
                                                </div>
                                                <input id="pedi_pet_damimg" class="form-control my-auto" type="file" name="pet_damimg">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-1">
                                            <label class="form-label fw-bold">
                                                DamName:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input id="pedi_pet_damname" class="form-control pedi_pet_damname_0" type="text" name="pet_damname[]">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-1">
                                            <label class="form-label fw-bold">
                                                DamBreed:
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input id="pedi_pet_dambreed" class="form-control pedi_pet_dambreed_0" type="text" name="pet_dambreed[]">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            {{-- 3 DAM/SIRE --}}
                            <div class="h-100 pe-5" style="min-width: 350px;">
                                <div class="col-12">
                                    <button class="btn btn-warning fw-bold btn-toggle-gen w-100 pb-0 my-3" type="button" data-gen="3">
                                        <h4>GEN 3</h4>
                                    </button>

                                    @for ($i = 1; $i <= 2; $i++)
                                        <div class="row ped-gen-div d-none mb-4 pt-2" style="border-left: 3px solid #000; border-top: 3px dotted #000;"  data-gen="3">

                                            {{-- SIRE --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-primary">SIRE</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirename_{{ $i }}" type="text" name="pet_sirename[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirebreed_{{ $i }}" type="text" name="pet_sirebreed[]">
                                                </div>
                                            </div>

                                            {{-- DAM --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-success">DAM</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_damname_{{ $i }}" type="text" name="pet_damname[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_dambreed_{{ $i }}" type="text" name="pet_dambreed[]">
                                                </div>
                                            </div>

                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- 4 DAM/SIRE --}}
                            <div class="h-100 pe-5" style="min-width: 350px;">
                                <div class="col-12">
                                    <button class="btn btn-warning fw-bold btn-toggle-gen w-100 pb-0 my-3" type="button" data-gen="4">
                                        <h4>GEN 4</h4>
                                    </button>

                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="row ped-gen-div d-none mb-4 pt-2" style="border-left: 3px solid #000; border-top: 3px dotted #000;"  data-gen="4">

                                            {{-- SIRE --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-primary">SIRE</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirename_{{ $i + 2 }}" type="text" name="pet_sirename[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirebreed_{{ $i + 2 }}" type="text" name="pet_sirebreed[]">
                                                </div>
                                            </div>

                                            {{-- DAM --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-success">DAM</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_damname_{{ $i + 2 }}" type="text" name="pet_damname[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_dambreed_{{ $i + 2 }}" type="text" name="pet_dambreed[]">
                                                </div>
                                            </div>

                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- 5 DAM/SIRE --}}
                            <div class="h-100 pe-5" style="min-width: 350px;">
                                <div class="col-12">
                                    <button class="btn btn-warning fw-bold btn-toggle-gen w-100 pb-0 my-3" type="button" data-gen="5">
                                        <h4>GEN 5</h4>
                                    </button>

                                    @for ($i = 1; $i <= 8; $i++)
                                        <div class="row ped-gen-div d-none mb-4 pt-2" style="border-left: 3px solid #000; border-top: 3px dotted #000;"  data-gen="5">

                                            {{-- SIRE --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-primary">SIRE</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirename_{{ $i + 2 + 4 }}" type="text" name="pet_sirename[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    SireBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_sirebreed_{{ $i + 2 + 4 }}" type="text" name="pet_sirebreed[]">
                                                </div>
                                            </div>

                                            {{-- DAM --}}
                                            <div class="row">
                                                <div class="col-auto">
                                                    <label class="rounded-pill bg-warning fw-bold px-2 py-1">#{{ $i }} <span class="text-success">DAM</span></label>
                                                </div>
                                                <div class="col">
                                                    <hr class="mt-3 mb-2 text-warning" style="height: 5px;">
                                                </div>
                                            </div>

                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamName:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_damname_{{ $i + 2 + 4 }}" type="text" name="pet_damname[]">
                                                </div>
                                            </div>
                                            <div class="col-12 py-1">
                                                <label class="form-label fw-bold">
                                                    DamBreed:
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control pedi_pet_dambreed_{{ $i + 2 + 4 }}" type="text" name="pet_dambreed[]">
                                                </div>
                                            </div>

                                        </div>
                                    @endfor
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer py-4 px-3">
                    <i>(Payment of PHP 300.00 is required. * amount is subject to change)</i>
                    <div class="col-auto p-1 border bg-warning">
                        <label class="form-label fw-bold text-light" for="generations">
                            Generations:
                        </label>
                        <select id="generations" class="form-control text-center" name="generations">
                            <option value="2" selected>2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-size-95-rem">
                        GENERATE PEDIGREE
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
