<style>
    .cur-point {
        cursor: pointer;
    }
</style>
<div class="modal fade" id="selectPetAddModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Select pet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-between">

                    {{-- <div class="form-check">
                        <input id="birdRadio" class="form-check-input cur-point" type="radio" name="petRadio" value="bird" checked>
                        <label class="form-check-label cur-point" for="birdRadio">
                            Bird
                        </label>
                    </div> --}}
                    <div class="form-check">
                        <input class="form-check-input cur-point checkBoxPetType" type="checkbox" id="birdCheckb" value="bird" checked>
                        <label class="form-check-label cur-point" for="birdCheckb">
                            Bird
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input cur-point checkBoxPetType" type="checkbox" id="catCheckb" value="cat">
                        <label class="form-check-label cur-point" for="catCheckb">
                            Cat
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input cur-point checkBoxPetType" type="checkbox" id="dogCheckb" value="dog">
                        <label class="form-check-label cur-point" for="dogCheckb">
                            Dog
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input cur-point checkBoxPetType" type="checkbox" id="rabbitCheckb" value="rabbit">
                        <label class="form-check-label cur-point" for="rabbitCheckb">
                            Rabbit
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input cur-point checkBoxPetType" type="checkbox" id="othersCheckb" value="others">
                        <label class="form-check-label cur-point" for="othersCheckb">
                            Others
                        </label>
                    </div>

                    {{-- <div class="form-check">
                        <input id="catRadio" class="form-check-input cur-point" type="radio" name="petRadio"
                            value="cat">
                        <label class="form-check-label cur-point" for="catRadio">
                            Cat
                        </label>
                    </div>

                    <div class="form-check">
                        <input id="dogRadio" class="form-check-input cur-point" type="radio" name="petRadio"
                            value="dog">
                        <label class="form-check-label cur-point" for="dogRadio">
                            Dog
                        </label>
                    </div>

                    <div class="form-check">
                        <input id="rabbitRadio" class="form-check-input cur-point" type="radio" name="petRadio"
                            value="rabbit">
                        <label class="form-check-label cur-point" for="rabbitRadio">
                            Rabbit
                        </label>
                    </div>


                    <div class="form-check">
                        <input id="othersRadio" class="form-check-input cur-point" type="radio" name="petRadio"
                            value="others">
                        <label class="form-check-label cur-point" for="othersRadio">
                            Others
                        </label>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button id="continueAddPetBtn" type="button" class="btn btn-primary btn-sm">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>
