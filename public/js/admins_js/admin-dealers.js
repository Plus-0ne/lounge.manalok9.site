import { swalConfirmation , swalPrompts } from "/js/jsHelpers.js";

$(function () {
    /**
     * On dropdown show overflow set to inherit
     * @param {any} '.table-responsive'
     * @returns {any}
     */
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "none" );
    });

    /**
     * On dropdown hidden overt set to auto
     * @param {any} '.table-responsive'
     * @returns {any}
     */
    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    });

    /**
     * Initialize new datatable
     * @param {any} '#dealersTable'
     * @param {any} {responsive:true
     * @param {any} columnDefs:[{width:'15%'
     * @param {any} targets:0}
     * @param {any} {width:'15%'
     * @param {any} targets:1}
     * @param {any} {width:'15%'
     * @param {any} targets:2}
     * @param {any} {width:'15%'
     * @param {any} targets:3}]
     * @param {any} language:{paginate:{first:'<iclass="bibi-caret-left-fill"></i><iclass="bibi-caret-left-fill"style="margin-left:-10px;"></i>'
     * @param {any} last:'<iclass="bibi-caret-right-fill"></i><iclass="bibi-caret-right-fill"style="margin-left:-10px;"></i>'
     * @param {any} next:'<iclass="bibi-caret-right-fill"></i>'
     * @param {any} previous:'<iclass="bibi-caret-left-fill"></i>'}}}
     * @returns {any}
     */
    let dealersTable = new DataTable('#dealersTable',{
        responsive: true,
        columnDefs: [
            {
                width: '15%',
                targets: 0
            },
            {
                width: '15%',
                targets: 1
            },
            {
                width: '15%',
                targets: 2
            },
            {
                width: '15%',
                targets: 3
            }
        ],
        language: {
            paginate: {
                first: '<i class="bi bi-caret-left-fill"></i><i class="bi bi-caret-left-fill" style="margin-left: -10px;"></i>',
                last: '<i class="bi bi-caret-right-fill"></i><i class="bi bi-caret-right-fill" style="margin-left: -10px;"></i>',
                next: '<i class="bi bi-caret-right-fill"></i>',
                previous: '<i class="bi bi-caret-left-fill"></i>'
            }
        }
    });

    $('.approvedBtn').on('click', function () {
        let swalText = "Approve application for a dealer ?";
        let swalIcon = "info";
        let swalConfirmBtn = "Yes";
        let swalCancelBtn = "No";
        let swalConfirmClass = "btn btn-primary me-1";
        let swalCancelClass = "btn btn-secondary";

        let thisBtn = $(this);

        swalConfirmation(
            swalText,
            swalIcon,
            swalConfirmBtn,
            swalCancelBtn,
            swalConfirmClass,
            swalCancelClass
        ).then((result) => {
            if (result.isConfirmed) {
                const fd = new FormData();
                const endpoint = window.urlBase + "/admin/dealers/update/status";

                fd.append('uuid', $(this).attr('data-uuid'));
                fd.append('type', 'approve');

                $.ajax({
                    url: endpoint,
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function () {
                        thisBtn.prop('disabled',true);
                    },
                    success: function (response) {
                        const res = response;

                        console.log(res);

                        if (res.status !== undefined) {
                            let swalText = res.message;
                            let swalIcon = res.status;
                            let swalConfirmBtn = "Ok";
                            let swalConfirmClass = "btn btn-primary";
                            swalPrompts(
                                swalText,
                                swalIcon,
                                swalConfirmBtn,
                                swalConfirmClass
                            ).then((result) => {
                                if (result.isConfirmed && res.status == 'success') {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function (error) {
                        let swalText = error.responseJSON.message;
                        let swalIcon = 'error';
                        let swalConfirmBtn = 'Ok';
                        let swalConfirmClass = 'btn btn-primary'
                        swalPrompts(swalText,swalIcon,swalConfirmBtn,swalConfirmClass);
                    },
                    complete: function () {
                        thisBtn.prop('disabled',false);
                    }
                });

            }
        });
    });

    $('.rejectBtn').on('click', function () {
        let swalText = "Reject application for a dealer ?";
        let swalIcon = "warning";
        let swalConfirmBtn = "Yes";
        let swalCancelBtn = "No";
        let swalConfirmClass = "btn btn-primary me-1";
        let swalCancelClass = "btn btn-secondary";

        let thisBtn = $(this);
        let defaultHtmlContent = $(this).html();

        swalConfirmation(
            swalText,
            swalIcon,
            swalConfirmBtn,
            swalCancelBtn,
            swalConfirmClass,
            swalCancelClass
        ).then((result) => {
            if (result.isConfirmed) {
                const fd = new FormData();
                const endpoint = window.urlBase + "/admin/dealers/update/status";

                fd.append('uuid', $(this).attr('data-uuid'));
                fd.append('type', 'reject');

                $.ajax({
                    url: endpoint,
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function () {
                        thisBtn.prop('disabled',true);
                    },
                    success: function (response) {
                        const res = response;

                        console.log(res);

                        if (res.status !== undefined) {
                            let swalText = res.message;
                            let swalIcon = res.status;
                            let swalConfirmBtn = "Ok";
                            let swalConfirmClass = "btn btn-primary";
                            swalPrompts(
                                swalText,
                                swalIcon,
                                swalConfirmBtn,
                                swalConfirmClass
                            ).then((result) => {
                                if (result.isConfirmed && res.status == 'success') {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function (error) {
                        let swalText = error.responseJSON.message;
                        let swalIcon = 'error';
                        let swalConfirmBtn = 'Ok';
                        let swalConfirmClass = 'btn btn-primary'
                        swalPrompts(swalText,swalIcon,swalConfirmBtn,swalConfirmClass);
                    },
                    complete: function () {
                        thisBtn.prop('disabled',false);
                    }
                });

            }
        });
    });
});
