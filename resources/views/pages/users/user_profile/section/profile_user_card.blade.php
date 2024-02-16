<div class="card d-shadows-primary">
    <div class="card-body">
        <div class="d-flex justify-content-center">
            @if (!empty($data['gmd']->profile_image))
                <img class="vm-profile-image" src="{{ asset($data['gmd']->profile_image) }}" alt="{{ $data['gmd']->first_name }}'s profile image">
            @else
                <img class="vm-profile-image" src="{{ asset('my_custom_symlink_1/user.png') }}">
            @endif
        </div>
        <div class="d-flex justify-content-center mt-3">
            <div class="profile-icon d-flex flex-column justify-content-center text-center">
                <label class="like_cccc"></label>
                <span class="badge rounded-pill bg-success">Likes</span>
            </div>
            <div class="profile-icon d-flex flex-column justify-content-center text-center">
                <label class="followers_ccc"></label>
                <span class="badge rounded-pill bg-primary">Followers</span>
            </div>
        </div>
        {{-- BASIC DETAILS --}}
        <div class="d-flex flex-column justify-content-center mt-3 text-center">
            <h5>
                <strong class="lead fw-bold">
                    {{ $data['gmd']->first_name }} {{ $data['gmd']->last_name }} {{ $data['gmd']->middle_initial }}
                </strong>
            </h5>
            <label class="p-2">
                <span class="rounded-pill fw-bold px-3 py-1 w-auto" style="background-color: {{ $data['gmd']->is_premium == '1' ? '#D4AF37' : '#AAAAAA' }}; color: {{ $data['gmd']->is_premium == '1' ? '#FFF' : '#000' }};">
                    {{ $data['gmd']->iagd_number }}
                </span>
            </label>
            <label>
                {{ Carbon::parse($data['gmd']->birth_date)->format('F d, Y') }}
            </label>
            <label>
                {{ Str::ucfirst($data['gmd']->gender) }}
            </label>
        </div>
        @if ($data['gmd']->uuid != Auth::guard('web')->user()->uuid)
            <div id="followerBtn-container" class="pt-2">
                @if ($data['iFollowed']->count() > 0)
                    <a class="btn btn-danger w-100" href="{{ route('user.follow_user') }}?id={{ $data['gmd']->uuid }}&status=unfollow">
                        <span class="mdi mdi-account-remove-outline"></span> Unfollow
                    </a>
                @else
                    <a class="btn btn-success w-100" href="{{ route('user.follow_user') }}?id={{ $data['gmd']->uuid }}&status=follow">
                        <span class="mdi mdi-account-plus-outline"></span> Follow
                    </a>
                @endif
            </div>
            <div class="pt-2">
                <a class="btn btn-info w-100" href="{{ route('user.message_user_card') }}?uu={{ $data['gmd']->uuid }}">
                    <span class="mdi mdi-chat"></span> Message
                </a>
            </div>

        @else
        {{-- <div id="writepost-container" class="pb-3 pt-1">
            <a class="btn btn-primary w-100" href="#">
                Create new post
            </a>
        </div> --}}
        @endif
        <div class="pt-2">
            <a id="btnModalQrCodeShow" class="btn btn-secondary w-100" href="javascript:void(0);">
                <span class="mdi mdi-qrcode"></span> QR Code
            </a>
        </div>

    </div>
</div>
