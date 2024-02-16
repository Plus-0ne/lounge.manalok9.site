$(document).ready(function () {
    /* Variables */
    let user_uuid_to_add = null;
    let user_email_to_add = null;

    /* Initialize datatables */
    $('#usersMembers').dataTable();

    /* -------------------------------------------------------------------------- */
    /*                On button add click show form modal for admin               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.btnNewAdminForm', function () {

        let uuid = $(this).attr('data-uuid');

        formGetUserDetails(uuid);
    });

    /* -------------------------------------------------------------------------- */
    /*                      Submit data-uuid get user details                     */
    /* -------------------------------------------------------------------------- */
    function formGetUserDetails(uuid) {

        const fd = new FormData();

        fd.append('uuid', uuid);

        $.ajax({
            type: "post",
            url: window.currentBaseUrl + "/admin/ajax/user/get",
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'application/x-www-form-urlencoded',
            data: fd,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                const res = response;

                if (res.status == 'success') {
                    $('#newAdminFormModal').modal('toggle');
                    formAdminAccountModal(res);
                }

                console.log(res);
            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                          Fill form modal with data                         */
    /* -------------------------------------------------------------------------- */
    function formAdminAccountModal(res) {
        const user = res.user;

        let imgProf = (user.profile_image != null ? window.assetUrl + '/' + user.profile_image : window.assetUrl + '/' + 'img/user/user.png');
        let complete_name = 'Guest';
        let email_address = user.email_address;
        let verifiedEmail = 'mdi mdi-check-circle text-success';

        if (user.first_name != null || user.last_name != null) {
            complete_name = user.first_name + ' ' + user.last_name;
        }
        /* Update profile image */
        $('#img-user-profile').attr('src', imgProf);
        $('#user_name').html(complete_name);
        $('#user_email').html(email_address);

        if (user.is_email_verified != 1) {
            verifiedEmail = 'mdi mdi-check-circle text-muted';
        }

        $('#user_email').append(
            $('<span>', {
                class: verifiedEmail,
            })
        );

        /* Convert date */
        let usercat = user.created_at;
        let cdate = moment(usercat);
        cdateFormatted = cdate.local().format("MMMM DD, YYYY - hh:mm A");

        $('#user_dregister').html(cdateFormatted);

        /* Update user user_uuid_to_add and user_email_to_add */
        user_uuid_to_add = user.uuid;
        user_email_to_add = user.email_address;

    }

    /* -------------------------------------------------------------------------- */
    /*                          Create password generator                         */
    /* -------------------------------------------------------------------------- */
    function passGenerator() {
        var generatePassword = (
            length = 32,
            wishlist = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!$@#&*?|%+-_./:;=()[]{}'
        ) =>
            Array.from(crypto.getRandomValues(new Uint32Array(length)))
                .map((x) => wishlist[x % wishlist.length])
                .join('')

        return generatePassword();
    }

    /* -------------------------------------------------------------------------- */
    /*                              Generate password                             */
    /* -------------------------------------------------------------------------- */
    $('#generatePassword').on('click', function () {
        let password = $('#password');
        let verifyPassword = $('#verifyPassword');
        let passGenerated = passGenerator();

        password.val(passGenerated);
        verifyPassword.val(passGenerated);
    });

    /* -------------------------------------------------------------------------- */
    /*                            Create new admin user                           */
    /* -------------------------------------------------------------------------- */
    $('#createNewAdmin').on('click', function () {
        const department = $('#department');
        const position = $('#position');
        const roles = $('#roles');
        const password = $('#password');
        const verifyPassword = $('#verifyPassword');
        const fd = new FormData();

        if (user_uuid_to_add == null || user_email_to_add == null || department.val().length < 1 || position.val().length < 1 || password.val().length < 1 || verifyPassword.val().length < 1 || roles.has('option').length < 1 || roles.val().length < 1) {
            alert('Fill up all fields!');
            return false;
        }

        fd.append('user_uuid', user_uuid_to_add);
        fd.append('email_address', user_email_to_add);
        fd.append('department', department.val());
        fd.append('position', position.val());
        fd.append('roles', roles.val());
        fd.append('password', password.val());
        fd.append('verifyPassword', verifyPassword.val());

        $.ajax({
            type: "post",
            url: window.currentBaseUrl + "/admin/ajax/user/create",
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'application/x-www-form-urlencoded',
            data: fd,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                const res = response;

                if (res.status == 'success') {
                    clearAllinput();

                    $('#newAdminFormModal').modal('toggle');

                    window.location = window.currentBaseUrl+ '/admin/accounts_list';

                }
            }
        });

    });

    /* -------------------------------------------------------------------------- */
    /*                               Clear all input                              */
    /* -------------------------------------------------------------------------- */
    function clearAllinput() {
        const department = $('#department');
        const position = $('#position');
        const roles = $('#roles');
        const password = $('#password');
        const verifyPassword = $('#verifyPassword');

        department.val("");
        position.val("");
        roles.prop("selectedIndex", 0);
        password.val("");
        verifyPassword.val("");
    }
});
