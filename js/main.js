const showSwal = (title, html) => {
    Swal.fire({
        title: title,
        html: html,
        background: "#F8D7A5",
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false
    })
};

const showSwalSmall = (title, html) => {
    Swal.fire({
        title: title,
        html: html,
        background: "#F8D7A5",
        width: '70vw',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false
    })
};

const showToast = (type, message, redirectURL) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: type,
        title: message
    });
    if (redirectURL) {
        setTimeout(() => {
            window.location.href = redirectURL;
        }, 3000);
    }
}

const closeSwal = () => {
    Swal.close();
};

const resizeContentDiv = () => {
    let page = $("#pageDiv");
    if (page.length > 0) {
        let navbar = $("#navbarDiv");
        page.css("height", window.innerHeight - navbar.outerHeight() + "px");
    }

    let pageContent = $("#pageContentDiv");
    if (pageContent.length > 0) {
        let navbar = $("#navbarDiv");
        let header = $("#headerDiv");
        let footer = $("#footerDiv");
        if (footer.length > 0) {
            pageContent.css("height", window.innerHeight - navbar.outerHeight() - header.outerHeight() - footer.outerHeight() + "px");
        } else {
            pageContent.css("height", window.innerHeight - navbar.outerHeight() - header.outerHeight() + "px");
        }
    }
};

$(window).on("load resize change", resizeContentDiv);
