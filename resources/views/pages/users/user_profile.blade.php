{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <h5>
                                    Members Profile
                                </h5>
                            </div>
                            <div class="col-12 my-2">
                                <hr>
                            </div>
                            <div class="row p-3 w-100">
                                <div class="col-12 col-sm-12 col-lg-6">
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            IAGD No.
                                        </dt>
                                        <dd class="text-center text-md-start">
                                            {{ Auth::guard('web')->user()->iagd_number }}
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            Email Address
                                        </dt>
                                        <dd class="text-center text-md-start">
                                            {{ Auth::guard('web')->user()->email_address }}
                                            @if ($data['everify']->verified != null)
                                                <br>
                                                <small class="text-success">
                                                    <i class="mdi mdi-checkbox-marked-circle text-success"></i> Verified
                                                    at
                                                    {{ Carbon::createFromFormat('Y-m-d H:i:s',$data['everify']->created_at,Auth::guard('web')->user()->timezone)->format('Y-m-d h:i a') }}
                                                </small>
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            Name
                                        </dt>
                                        <dd class="text-center text-md-start col-12 col-lg-6">
                                            @if (empty(Auth::guard('web')->user()->last_name))
                                                Empty
                                            @else
                                                {{ Auth::guard('web')->user()->last_name }}
                                            @endif

                                            @if (empty(Auth::guard('web')->user()->first_name))
                                                Empty
                                            @else
                                                {{ Auth::guard('web')->user()->first_name }}
                                            @endif

                                            @if (empty(Auth::guard('web')->user()->middle_name))

                                            @else
                                            , {{ Auth::guard('web')->user()->middle_name }}
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            Contact Number
                                        </dt>
                                        <dd class="text-center text-md-start col-12 col-lg-6">
                                            @if (empty(Auth::guard('web')->user()->contact_number))
                                                Empty
                                            @else
                                                {{ Auth::guard('web')->user()->contact_number }}
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            Address
                                        </dt>
                                        <dd class="text-center text-md-start col-12">
                                            @if (empty(Auth::guard('web')->user()->address))
                                                Empty
                                            @else
                                                {{ Auth::guard('web')->user()->address }}
                                            @endif
                                        </dd>

                                    </dl>
                                    <dl class="row">
                                        <div class="my-3">
                                            <button type="button" class="btn btn-primary btn-size-95-rem"
                                                data-bs-target="#update_profile" data-bs-toggle="modal">
                                                <i class="mdi mdi-square-edit-outline"></i> UPDATE
                                            </button>
                                        </div>
                                    </dl>
                                </div>

                                <div class="col-12 col-sm-12 col-lg-6 h-100">
                                    <div class="profile-image w-100 text-center">
                                        @if (!empty(Auth::guard('web')->user()->profile_image))
                                            <img id="prof-img"
                                                src="{{ asset(Auth::guard('web')->user()->profile_image) }}">
                                        @else
                                            <img id="prof-img" src="{{ asset('my_custom_symlink_1/user.png') }}">
                                        @endif
                                        <br>
                                        <br>
                                        <button class="btn btn-primary btn-size-95-rem"
                                            data-bs-target="#upload_profileimage" data-bs-toggle="modal">
                                            <i class="mdi mdi-square-edit-outline"></i> UPDATE PROFILE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 gallery_container d-flex flex-wrap mt-5">

                            <div class="m-3 col-12">
                                <h5>
                                    Security
                                </h5>
                            </div>

                            <div class="col-12 my-2">
                                <hr>
                            </div>
                            <div class="p-3 col-12 col-sm-12 col-xl-6">
                                <form action="{{ route('user.update_my_password') }}" method="post">
                                    @csrf
                                    <dl class="row">
                                        <dt class="text-center text-md-start">
                                            Password
                                        </dt>
                                        <dd class="text-center text-md-start col-12 col-md-9 col-lg-8 col-xl-7">
                                            <div class="my-3">
                                                <input type="password" name="c_pass" class="form-control"
                                                    placeholder="Current password">
                                            </div>
                                            <div class="my-3">
                                                <input type="password" name="n_pass" class="form-control"
                                                    placeholder="New password">
                                            </div>
                                            <div class="my-3">
                                                <input type="password" name="v_pass" class="form-control"
                                                    placeholder="Verify password">
                                            </div>
                                            <div class="my-3">
                                                <button type="submit" class="btn btn-primary btn-size-95-rem">
                                                    <i class="mdi mdi-square-edit-outline"></i> UPDATE PASSWORD
                                                </button>
                                            </div>
                                        </dd>
                                    </dl>
                                </form>
                            </div>
                            <div class="p-3 col-12 col-sm-12 col-xl-6">
                                <dl class="row">
                                    <dt class="text-center text-md-start">
                                        Email Authentication
                                    </dt>
                                    <dd class="text-center text-md-start col-12">
                                        <div class="my-3">
                                            <input type="checkbox" data-toggle="toggle" data-on="Enable"
                                                data-off="Disable">
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- INCLUDE MODAL TEMPLATE --}}
    @include('pages/users/template/modals/upload_profile_modal')
    @include('pages/users/template/modals/modal-update-profile')

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
<script type="text/javascript">
    var upImageUrl = '{{ route('user.upload_cropped_image') }}';
</script>
<script src="{{ asset('jqueryCropper/cropper.js') }}"></script>
<link href="{{ asset('jqueryCropper/cropper.css') }}" rel="stylesheet">
<script src="{{ asset('jqueryCropper/jquery-cropper.js') }}"></script>
<script src="{{ asset('custom/js/user-profile.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}');
        @endif
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]('Somethin\'s wrong! Please try again.');
                @break

                @case('member_fail_update')
                    toastr["warning"]('Updating profile failed!');
                @break

                @case('member_updated')
                    toastr["success"]('Profile updated!');
                @break

                @case('incorrect_password')
                    toastr["warning"]('Password is incorrect!');
                @break

                @case('pass_did_not_matched')
                    toastr["warning"]('Password did not matched!');
                @break

                @case('error_changed_pass')
                    toastr["warning"]('Failed to update password');
                @break

                @case('pass_changed')
                    toastr["success"]('Password updated');
                @break

                @default
            @endswitch
        @endif
    });
</script>

</html>
