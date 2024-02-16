
<div class="w-100 pt-2 pb-2 mt-3 text-center">
    <h5>
        Rabbit Details
    </h5>
</div>

{{-- RABBIT INFO --}}
<div class="col-12 col-md-12 p-2">
    <div class="input-container">
        <input id="pet_petname" class="input-control" type="text" name="pet_petname" placeholder="*Pet Name">
    </div>
</div>
<div class="col-12 col-md-12 p-2">
    <div class="input-container">
        <input id="pet_microchip_no" class="input-control" type="text" name="pet_microchip_no" placeholder="Microchip Number">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_birthdate" class="input-control" type="date" name="pet_birthdate">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_age" class="input-control" type="number" min="0" name="pet_age" placeholder="Age (in months)" title="if unknown, please provide estimate.">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <select id="pet_gender" class="input-control" name="pet_gender">
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_breed" class="input-control" type="text" name="pet_breed" placeholder="*Breed">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_eyecolor" class="input-control" type="text" name="pet_eyecolor" placeholder="Eye Color">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_petcolor" class="input-control" type="text" name="pet_petcolor" placeholder="Pet Color">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_markings" class="input-control" type="text" name="pet_markings" placeholder="Markings">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_height" class="input-control" type="text" name="pet_height" placeholder="Height">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_weight" class="input-control" type="text" name="pet_weight" placeholder="Weight">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_location" class="input-control" type="text" name="pet_location" placeholder="*Location">
    </div>
</div>

{{-- --- --}}
<div class="col-12"></div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="image_btn btn btn-secondary w-100" type="button">Upload a photo of your rabbit</button>
        <input id="pet_image" class="image_input input-control d-none" type="file" name="pet_image">
        <img id="pet_image_preview" class="image_preview w-100 d-none">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="file_btn btn btn-secondary w-100" type="button">Other supporting documents</button>
        <input id="pet_supporting_documents" class="file_input input-control d-none" type="file" name="pet_supporting_documents">
    </div>
</div>


<div class="col-12"><hr></div>
{{-- VET INFO --}}
<div class="col-12 p-2">
    <div class="input-container">
        <input id="pet_vet_name" class="input-control" type="text" name="pet_vet_name" placeholder="Veterinarian or Clinics Name">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_vet_url" class="input-control" type="text" name="pet_vet_url" placeholder="Veterinarians Online Profile (URL/link)" title="FB URL or other social media account">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="file_btn btn btn-secondary w-100" type="button">Upload Your Rabbit's Veterinary Record (only when applicable)</button>
        <input id="pet_vet_record_documents" class="file_input input-control d-none" type="file" name="pet_vet_record_documents">
    </div>
</div>

<div class="col-12"><hr></div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_shelter" class="input-control" type="text" name="pet_shelter" placeholder="Rabbitry Information">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_shelter_url" class="input-control" type="text" name="pet_shelter_url" placeholder="Rabbitry's Online Profile (URL/link)" title="FB URL or other social media account">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_breeder" class="input-control" type="text" name="pet_breeder" placeholder="Breeder Information">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_breeder_url" class="input-control" type="text" name="pet_breeder_url" placeholder="Breeder Online Profile (URL/link)" title="FB URL or other social media account">
    </div>
</div>

<div class="col-12"><hr></div>
<div class="w-100 pt-2 pb-2 mt-1 text-center">
    <h5>
        Sire and Dam Information
    </h5>
    <small>(Leave blank if unknown)</small>
</div>

<div class="col-12 p-2">
    <div class="input-container">
        <input id="pet_sirename" class="input-control" type="text" name="pet_sirename" placeholder="Name of Sire">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="image_btn btn btn-secondary w-100" type="button">Upload Sire Image</button>
        <input id="pet_sire_image" class="image_input input-control d-none" type="file" name="pet_sire_image">
        <img id="pet_sire_image_preview" class="image_preview w-100 d-none">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="file_btn btn btn-secondary w-100" type="button">Other sire supporting documents</button>
        <input id="pet_sire_supporting_documents" class="file_input input-control d-none" type="file" name="pet_sire_supporting_documents">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_sire_breed" class="input-control" type="text" name="pet_sire_breed" placeholder="Breed">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_sireregno" class="input-control" type="text" name="pet_sireregno" placeholder="IAGD Reg No.">
    </div>
</div>

<div class="col-12"><hr></div>
<div class="col-12 p-2">
    <div class="input-container">
        <input id="pet_damname" class="input-control" type="text" name="pet_damname" placeholder="Name of Dam">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="image_btn btn btn-secondary w-100" type="button">Upload Dam Image</button>
        <input id="pet_dam_image" class="image_input input-control d-none" type="file" name="pet_dam_image">
        <img id="pet_dam_image_preview" class="image_preview w-100 d-none">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <button class="file_btn btn btn-secondary w-100" type="button">Other dam supporting documents</button>
        <input id="pet_dam_supporting_documents" class="file_input input-control d-none" type="file" name="pet_dam_supporting_documents">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_dam_breed" class="input-control" type="text" name="pet_dam_breed" placeholder="Breed">
    </div>
</div>
<div class="col-12 col-md-6 p-2">
    <div class="input-container">
        <input id="pet_damregno" class="input-control" type="text" name="pet_damregno" placeholder="IAGD Reg No.">
    </div>
</div>
