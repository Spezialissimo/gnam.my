const showSwal = (title, html) => {
    Swal.fire({
        title: title,
        html: html,
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false
    })
};

const closeSwal = () => {
    Swal.close();
};