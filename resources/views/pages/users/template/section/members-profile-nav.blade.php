<div class="mem-image-container text-center">
    <img id="mem-profimage" class="mem-profimg" src="{{ asset('/') }}{{ $data['gmd']->profile_image }}"
        alt="Members Profile Image">

</div>
<div class="w-100 d-flex justify-content-around py-5 px-3">
    <div class="profile-likes text-secondary text-center">
        <h2>
            <i class="mdi mdi-thumb-up"></i>
        </h2>
        <label>

        </label>
    </div>
    <div class="profile-followers text-secondary text-center">
        <h2>
            <i class="mdi mdi-account-group"></i>
        </h2>
        <label>

        </label>
    </div>
</div>
<div class="nav-menus px-3">
    <nav class="nav flex-column cnav">
        <a class="nav-link cnav-link" href="{{ route('user.view_members') }}?rid={{ $data['rid'] }}">Details</a>
        <a class="nav-link cnav-link" href="{{ route('user.view_members_posts') }}?rid={{ $data['rid'] }}">Post</a>
        <a class="nav-link cnav-link" href="{{ route('user.view_members_advertisements') }}?rid={{ $data['rid'] }}">Ads</a>
        <a class="nav-link cnav-link" href="#">Comments</a>
        <a class="nav-link cnav-link" href="#">Reactions</a>
        <a class="nav-link cnav-link" href="#">Gallery</a>
    </nav>
</div>
