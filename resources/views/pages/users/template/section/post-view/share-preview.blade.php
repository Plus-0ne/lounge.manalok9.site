@php
    $sharePost = $data['shareContent']->first();
    $sharedPostData = $sharePost['sharedSource'];
    $sharePostAttachments = $sharePost->sourceAttachments();
    $sharePostCreator = $sharedPostData->MembersModel()->first();
    $sarrFormat = ['mp4', 'webm', 'ogg'];


@endphp
<div class="col-12 mb-3">
    <div class="card p-3">
        {{-- Get share post header with user name and details --}}
        <div class="share-post-header d-flex flex-row">
            {{-- TODO create - header with profile image , name , date --}}
            <div class="share-user-image">
                <img width="100px" src="{{ asset($sharePostCreator->profile_image) }}" alt="">
            </div>
            <div class="d-flex flex-column ms-2 fs-text">
                <div class="d-flex flex-row">
                    <div>
                        <a class="pf-user-name text-dark" href="{{ url('/') }}/view/members-details?rid={{ $data['postAuthor']->first()->uuid }}">
                            {{ $sharePostCreator->first_name }} {{ $sharePostCreator->last_name }}
                        </a>

                        @switch($sharedPostData->type)
                            @case('post')
                                {{ ' published a post.' }}
                                @break
                            @case('post_attachments')
                                {{ ' published a post with attachments.' }}
                                @break
                            @case('shared_post')
                                {{ ' share a post.' }}
                                @break
                            @default
                                {{ ' published a post.' }}
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="post_date_shared fs-extra-small">

                </div>
            </div>
        </div>
        <div class="post_message_share col-12 mb-2 mx-2 fs-text">
            {{ $sharedPostData->post_message }}
        </div>
        @if ($sharePostAttachments->count() > 0)
            <div class="owl-carousel owl-theme w-100 justify-content-center">

                @foreach ($sharePostAttachments->get() as $row)
                    <div class="item w-100 text-center">
                        @if (in_array($row->file_extension, $sarrFormat))
                            <video class="mx-auto videoFull" src="{{ asset($row->file_path) }}"
                                type="video/{{ $row->file_extension }}" controls="true" muted></video>
                        @else
                            <img class="mx-auto imgFull" src="{{ asset($row->file_path) }}">
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
