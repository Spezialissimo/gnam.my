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

const resizeContentDiv = () => {
    page = document.getElementById("pageDiv");
    if (page != null) {
        navbar = document.getElementById("navbarDiv");
        page.style.height = String(window.innerHeight - navbar.clientHeight) + "px";
    }
    
    pageContent = document.getElementById("pageContentDiv");
    if (pageContent != null) {
        navbar = document.getElementById("navbarDiv");
        header = document.getElementById("headerDiv");
        pageContent.style.height = String(window.innerHeight - navbar.clientHeight - header.clientHeight) + "px";
    }
}

window.onload = resizeContentDiv;
window.onresize = resizeContentDiv;