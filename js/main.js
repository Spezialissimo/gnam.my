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
        pageContent.css("height", window.innerHeight - navbar.outerHeight() - header.outerHeight() + "px");
    }
};

$(window).on("load resize change", resizeContentDiv);
