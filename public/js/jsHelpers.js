export function swalConfirmation(
    swalText,
    swalIcon,
    swalConfirmBtn,
    swalCancelBtn,
    swalConfirmClass,
    swalCancelClass,
) {
    return Swal.fire({
        text: `${swalText}`,
        icon: `${swalIcon}`,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText : `${swalConfirmBtn}`,
        cancelButtonText : `${swalCancelBtn}`,
        buttonsStyling: false,
        customClass: {
            confirmButton: `${swalConfirmClass}`,
            cancelButton: `${swalCancelClass}`
        },
        showClass: {
            popup: `
            animate__animated
            animate__fadeInUp
            animate__faster
            `
        },
        hideClass: {
            popup: `
            animate__animated
            animate__fadeOutDown
            animate__faster
            `
        }
    });
}

export function swalPrompts(swalText,swalIcon,swalConfirmBtn,swalConfirmClass) {
    return Swal.fire({
        text: swalText,
        icon: swalIcon,
        confirmButtonText : swalConfirmBtn,
        buttonsStyling: false,
        customClass: {
            confirmButton: swalConfirmClass,
        },
    });
}

