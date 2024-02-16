{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body class="pet-body">
    <div class="wrapper-pet">
        <div class="image-pet-container d-flex justify-content-center">
            <img class="img-fluid align-self-center p-5" src="{{ $data['mg']->file_path }}"
                alt="{{ $data['mg']->name }}">
            <div class="pet-nav">
                <div class="close-this-view">
                    <a href="{{ url()->previous() }}">
                        <i class="mdi mdi-close"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="pet-details-container py-3 px-4">
            <div class="d-flex flex-column">
                <div class="dog-name-title">
                    <h5>
                        {{ $data['mg']->name }}
                    </h5>

                </div>
                <div class="desscriptss mt-3">
                    <p class="fw-normal">
                        {{ Str::ucfirst($data['mg']->gender) }} -
                        {{ Str::ucfirst($data['mg']->breed) }}
                    </p>
                    <p class="fw-normal">
                        {{ Str::ucfirst($data['mg']->description) }}
                    </p>

                </div>
                <div class="mini-details">
                    <small>{{ Carbon::createFromFormat('Y-m-d H:i:s',$data['mg']->created_at,Auth::guard('web')->user()->timezone)->format('D M d , Y - h:i:s A') }}</small>
                </div>
                <div class="group-cont d-flex flex-row justify-content-between mt-3">
                    <h4 class="align-self-center">
                        <i class="mdi mdi-thumb-up-outline"></i>
                    </h4>
                    <h4 class="align-self-center">
                        <i class="mdi mdi-eye"></i>
                    </h4>
                </div>
            </div>
        </div>
    </div>
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')

</html>
