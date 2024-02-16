$(document).ready(function() {
    /* -------------------------------------------------------------------------- */
    /*                             Get user permission                            */
    /* -------------------------------------------------------------------------- */
    function qrUserPermission() {
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {


                /* Fill select box with camera options */
                cameraOptions(devices);

                console.log(devices);
                startQrCodeScanner(devices);
            }
        }).catch(err => {
            console.log(err);
        });
    }

    qrUserPermission();

    /* -------------------------------------------------------------------------- */
    /*                     Fill select box with camera options                    */
    /* -------------------------------------------------------------------------- */
    function cameraOptions(devices) {
        let cameraOptionsSelect = $('#cameraOptionsSelect');
        $.each(devices, function (devicesI, devicesVal) {
            cameraOptionsSelect.append($('<option>',{
                'value' : devicesVal.id,
                'text' : devicesVal.label
            }));
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                            Start qrcode scanner                            */
    /* -------------------------------------------------------------------------- */
    function startQrCodeScanner(devices) {

        const html5QrCode = new Html5Qrcode("qrreader");
        let cameraId = devices[0].id;

        html5QrCode.start(
                cameraId, {
                    fps: 30,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                (decodedText, decodedResult) => {
                    if (isValidURL(decodedText) == true) {


                        html5QrCode.stop().then((ignore) => {
                            window.location = decodedText;
                        }).catch((err) => {
                            console.log(err);
                        });

                    } else {
                        console.log(decodedText);
                    }

                },
                (errorMessage) => {
                    // console.log(errorMessage);
                })
            .catch((err) => {
                console.log(err);
            });
    }

    $(document).on('change','#cameraOptionsSelect', function () {
        const html5QrCode = new Html5Qrcode("qrreader");
        let cameraId = $(this).val();

        html5QrCode.start(
                cameraId, {
                    fps: 30,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                (decodedText, decodedResult) => {
                    if (isValidURL(decodedText) == true) {


                        html5QrCode.stop().then((ignore) => {
                            window.location = decodedText;
                        }).catch((err) => {
                            console.log(err);
                        });

                    } else {
                        console.log(decodedText);
                    }

                },
                (errorMessage) => {
                    // console.log(errorMessage);
                })
            .catch((err) => {
                console.log(err);
            });
    });
    /* -------------------------------------------------------------------------- */
    /*                       Validate if decodedtext is url                       */
    /* -------------------------------------------------------------------------- */
    function isValidURL(decodedText) {
        let res = decodedText.match(
            /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g
        );
        return (res !== null)
    };

});
