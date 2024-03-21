{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

</head>

<body>
    <div class="wrapper">
        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')
        <div class="main">
            {{-- SIDEABAR --}}
            @include('pages/users/template/section/sidebar')
            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">

                        <div class="col-12 write_post_section d-flex flex-wrap">
                            {{-- Content here --}}
                            <div class="d-flex flex-column p-0 p-lg-3 w-100">
                                <div class="col-12">
                                    <h4>
                                        Browse all pets
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button id="addPetModalBtn" type="button" class="btn btn-success btn-sm">
                                            <span class="mdi mdi-plus"></span> Add new pet
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                {{-- Search pet --}}
                                <div class="row">

                                    <div class="col-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="pet_name_search" class="form-label">
                                                Search
                                            </label>
                                            <input id="pet_name_search" type="text" class="form-control form-control-sm"
                                                placeholder="Search name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-xxl-2">
                                        <div class="mb-3">
                                            <label for="selectPet" class="form-label">
                                                Pet
                                            </label>
                                            <select id="selectPet" class="form-select form-select-sm">
                                                <option selected value="dogs"> Dogs </option>
                                                <option value="cats"> Cats </option>
                                                <option value="birds">Birds</option>
                                                <option value="rabbits">Rabbits</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xxl-2">
                                        <div class="mb-3">
                                            <label for="sorting" class="form-label">
                                                Sort by
                                            </label>
                                            <select id="sorting" class="form-select form-select-sm">
                                                <option selected value="names"> Names </option>
                                                <option value="date_added"> Date added </option>
                                                <option value="status"> Status </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xxl-2">
                                        <div class="mb-3">
                                            <label for="order_by" class="form-label">
                                                Order by
                                            </label>
                                            <select id="order_by" class="form-select form-select-sm">
                                                <option selected value="asc"> Ascending </option>
                                                <option value="desc"> Descending </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xxl-2" style="display: none;">
                                        <div class="mb-3">
                                            <label for="premorn" class="form-label">
                                                Status
                                            </label>
                                            <select id="premorn" class="form-select form-select-sm">

                                                <option value="non_prem" selected> Non-Premium </option>
                                                <option value="prem"> Premium </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                {{-- Display pets --}}
                                <div id="pet_card_container" class="row">

                                </div>

                                {{-- Pagination --}}
                                <div id="pet-pagination" class="d-flex flex-row justify-content-end">
                                    <button id="prevPage" type="button" class="btn btn-primary btn-sm me-2">
                                        Previous
                                    </button>
                                    <button id="nextPage" type="button" class="btn btn-primary btn-sm">
                                        Next
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Modals --}}
    @include('pages.users.animal-pages.modal-select-pet-add')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')
    <script src="{{ asset('js/animal-pages/pet.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('status'))
                @switch(Session::get('status'))
                    @case('error')
                    var message = "{{ Session::get('message') }}";

                    toastr["error"](message);
                    @break

                    @case('success')
                    var message = "{{ Session::get('message') }}";
                    toastr["success"](message);
                    @break

                    @default
                @endswitch
            @endif
        });
    </script>

</body>

</html>
