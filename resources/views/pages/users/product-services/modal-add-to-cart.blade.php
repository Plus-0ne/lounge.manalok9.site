<div class="modal fade" id="modalAddToCart" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Add to cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                  <label for="" class="form-label">
                    Quantity
                  </label>
                  <input type="number" class="form-control" id="quantity" aria-describedby="helpId" onClick="this.select();" value="1">
                  <small id="helpId" class="form-text text-muted">Enter quantity to add to your cart</small>
                </div>
            </div>
            <div class="modal-footer">
                <button id="addToCartItem" type="button" class="btn btn-primary btn-sm">Add</button>
            </div>
        </div>
    </div>
</div>
