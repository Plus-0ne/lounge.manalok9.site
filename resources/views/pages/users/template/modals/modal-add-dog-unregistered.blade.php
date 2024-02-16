<form class="pet_add_form" action="{{ route('user.add_pet_unregistered') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="pet_type" value="dog">
    <div class="modal fade" id="add_dog_unregistered" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-4 px-3">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Register Dog
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
                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" list="dog_breeds" name="pet_breed" placeholder="*" required>
                            </div>
                            <div class="col-12 col-lg-6 py-1">
                                <label class="form-label">
                                    <i class="mdi mdi-eye mdi-24px pe-1"></i> Eye Color:
                                </label>
                                <select class="form-control" name="pet_eyecolor">
                                    <option value="">Select Eye Color</option>
                                    <option value="Black"> Black </option>
                                    <option value="Brown"> Brown </option>
                                    <option value="Blue"> Blue </option>
                                    <option value="Red"> Red </option>
                                    <option value="Hazel"> Hazel </option>
                                    <option value="Gray"> Gray </option>
                                    <option value="Green"> Green </option>
                                    <option value="Others"> Others </option>
                                </select>
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
                                <input class="form-control" type="text" name="pet_location">
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
                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Upload a photo of your dog:
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
                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Upload your dog's veterinary record (only when applicable):
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
                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_sire_breed" list="dog_breeds">
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
                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                </label>
                                <input class="form-control" type="text" name="pet_dam_breed" list="dog_breeds">
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <label class="form-label">
                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                </label>
                                <input class="form-control" type="text" name="pet_damregno">
                            </div> --}}


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

