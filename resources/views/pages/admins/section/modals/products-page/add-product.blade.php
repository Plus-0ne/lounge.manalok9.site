<form action="{{ route('admin.createNewProduct') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="addNewProductModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add new product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Choose file</label>
                                <input type="file" class="form-control" aria-describedby="fileHelpId" name="image">
                                <div id="fileHelpId" class="form-text">Upload product image with <strong>JPEG</strong> or <strong>PNG</strong> format.</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted">Enter product name</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" name="price" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted">Enter product price</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" class="form-control" name="stock" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted">Enter current stock</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                                <small id="helpId" class="form-text text-muted">Enter product description</small>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <span class="mdi mdi-plus"></span> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
