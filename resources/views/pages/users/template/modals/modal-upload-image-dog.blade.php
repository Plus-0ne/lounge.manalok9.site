<div class="modal fade" id="upload_img_dog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.upload_dog_image') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row p-3">
                            <div class="col-12 my-3">
                                <label class="form-label">
                                    Name
                                </label>
                                <input class="form-control" type="text" name="name">
                            </div>
                            <div class="col-6 my-3">
                                <label class="form-label">
                                    Gender
                                </label>
                                <select class="form-select" name="gender" id="">
                                    <option value="male"> Male </option>
                                    <option value="female"> Female </option>
                                </select>
                            </div>
                            <div class="col-6 my-3">
                                <label class="form-label">
                                    Breed
                                </label>
                                <input class="form-control" type="text" name="breed">
                            </div>
                            <div class="col-12 my-3">
                                <label class="form-label">
                                    Description
                                </label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-12 my-3">
                                <label class="form-label">
                                    Image
                                </label>
                                <input class="form-control" type="file" name="file_path">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
