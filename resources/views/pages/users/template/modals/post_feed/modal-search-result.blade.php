<style>
    .image-container-search {
        width: 50px;
        height: 50px;
        background-color: rgb(221, 219, 219);
        border-radius: 50px;
    }
    .image-container-search img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 50px;
    }
</style>
<div class="modal fade" id="searchResultModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header ff-primary">
                <h5 class="modal-title" id="modalTitleId"> Search result </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3 mb-xl-3 mt-3 mt-xl-3 ff-primary">
                        <h5>
                            Users
                        </h5>
                        <div id="user_result_container" class="user_result_container">


                        </div>
                        <div class="ff-primary">
                            <small>
                                Results : <label class="resultCountssss"></label>
                            </small>
                        </div>
                    </div>
                    {{-- <div><hr></div>
                    <div class="col-12">
                        <h5>
                            Posts
                        </h5>
                        <div class="post_result_container">
                            <div class="px-3 py-2">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi veniam culpa hic, praesentium temporibus doloribus, accusantium ipsam voluptatem blanditiis, debitis corporis ut voluptates neque deleniti non quo autem quam exercitationem.
                            </div>
                            <div class="px-3 py-2">
                                <button type="button" class="btn btn-primary btn-sm">More results</button>
                            </div>

                        </div>
                        <div>
                            <small>
                                Showing results : 4
                            </small>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
