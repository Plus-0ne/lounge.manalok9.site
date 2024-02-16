{{-- Profile navigation --}}
<ul class="nav nav-pills">
    <li class="nav-item me-1 me-lg-3">
        <a class="nav-link active" aria-current="page" href="{{ route('user.view_members') }}?rid={{ $data['gmd']->uuid }}">Posts</a>
    </li>
    <li class="nav-item me-1 me-lg-3">
        <a class="nav-link" aria-current="page" href="#">Recent viewed post</a>
    </li>
    <li class="nav-item me-1 me-lg-3">
        <a class="nav-link" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
    </li>
    <li class="nav-item me-1 me-lg-3">
        <a class="nav-link" aria-current="page" href="{{ route('user.view_user_album') }}?rid={{ $data['gmd']->uuid }}">Album</a>
    </li>
    <li class="nav-item me-1 me-lg-3">
        <a class="nav-link" aria-current="page" href="{{ route('user.view_members_advertisements') }}?rid={{ $data['gmd']->uuid }}">Ads</a>
    </li>
</ul>
