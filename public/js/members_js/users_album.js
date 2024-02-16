$(document).ready(function () {
    /* Global variable */
    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;
    window.lastChatdate = '0000-00-00 00:00:00';
    Ppage = 1;

    /* Get all photos */
    function get_all_attachments(rid,Ppage) {
        var user_uuid = rid;

        $.ajax({
            type: "post",
            url: "/ajax/get_all_attachment?page="+Ppage,
            data: {
                user_uuid:user_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                temp_create_album(res);
            }
        });
    }

    /* Load get_all_attachments */
    get_all_attachments(rid,Ppage);

    /* Generate album in page */
    function temp_create_album(res) {
        console.log(res);
        $.each(res, function (YearIndex, YearPostVal) {

            var yearow = "";
            var yearPostContent = "";



            $.each(YearPostVal, function (PostIndex, PostVal) {

                var albumFeaturedimg = window.assetUrl+'my_custom_symlink_1/user.png';
                if (PostVal.file_type != null) {
                    albumFeaturedimg = window.assetUrl+PostVal.file_type;
                }

                yearPostContent += '<div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3">\
                    <div class="album-img-container">\
                        <img class="album-img-content" src="'+albumFeaturedimg+'" alt="">\
                    </div>\
                    <small>'+PostVal.post_id+'</small>\
                </div>';
            });

            yearow = '<div class="w-100 '+YearIndex+'_yearrow">\
            <div class="w-100">\
                <label for="">\
                    '+YearIndex+'\
                </label>\
                <div class="d-flex flex-wrap">\
                '+yearPostContent+'\
                </div>\
            </div>\
            </div>';

            $('.album_archive').append(yearow);
        });
    }
});
