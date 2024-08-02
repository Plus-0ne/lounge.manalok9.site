<div class="rig-side">
    @if (Auth::guard('web_admin')->check())
    <div class="analytics">
        <div class="analytics-container p-3">
            <table style="color: #eee;">
                <tr>
                    <td class="fw-bold text-small pe-3">Users Online: </td>
                    <td class="text-center text-gradient-primary">{{ number_format($data['analytics']['users_online'], 0) ?? '00'}}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-small pe-3">Registered: </td>
                    <td class="text-center text-gradient-primary">{{ number_format($data['analytics']['users_registered'], 0) ?? '00'}}</td>
                </tr>
                <tr>
                    <td class="fw-bold text-small pe-3">Total Visits: </td>
                    <td class="text-center text-gradient-primary">{{ number_format($data['analytics']['visitor_count'], 0) ?? '00'}}</td>
                </tr>
            </table>
        </div>
    </div>
    @else
    <div class="classi-ads">
        <div class="ads-container p-3">
            <div class="d-flex justify-content-start align-items-center mb-1">
                {{-- <video class="w-100" controls autoplay muted loop>
                    <source src="{{ asset('videos/MERCH-VIDEO-1.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video> --}}
                <a href="{{ route('user.view_this_posts') }}?post_id=5b42b719-3772-455b-9541-2279f6872453">

                    <img class="w-100" src={{ asset('img/ads/p1.png') }}>

                </a>
            </div>
            <div class="d-flex justify-content-start align-items-center mb-1">
                <video class="w-100" controls autoplay muted loop>
                    <source src="{{ asset('img/ads/PETREG-Final.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <hr>
            <div class="w-100">
                <a href="https://www.facebook.com/metaanimalstech" target="_BLANK">
                    <video class="w-100" src="{{ asset('videos/fb-ads.mp4_1.mp4') }}" autoplay muted loop></video>
                </a>
            </div>
            <div class="w-100">
                <a href="https://www.tiktok.com/@metaanimals" target="_BLANK">
                    <video class="w-100" src="{{ asset('videos/tiktok-ads.mp4_1.mp4') }}" autoplay muted loop></video>
                </a>
            </div>
            <div class="w-100">
                <a href="https://www.youtube.com/manalok9" target="_BLANK">
                    <video class="w-100" src="{{ asset('videos/youtube-ads.mp4_1.mp4') }}" autoplay muted loop></video>
                </a>
            </div>
            <div class="py-5">
            </div>
        </div>
    </div>
    @endif
</div>
