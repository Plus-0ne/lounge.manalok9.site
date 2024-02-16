$(document).ready(function () {
    /* rid = Members Number */ // check windows.rid = xnzcjkhadfhalsdas-sample; at the top

    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;

    /* Default page for post */
    var defPage = 1;


    /* Reaction svg template */
    function like_svg_template() {
        return '<span>\
        <svg width="23px" height="23px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">\
        <g>\
        <path fill="none" d="M0 0h24v24H0z"/>\
        <path fill="#0072ff" color="#0072ff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"/>\
        </g>\
        </svg>\
        </span>';
    }
    function haha_svg_template() {
        return '<span>\
        <svg width="23px" height="23px" viewBox="0 0 1500 1500" id="Layer_1" xmlns="http://www.w3.org/2000/svg">\
        <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"/><path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"/><ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"/><g><path id="mond" class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"/><path id="tong" class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"/><path id="linker_1_" class="st5" d="M1200.2 411L993 511.4l204.9 94.2"/><path id="linker_4_" class="st5" d="M297.8 411L505 511.4l-204.9 94.2"/></g>\
        </svg>\
        </span>';
    }
    function heart_svg_template() {
        return '<span>\
        <?xml version="1.0" encoding="iso-8859-1"?>\
        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
        width="23px" height="23px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;"\
        xml:space="preserve">\
        <g>\
        <path fill="#ff0025" color="#ff0025" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"/>\
        </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>\
        </svg>\
        </span>';
    }

    /* Ajax call get all post by user uuid */
    function GetUserReact(rid,defPage) {

        var user_uuid = rid;

        $.ajax({
            type: "GET",
            url: "/ajax/get-all-react?page="+defPage,
            data: {
                user_uuid : user_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var react = response;

                var react_val = null;
                var reacter_det = null;
                var poster_det = null;
                var post_det = null;
                var react_show_time = null;
                var reaction = null;

                var react_temp = null;

                $.each(react.data, function (i, val) {
                    react_val = val;
                    reacter_det = react_val.members_model;
                    poster_det = react_val.post_feed.members_model;
                    post_det = react_val.post_feed;
                    react_show_time = moment(react_val.created_at).local().fromNow(true) + ' ago';

                    switch (react_val.reaction) {
                        case 1:
                            reaction = like_svg_template();
                            break;
                        case 2:
                            reaction = haha_svg_template();
                            break;
                        case 3:
                            reaction = heart_svg_template();
                            break;

                        default: break;
                    }

                    react_temp = '<a class="user-react-link text-dark" href="' + window.thisUrl + '/view/post?post_id=' + post_det.post_id + '">\
                        <div class="user_post_container card px-3 pb-2 pt-3 mb-3">\
                            <small><b>' + (reacter_det.first_name ?? '') + (' ' + reacter_det.last_name ?? '') + '</b> reacted <i class="px-1">' + reaction + '</i> on <b>' + (poster_det.first_name ?? '') + (' ' + poster_det.last_name ?? '') + '</b>\'s post</small>\
                        </div>\
                    </a>';

                    $('.usersReacts-section').append(react_temp);
                });

                if (react.next_page_url == null) $('.show-more').parent().html('No more reacts');
            }
        });
    }
    GetUserReact(rid,defPage);

    $('.show-more').on('click', function() {
        defPage++;
        GetUserReact(rid,defPage);
    });

});