<datalist id="dog_breeds">
    <option value="Affenpinscher"> Affenpinscher </option>
    <option value="Afghan Hound"> Afghan Hound </option>
    <option value="Aidi"> Aidi </option>
    <option value="Airedale Terrier"> Airedale Terrier </option>
    <option value="Akbash"> Akbash </option>
    <option value="Akita"> Akita </option>
    <option value="Alano Espa"> Alano Espa </option>
    <option value="Alapaha Blue Blood Bulldog"> Alapaha Blue Blood Bulldog </option>
    <option value="Alaskan Husky"> Alaskan Husky </option>
    <option value="Alaskan Klee Kai"> Alaskan Klee Kai </option>
    <option value="Alaskan Malamute"> Alaskan Malamute </option>
    <option value="Alopekis"> Alopekis </option>
    <option value="Alpine Dachsbracke"> Alpine Dachsbracke </option>
    <option value="American Bulldog"> American Bulldog </option>
    <option value="American Bully"> American Bully </option>
    <option value="American Cocker Spaniel"> American Cocker Spaniel </option>
    <option value="American English Coonhound"> American English Coonhound </option>
    <option value="American Eskimo Dog"> American Eskimo Dog </option>
    <option value="American Foxhound"> American Foxhound </option>
    <option value="American Hairless Terrier"> American Hairless Terrier </option>
    <option value="American Pit Bull Terrier"> American Pit Bull Terrier </option>
    <option value="American Staffordshire Terrier"> American Staffordshire Terrier </option>
    <option value="American Water Spaniel"> American Water Spaniel </option>
    <option value="Anatolian Shepherd Dog"> Anatolian Shepherd Dog </option>
    <option value="Andalusian Hound"> Andalusian Hound </option>
    <option value="Anglo-Fran"> Anglo-Fran </option>
    <option value="Appenzeller Sennenhund"> Appenzeller Sennenhund </option>
    <option value="Ariegeois"> Ariegeois </option>
    <option value="Armant"> Armant </option>
    <option value="Armenian Gampr Dog"> Armenian Gampr Dog </option>
    <option value="Artois Hound"> Artois Hound </option>
    <option value="Australian Cattle Dog"> Australian Cattle Dog </option>
    <option value="Australian Kelpie"> Australian Kelpie </option>
    <option value="Australian Shepherd"> Australian Shepherd </option>
    <option value="Australian Stumpy Tail Cattle Dog"> Australian Stumpy Tail Cattle Dog </option>
    <option value="Australian Terrier"> Australian Terrier </option>
    <option value="Austrian Black and Tan Hound"> Austrian Black and Tan Hound </option>
    <option value="Austrian Pinscher"> Austrian Pinscher </option>
    <option value="Azawakh"> Azawakh </option>
    <option value="Arctic Spitz"> Arctic Spitz </option>
    <option value="American Bully"> American Bully </option>
    <option value="Belgian shepherd"> Belgian shepherd </option>
    <option value="Belgian Malinois"> Belgian Malinois </option>
    <option value="Belgian Tervuren"> Belgian Tervuren </option>
    <option value="Bouvier Des Flandres"> Bouvier Des Flandres </option>
    <option value="Brussels Griffon"> Brussels Griffon </option>
    <option value="Schipperke"> Schipperke </option>
    <option value="Belgian Sheepdog"> Belgian Sheepdog </option>
    <option value="Belgian Groenendael"> Belgian Groenendael </option>
    <option value="Bakharwal Dog"> Bakharwal Dog </option>
    <option value="Banjara Hound"> Banjara Hound </option>
    <option value="Barbado Da Terceira"> Barbado Da Terceira </option>
    <option value="Barbet"> Barbet </option>
    <option value="Basenji"> Basenji </option>
    <option value="Basque Shepherd Dog"> Basque Shepherd Dog </option>
    <option value="Basset Normand"> Basset Normand </option>
    <option value="Basset Bleu de Gascogne"> Basset Bleu de Gascogne </option>
    <option value="Basset Fauve de Bretagne"> Basset Fauve de Bretagne </option>
    <option value="Basset Hound"> Basset Hound </option>
    <option value="Bavarian Mountain Hound"> Bavarian Mountain Hound </option>
    <option value="Beagle"> Beagle </option>
    <option value="Beagle-Harrier"> Beagle-Harrier </option>
    <option value="Belgian Shepherd"> Belgian Shepherd </option>
    <option value="Bearded Collie"> Bearded Collie </option>
    <option value="Beauceron"> Beauceron </option>
    <option value="Bedlington Terrier"> Bedlington Terrier </option>
    <option value="Bergamasco Shepherd"> Bergamasco Shepherd </option>
    <option value="Berger Picard"> Berger Picard </option>
    <option value="Bernese Mountain Dog"> Bernese Mountain Dog </option>
    <option value="Bhotia"> Bhotia </option>
    <option value="Bichon Fris"> Bichon Fris </option>
    <option value="Billy"> Billy </option>
    <option value="Black and Tan Coonhound"> Black and Tan Coonhound </option>
    <option value="Black Norwegian Elkhound"> Black Norwegian Elkhound </option>
    <option value="Black Russian Terrier"> Black Russian Terrier </option>
    <option value="Black Mouth Cur"> Black Mouth Cur </option>
    <option value="Bloodhound"> Bloodhound </option>
    <option value="Blue Lacy"> Blue Lacy </option>
    <option value="Blue Picardy Spaniel"> Blue Picardy Spaniel </option>
    <option value="Bluetick Coonhound"> Bluetick Coonhound </option>
    <option value="Boerboel"> Boerboel </option>
    <option value="Bohemian Shepherd"> Bohemian Shepherd </option>
    <option value="Bolognese"> Bolognese </option>
    <option value="Border Collie"> Border Collie </option>
    <option value="Border Terrier"> Border Terrier </option>
    <option value="Borzoi"> Borzoi </option>
    <option value="Bosnian Coarse-haired Hound"> Bosnian Coarse-haired Hound </option>
    <option value="Boston Terrier"> Boston Terrier </option>
    <option value="Bouvier des Ardennes"> Bouvier des Ardennes </option>
    <option value="Bouvier des Flandres"> Bouvier des Flandres </option>
    <option value="Boxer"> Boxer </option>
    <option value="Boykin Spaniel"> Boykin Spaniel </option>
    <option value="Bracco Italiano"> Bracco Italiano </option>
    <option value="Braque dAuvergne"> Braque dAuvergne </option>
    <option value="Braque de lArige"> Braque de lArige </option>
    <option value="Braque du Bourbonnais"> Braque du Bourbonnais </option>
    <option value="Braque Francais"> Braque Francais </option>
    <option value="Braque Saint-Germain"> Braque Saint-Germain </option>
    <option value="Briard"> Briard </option>
    <option value="Briquet Griffon Venden"> Briquet Griffon Venden </option>
    <option value="Brittany"> Brittany </option>
    <option value="Broholmer"> Broholmer </option>
    <option value="Bruno Jura Hound"> Bruno Jura Hound </option>
    <option value="Brussels Griffon"> Brussels Griffon </option>
    <option value="Bucovina Shepherd Dog"> Bucovina Shepherd Dog </option>
    <option value="Bull Arab"> Bull Arab </option>
    <option value="Bull Terrier"> Bull Terrier </option>
    <option value="Bulldog"> Bulldog </option>
    <option value="Bullmastiff"> Bullmastiff </option>
    <option value="Bully Kutta"> Bully Kutta </option>
    <option value="Burgos Pointer"> Burgos Pointer </option>
    <option value="Cairn Terrier"> Cairn Terrier </option>
    <option value="Campeiro Bulldog"> Campeiro Bulldog </option>
    <option value="Canaan Dog"> Canaan Dog </option>
    <option value="Canadian Eskimo Dog"> Canadian Eskimo Dog </option>
    <option value="Cane Corso"> Cane Corso </option>
    <option value="Cane di Oropa"> Cane di Oropa </option>
    <option value="Cane Paratore"> Cane Paratore </option>
    <option value="Cantabrian Water Dog"> Cantabrian Water Dog </option>
    <option value="Can de Chira"> Can de Chira </option>
    <option value="C√£o da Serra de Aires"> C√£o da Serra de Aires </option>
    <option value="C√£o de Castro Laboreiro"> C√£o de Castro Laboreiro </option>
    <option value="C√£o de Gado Transmontano"> C√£o de Gado Transmontano </option>
    <option value="C√£o Fila de S√£o Miguel"> C√£o Fila de S√£o Miguel </option>
    <option value="Cardigan Welsh Corgi"> Cardigan Welsh Corgi </option>
    <option value="Carea Castellano Manchego"> Carea Castellano Manchego </option>
    <option value="Carea Leons"> Carea Leons </option>
    <option value="Carolina Dog"> Carolina Dog </option>
    <option value="Carpathian Shepherd Dog"> Carpathian Shepherd Dog </option>
    <option value="Catahoula Leopard Dog"> Catahoula Leopard Dog </option>
    <option value="Catalan Sheepdog"> Catalan Sheepdog </option>
    <option value="Caucasian Shepherd Dog"> Caucasian Shepherd Dog </option>
    <option value="Cavalier King Charles Spaniel"> Cavalier King Charles Spaniel </option>
    <option value="Central Asian Shepherd Dog"> Central Asian Shepherd Dog </option>
    <option value="Cesky Fousek"> Cesky Fousek </option>
    <option value="Cesky Terrier"> Cesky Terrier </option>
    <option value="Chesapeake Bay Retriever"> Chesapeake Bay Retriever </option>
    <option value="Chien Francais Blanc et Noir"> Chien Francais Blanc et Noir </option>
    <option value="Chien Francais Blanc et Orange"> Chien Francais Blanc et Orange </option>
    <option value="Chien Francais Tricolore"> Chien Francais Tricolore </option>
    <option value="Chihuahua"> Chihuahua </option>
    <option value="Chilean Terrier"> Chilean Terrier </option>
    <option value="Chinese Chongqing Dog"> Chinese Chongqing Dog </option>
    <option value="Chinese Crested Dog"> Chinese Crested Dog </option>
    <option value="Chinook"> Chinook </option>
    <option value="Chippiparai"> Chippiparai </option>
    <option value="Chongqing Dog"> Chongqing Dog </option>
    <option value="Chow Chow"> Chow Chow </option>
    <option value="Cimarren Uruguayo"> Cimarren Uruguayo </option>
    <option value="Cirneco dellEtna"> Cirneco dellEtna </option>
    <option value="Clumber Spaniel"> Clumber Spaniel </option>
    <option value="Combai"> Combai </option>
    <option value="Colombian Fino hound"> Colombian Fino hound </option>
    <option value="Coton de Tulear"> Coton de Tulear </option>
    <option value="Cretan Hound"> Cretan Hound </option>
    <option value="Croatian Sheepdog"> Croatian Sheepdog </option>
    <option value="Curly-Coated Retriever"> Curly-Coated Retriever </option>
    <option value="Cursinu"> Cursinu </option>
    <option value="Czechoslovakian Wolfdog"> Czechoslovakian Wolfdog </option>
    <option value="Dachshund"> Dachshund </option>
    <option value="Dalmatian"> Dalmatian </option>
    <option value="Dandie Dinmont Terrier"> Dandie Dinmont Terrier </option>
    <option value="Danish-Swedish Farmdog"> Danish-Swedish Farmdog </option>
    <option value="Denmark Feist"> Denmark Feist </option>
    <option value="Dingo (sometimes considered a breed of, and sometimes a species separate from, the domestic dog)"> Dingo (sometimes considered a breed of, and sometimes a species separate from, the domestic dog) </option>
    <option value="Doberman Pinscher"> Doberman Pinscher </option>
    <option value="Dogo Argentino"> Dogo Argentino </option>
    <option value="Dogo Guatemalteco"> Dogo Guatemalteco </option>
    <option value="Dogo Sardesco"> Dogo Sardesco </option>
    <option value="Dogue Brasileiro"> Dogue Brasileiro </option>
    <option value="Dogue de Bordeaux"> Dogue de Bordeaux </option>
    <option value="Drentse Patrijshond"> Drentse Patrijshond </option>
    <option value="Drever"> Drever </option>
    <option value="Dunker"> Dunker </option>
    <option value="Dutch Shepherd"> Dutch Shepherd </option>
    <option value="Dutch Smoushond"> Dutch Smoushond </option>
    <option value="East Siberian Laika"> East Siberian Laika </option>
    <option value="East European Shepherd"> East European Shepherd </option>
    <option value="English Cocker Spaniel"> English Cocker Spaniel </option>
    <option value="English Foxhound"> English Foxhound </option>
    <option value="English Mastiff"> English Mastiff </option>
    <option value="English Setter"> English Setter </option>
    <option value="English Shepherd"> English Shepherd </option>
    <option value="English Springer Spaniel"> English Springer Spaniel </option>
    <option value="English Toy Terrier (Black &amp; Tan)"> English Toy Terrier (Black &amp; Tan) </option>
    <option value="Entlebucher Mountain Dog"> Entlebucher Mountain Dog </option>
    <option value="Estonian Hound"> Estonian Hound </option>
    <option value="Estrela Mountain Dog"> Estrela Mountain Dog </option>
    <option value="Eurasier"> Eurasier </option>
    <option value="Field Spaniel"> Field Spaniel </option>
    <option value="Fila Brasileiro"> Fila Brasileiro </option>
    <option value="Finnish Hound"> Finnish Hound </option>
    <option value="Finnish Lapphund"> Finnish Lapphund </option>
    <option value="Finnish Spitz"> Finnish Spitz </option>
    <option value="Flat-Coated Retriever"> Flat-Coated Retriever </option>
    <option value="French Bulldog"> French Bulldog </option>
    <option value="French Spaniel"> French Spaniel </option>
    <option value="Galgo Español"> Galgo Español </option>
    <option value="Galician Shepherd Dog"> Galician Shepherd Dog </option>
    <option value="Garafian Shepherd"> Garafian Shepherd </option>
    <option value="Gascon Saintongeois"> Gascon Saintongeois </option>
    <option value="Georgian Shepherd"> Georgian Shepherd </option>
    <option value="German Hound"> German Hound </option>
    <option value="German Longhaired Pointer"> German Longhaired Pointer </option>
    <option value="German Pinscher"> German Pinscher </option>
    <option value="German Roughhaired Pointer"> German Roughhaired Pointer </option>
    <option value="German Shepherd Dog"> German Shepherd Dog </option>
    <option value="German Shorthaired Pointer"> German Shorthaired Pointer </option>
    <option value="German Spaniel"> German Spaniel </option>
    <option value="German Spitz"> German Spitz </option>
    <option value="German Wirehaired Pointer"> German Wirehaired Pointer </option>
    <option value="Giant Schnauzer"> Giant Schnauzer </option>
    <option value="Glen of Imaal Terrier"> Glen of Imaal Terrier </option>
    <option value="Golden Retriever"> Golden Retriever </option>
    <option value="Gonczy Polski"> Gonczy Polski </option>
    <option value="Gordon Setter"> Gordon Setter </option>
    <option value="Gos Rater Valencia"> Gos Rater Valencia </option>
    <option value="Grand Anglo-Francais Blanc et Noir"> Grand Anglo-Francais Blanc et Noir </option>
    <option value="Grand Anglo-Francais Blanc et Orange"> Grand Anglo-Francais Blanc et Orange </option>
    <option value="Grand Anglo-Francais Tricolore"> Grand Anglo-Francais Tricolore </option>
    <option value="Grand Basset Griffon Vendeen"> Grand Basset Griffon Vendeen </option>
    <option value="Grand Bleu de Gascogne"> Grand Bleu de Gascogne </option>
    <option value="Grand Griffon Vendeen"> Grand Griffon Vendeen </option>
    <option value="Great Dane"> Great Dane </option>
    <option value="Greater Swiss Mountain Dog"> Greater Swiss Mountain Dog </option>
    <option value="Greek Harehound"> Greek Harehound </option>
    <option value="Greek Shepherd"> Greek Shepherd </option>
    <option value="Greenland Dog"> Greenland Dog </option>
    <option value="Greyhound"> Greyhound </option>
    <option value="Griffon Bleu de Gascogne"> Griffon Bleu de Gascogne </option>
    <option value="Griffon Fauve de Bretagne"> Griffon Fauve de Bretagne </option>
    <option value="Griffon Nivernais"> Griffon Nivernais </option>
    <option value="Gull Dong"> Gull Dong </option>
    <option value="Gull Terrier"> Gull Terrier </option>
    <option value="Hallefors Elkhound"> Hallefors Elkhound </option>
    <option value="Hamiltonstovare"> Hamiltonstovare </option>
    <option value="Hanover Hound"> Hanover Hound </option>
    <option value="Harrier"> Harrier </option>
    <option value="Havanese"> Havanese </option>
    <option value="Hierran Wolfdog"> Hierran Wolfdog </option>
    <option value="Hokkaido"> Hokkaido </option>
    <option value="Hortaya Borzaya"> Hortaya Borzaya </option>
    <option value="Hovawart"> Hovawart </option>
    <option value="Huntaway"> Huntaway </option>
    <option value="Hygen Hound"> Hygen Hound </option>
    <option value="Ibizan Hound"> Ibizan Hound </option>
    <option value="Icelandic Sheepdog"> Icelandic Sheepdog </option>
    <option value="Indian Pariah dog"> Indian Pariah dog </option>
    <option value="Indian Spitz"> Indian Spitz </option>
    <option value="Irish Red and White Setter"> Irish Red and White Setter </option>
    <option value="Irish Setter"> Irish Setter </option>
    <option value="Irish Terrier"> Irish Terrier </option>
    <option value="Irish Water Spaniel"> Irish Water Spaniel </option>
    <option value="Irish Wolfhound"> Irish Wolfhound </option>
    <option value="Istrian Coarse-haired Hound"> Istrian Coarse-haired Hound </option>
    <option value="Istrian Shorthaired Hound"> Istrian Shorthaired Hound </option>
    <option value="Italian Greyhound"> Italian Greyhound </option>
    <option value="Jack Russell Terrier"> Jack Russell Terrier </option>
    <option value="Jagdterrier"> Jagdterrier </option>
    <option value="Japanese Chin"> Japanese Chin </option>
    <option value="Japanese Spitz"> Japanese Spitz </option>
    <option value="Japanese Terrier"> Japanese Terrier </option>
    <option value="Jindo"> Jindo </option>
    <option value="Jonangi"> Jonangi </option>
    <option value="Ibizan Hound"> Ibizan Hound </option>
    <option value="Icelandic Sheepdog"> Icelandic Sheepdog </option>
    <option value="Indian Pariah dog"> Indian Pariah dog </option>
    <option value="Indian Spitz"> Indian Spitz </option>
    <option value="Irish Red and White Setter"> Irish Red and White Setter </option>
    <option value="Irish Setter"> Irish Setter </option>
    <option value="Irish Terrier"> Irish Terrier </option>
    <option value="Irish Water Spaniel"> Irish Water Spaniel </option>
    <option value="Irish Wolfhound"> Irish Wolfhound </option>
    <option value="Istrian Coarse-haired Hound"> Istrian Coarse-haired Hound </option>
    <option value="Istrian Shorthaired Hound"> Istrian Shorthaired Hound </option>
    <option value="Italian Greyhound"> Italian Greyhound </option>
    <option value="Jack Russell Terrier"> Jack Russell Terrier </option>
    <option value="Jagdterrier"> Jagdterrier </option>
    <option value="Japanese Chin"> Japanese Chin </option>
    <option value="Japanese Spitz"> Japanese Spitz </option>
    <option value="Japanese Terrier"> Japanese Terrier </option>
    <option value="Jindo"> Jindo </option>
    <option value="Jonangi"> Jonangi </option>
    <option value="Kai Ken"> Kai Ken </option>
    <option value="Kaikadi"> Kaikadi </option>
    <option value="Kangal Shepherd Dog"> Kangal Shepherd Dog </option>
    <option value="Kanni"> Kanni </option>
    <option value="Karakachan Dog"> Karakachan Dog </option>
    <option value="Karelian Bear Dog"> Karelian Bear Dog </option>
    <option value="Kars"> Kars </option>
    <option value="Karst Shepherd"> Karst Shepherd </option>
    <option value="Keeshond"> Keeshond </option>
    <option value="Kerry Beagle"> Kerry Beagle </option>
    <option value="Kerry Blue Terrier"> Kerry Blue Terrier </option>
    <option value="King Charles Spaniel"> King Charles Spaniel </option>
    <option value="King Shepherd"> King Shepherd </option>
    <option value="Kintamani"> Kintamani </option>
    <option value="Kishu"> Kishu </option>
    <option value="Kokoni"> Kokoni </option>
    <option value="Komondor"> Komondor </option>
    <option value="Kooikerhondje"> Kooikerhondje </option>
    <option value="Koolie"> Koolie </option>
    <option value="Koyun dog"> Koyun dog </option>
    <option value="Kromfohrlander"> Kromfohrlander </option>
    <option value="Kuchi"> Kuchi </option>
    <option value="Kuvasz"> Kuvasz </option>
    <option value="Labrador Retriever"> Labrador Retriever </option>
    <option value="Lagotto Romagnolo"> Lagotto Romagnolo </option>
    <option value="Lakeland Terrier"> Lakeland Terrier </option>
    <option value="Lancashire Heeler"> Lancashire Heeler </option>
    <option value="Landseer"> Landseer </option>
    <option value="Lapponian Herder"> Lapponian Herder </option>
    <option value="Large Munsterlander"> Large Munsterlander </option>
    <option value="Leonberger"> Leonberger </option>
    <option value="Levriero Sardo"> Levriero Sardo </option>
    <option value="Lhasa Apso"> Lhasa Apso </option>
    <option value="Lithuanian Hound"> Lithuanian Hound </option>
    <option value="Lowchen"> Lowchen </option>
    <option value="Lupo Italiano"> Lupo Italiano </option>
    <option value="Mackenzie River Husky"> Mackenzie River Husky </option>
    <option value="Magyar Agar"> Magyar Agar </option>
    <option value="Mahratta Greyhound"> Mahratta Greyhound </option>
    <option value="Maltese"> Maltese </option>
    <option value="Manchester Terrier"> Manchester Terrier </option>
    <option value="Maremmano-Abruzzese Sheepdog"> Maremmano-Abruzzese Sheepdog </option>
    <option value="McNab Dog"> McNab Dog </option>
    <option value="Miniature American Shepherd"> Miniature American Shepherd </option>
    <option value="Miniature Bull Terrier"> Miniature Bull Terrier </option>
    <option value="Miniature Fox Terrier"> Miniature Fox Terrier </option>
    <option value="Miniature Pinscher"> Miniature Pinscher </option>
    <option value="Miniature Schnauzer"> Miniature Schnauzer </option>
    <option value="Molossus of Epirus"> Molossus of Epirus </option>
    <option value="Montenegrin Mountain Hound"> Montenegrin Mountain Hound </option>
    <option value="Mountain Cur"> Mountain Cur </option>
    <option value="Mountain Feist"> Mountain Feist </option>
    <option value="Mucuchies"> Mucuchies </option>
    <option value="Mudhol Hound"> Mudhol Hound </option>
    <option value="Mudi"> Mudi </option>
    <option value="Neapolitan Mastiff"> Neapolitan Mastiff </option>
    <option value="New Guinea Singing dog"> New Guinea Singing dog </option>
    <option value="New Zealand Heading Dog"> New Zealand Heading Dog </option>
    <option value="Newfoundland"> Newfoundland </option>
    <option value="Norfolk Terrier"> Norfolk Terrier </option>
    <option value="Norrbottenspets"> Norrbottenspets </option>
    <option value="Northern Inuit Dog"> Northern Inuit Dog </option>
    <option value="Norwegian Buhund"> Norwegian Buhund </option>
    <option value="Norwegian Elkhound"> Norwegian Elkhound </option>
    <option value="Norwegian Lundehund"> Norwegian Lundehund </option>
    <option value="Norwich Terrier"> Norwich Terrier </option>
    <option value="Nova Scotia Duck Tolling Retriever"> Nova Scotia Duck Tolling Retriever </option>
    <option value="Old Croatian Sighthound"> Old Croatian Sighthound </option>
    <option value="Old Danish Pointer"> Old Danish Pointer </option>
    <option value="Old English Sheepdog"> Old English Sheepdog </option>
    <option value="Old English Terrier"> Old English Terrier </option>
    <option value="Olde English Bulldogge"> Olde English Bulldogge </option>
    <option value="Original Fila Brasileiro"> Original Fila Brasileiro </option>
    <option value="Otterhound"> Otterhound </option>
    <option value="Philippine Aso"> Philippine Aso </option>
    <option value="Pachon Navarro"> Pachon Navarro </option>
    <option value="Pampas Deerhound"> Pampas Deerhound </option>
    <option value="Paisley Terrier"> Paisley Terrier </option>
    <option value="Papillon"> Papillon </option>
    <option value="Parson Russell Terrier"> Parson Russell Terrier </option>
    <option value="Pastore della Lessinia e del Lagorai"> Pastore della Lessinia e del Lagorai </option>
    <option value="Patagonian Sheepdog"> Patagonian Sheepdog </option>
    <option value="Patterdale Terrier"> Patterdale Terrier </option>
    <option value="Pekingese"> Pekingese </option>
    <option value="Pembroke Welsh Corgi"> Pembroke Welsh Corgi </option>
    <option value="Perro Majorero"> Perro Majorero </option>
    <option value="Perro de Pastor Mallorquin"> Perro de Pastor Mallorquin </option>
    <option value="Perro de Presa Canario"> Perro de Presa Canario </option>
    <option value="Perro de Presa Mallorquin"> Perro de Presa Mallorquin </option>
    <option value="Peruvian Inca Orchid"> Peruvian Inca Orchid </option>
    <option value="Petit Basset Griffon Vendeen"> Petit Basset Griffon Vendeen </option>
    <option value="Petit Bleu de Gascogne"> Petit Bleu de Gascogne </option>
    <option value="Phalene"> Phalene </option>
    <option value="Pharaoh Hound"> Pharaoh Hound </option>
    <option value="Philippine Aso"> Philippine Aso </option>
    <option value="Phu Quoc Ridgeback"> Phu Quoc Ridgeback </option>
    <option value="Picardy Spaniel"> Picardy Spaniel </option>
    <option value="Plummer Terrier"> Plummer Terrier </option>
    <option value="Plott Hound"> Plott Hound </option>
    <option value="Podenco Canario"> Podenco Canario </option>
    <option value="Podenco Valenciano"> Podenco Valenciano </option>
    <option value="Pointer"> Pointer </option>
    <option value="Poitevin"> Poitevin </option>
    <option value="Polish Greyhound"> Polish Greyhound </option>
    <option value="Polish Hound"> Polish Hound </option>
    <option value="Polish Lowland Sheepdog"> Polish Lowland Sheepdog </option>
    <option value="Polish Tatra Sheepdog"> Polish Tatra Sheepdog </option>
    <option value="Pomeranian"> Pomeranian </option>
    <option value="Pont-Audemer Spaniel"> Pont-Audemer Spaniel </option>
    <option value="Poodle"> Poodle </option>
    <option value="Porcelaine"> Porcelaine </option>
    <option value="Portuguese Podengo"> Portuguese Podengo </option>
    <option value="Portuguese Pointer"> Portuguese Pointer </option>
    <option value="Portuguese Water Dog"> Portuguese Water Dog </option>
    <option value="Posavac Hound"> Posavac Hound </option>
    <option value="Prazksy Krysarik (Prague Ratter)"> Prazksy Krysarik (Prague Ratter) </option>
    <option value="Pshdar dog"> Pshdar dog </option>
    <option value="Pudelpointer"> Pudelpointer </option>
    <option value="Pug"> Pug </option>
    <option value="Puli"> Puli </option>
    <option value="Pumi"> Pumi </option>
    <option value="Pungsan Dog"> Pungsan Dog </option>
    <option value="Pyrenean Mastiff"> Pyrenean Mastiff </option>
    <option value="Pyrenean Mountain Dog"> Pyrenean Mountain Dog </option>
    <option value="Pyrenean Sheepdog"> Pyrenean Sheepdog </option>
    <option value="Rafeiro do Alentejo"> Rafeiro do Alentejo </option>
    <option value="Rajapalayam"> Rajapalayam </option>
    <option value="Rampur Greyhound"> Rampur Greyhound </option>
    <option value="Rat Terrier"> Rat Terrier </option>
    <option value="Ratonero Bodeguero Andaluz"> Ratonero Bodeguero Andaluz </option>
    <option value="Ratonero Mallorquin"> Ratonero Mallorquin </option>
    <option value="Ratonero Murciano de Huerta"> Ratonero Murciano de Huerta </option>
    <option value="Ratonero Valenciano"> Ratonero Valenciano </option>
    <option value="Redbone Coonhound"> Redbone Coonhound </option>
    <option value="Rhodesian Ridgeback"> Rhodesian Ridgeback </option>
    <option value="Romanian Mioritic Shepherd Dog"> Romanian Mioritic Shepherd Dog </option>
    <option value="Romanian Raven Shepherd Dog"> Romanian Raven Shepherd Dog </option>
    <option value="Rottweiler"> Rottweiler </option>
    <option value="Rough Collie"> Rough Collie </option>
    <option value="Russian Spaniel"> Russian Spaniel </option>
    <option value="Russian Toy"> Russian Toy </option>
    <option value="Russo-European Laika"> Russo-European Laika </option>
    <option value="Russell Terrier"> Russell Terrier </option>
    <option value="Superdog"> Superdog </option>
    <option value="Saarloos Wolfdog"> Saarloos Wolfdog </option>
    <option value="Sabueso Español"> Sabueso Español </option>
    <option value="Saint Bernard"> Saint Bernard </option>
    <option value="Saint Hubert Jura Hound"> Saint Hubert Jura Hound </option>
    <option value="Saint-Usuge Spaniel"> Saint-Usuge Spaniel </option>
    <option value="Saluki"> Saluki </option>
    <option value="Samoyed"> Samoyed </option>
    <option value="Sapsali"> Sapsali </option>
    <option value="Sarabi Dog"> Sarabi Dog </option>
    <option value="Sarplaninac"> Sarplaninac </option>
    <option value="Schapendoes"> Schapendoes </option>
    <option value="Schillerstovare"> Schillerstovare </option>
    <option value="Schipperke"> Schipperke </option>
    <option value="Schweizer Laufhund"> Schweizer Laufhund </option>
    <option value="Schweizerischer Niederlaufhund"> Schweizerischer Niederlaufhund </option>
    <option value="Scottish Deerhound"> Scottish Deerhound </option>
    <option value="Scottish Terrier"> Scottish Terrier </option>
    <option value="Sealyham Terrier"> Sealyham Terrier </option>
    <option value="Segugio dellAppennino"> Segugio dellAppennino </option>
    <option value="Segugio Italiano"> Segugio Italiano </option>
    <option value="Segugio Maremmano"> Segugio Maremmano </option>
    <option value="Seppala Siberian Sleddog"> Seppala Siberian Sleddog </option>
    <option value="Serbian Hound"> Serbian Hound </option>
    <option value="Serbian Tricolour Hound"> Serbian Tricolour Hound </option>
    <option value="Serrano Bulldog"> Serrano Bulldog </option>
    <option value="Shar Pei"> Shar Pei </option>
    <option value="Shetland Sheepdog"> Shetland Sheepdog </option>
    <option value="Shiba Inu"> Shiba Inu </option>
    <option value="Shih Tzu"> Shih Tzu </option>
    <option value="Shikoku"> Shikoku </option>
    <option value="Shiloh Shepherd"> Shiloh Shepherd </option>
    <option value="Siberian Husky"> Siberian Husky </option>
    <option value="Silken Windhound"> Silken Windhound </option>
    <option value="Silky Terrier"> Silky Terrier </option>
    <option value="Sinhala Hound"> Sinhala Hound </option>
    <option value="Skye Terrier"> Skye Terrier </option>
    <option value="Sloughi"> Sloughi </option>
    <option value="Slovakian Wirehaired Pointer"> Slovakian Wirehaired Pointer </option>
    <option value="Slovenski Cuvac"> Slovenski Cuvac </option>
    <option value="Slovenski Kopov"> Slovenski Kopov </option>
    <option value="Smaland-Stovare"> Smaland-Stovare </option>
    <option value="Small Greek Domestic Dog"> Small Greek Domestic Dog </option>
    <option value="Small Munsterlander"> Small Munsterlander </option>
    <option value="Smooth Collie"> Smooth Collie </option>
    <option value="Smooth Fox Terrier"> Smooth Fox Terrier </option>
    <option value="Soft-Coated Wheaten Terrier"> Soft-Coated Wheaten Terrier </option>
    <option value="South Russian Ovcharka"> South Russian Ovcharka </option>
    <option value="Spanish Mastiff"> Spanish Mastiff </option>
    <option value="Spanish Water Dog"> Spanish Water Dog </option>
    <option value="Spinone Italiano"> Spinone Italiano </option>
    <option value="Sporting Lucas Terrier"> Sporting Lucas Terrier </option>
    <option value="Sardinian Shepherd Dog"> Sardinian Shepherd Dog </option>
    <option value="Stabyhoun"> Stabyhoun </option>
    <option value="Staffordshire Bull Terrier"> Staffordshire Bull Terrier </option>
    <option value="Standard Schnauzer"> Standard Schnauzer </option>
    <option value="Stephens Stock"> Stephens Stock </option>
    <option value="Styrian Coarse-haired Hound"> Styrian Coarse-haired Hound </option>
    <option value="Superdog"> Superdog </option>
    <option value="Sussex Spaniel"> Sussex Spaniel </option>
    <option value="Swedish Elkhound"> Swedish Elkhound </option>
    <option value="Swedish Lapphund"> Swedish Lapphund </option>
    <option value="Swedish Vallhund"> Swedish Vallhund </option>
    <option value="Swedish White Elkhound"> Swedish White Elkhound </option>
    <option value="Taigan"> Taigan </option>
    <option value="Taiwan Dog"> Taiwan Dog </option>
    <option value="Tamaskan Dog"> Tamaskan Dog </option>
    <option value="Teddy Roosevelt Terrier"> Teddy Roosevelt Terrier </option>
    <option value="Telomian"> Telomian </option>
    <option value="Tenterfield Terrier"> Tenterfield Terrier </option>
    <option value="Terrier Brasileiro"> Terrier Brasileiro </option>
    <option value="Thai Bangkaew Dog"> Thai Bangkaew Dog </option>
    <option value="Thai Ridgeback"> Thai Ridgeback </option>
    <option value="Tibetan Mastiff"> Tibetan Mastiff </option>
    <option value="Tibetan Spaniel"> Tibetan Spaniel </option>
    <option value="Tibetan Terrier"> Tibetan Terrier </option>
    <option value="Tornjak"> Tornjak </option>
    <option value="Tosa"> Tosa </option>
    <option value="Toy Fox Terrier"> Toy Fox Terrier </option>
    <option value="Toy Manchester Terrier"> Toy Manchester Terrier </option>
    <option value="Transylvanian Hound"> Transylvanian Hound </option>
    <option value="Treeing Cur"> Treeing Cur </option>
    <option value="Treeing Feist"> Treeing Feist </option>
    <option value="Treeing Tennessee Brindle"> Treeing Tennessee Brindle </option>
    <option value="Treeing Walker Coonhound"> Treeing Walker Coonhound </option>
    <option value="Trigg Hound"> Trigg Hound </option>
    <option value="Tyrolean Hound"> Tyrolean Hound </option>
    <option value="Vikhan"> Vikhan </option>
    <option value="Villano de Las Encartaciones"> Villano de Las Encartaciones </option>
    <option value="Villanuco de Las Encartaciones"> Villanuco de Las Encartaciones </option>
    <option value="Vizsla"> Vizsla </option>
    <option value="Volpino Italiano"> Volpino Italiano </option>
    <option value="Welsh Sheepdog"> Welsh Sheepdog </option>
    <option value="Welsh Springer Spaniel"> Welsh Springer Spaniel </option>
    <option value="Welsh Terrier"> Welsh Terrier </option>
    <option value="West Highland White Terrier"> West Highland White Terrier </option>
    <option value="West Siberian Laika"> West Siberian Laika </option>
    <option value="Westphalian Dachsbracke"> Westphalian Dachsbracke </option>
    <option value="Wetterhoun"> Wetterhoun </option>
    <option value="Whippet"> Whippet </option>
    <option value="White Shepherd"> White Shepherd </option>
    <option value="White Swiss Shepherd Dog"> White Swiss Shepherd Dog </option>
    <option value="Wire Fox Terrier"> Wire Fox Terrier </option>
    <option value="Wirehaired Pointing Griffon"> Wirehaired Pointing Griffon </option>
    <option value="Wirehaired Vizsla"> Wirehaired Vizsla </option>
    <option value="Xiasi Dog"> Xiasi Dog </option>
    <option value="Xoloitzcuintli"> Xoloitzcuintli </option>
    <option value="Yakutian Laika"> Yakutian Laika </option>
    <option value="Yorkshire Terrier"> Yorkshire Terrier </option></select>
</datalist>