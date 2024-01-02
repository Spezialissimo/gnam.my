const showSwal = (title, html) => {
    Swal.fire({
        title: title,
        html: html,
        background: "#F8D7A5",
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false
    });
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
    });
};

const showSwalSmallOnClose = (title, html, onClose) => {
    Swal.fire({
        title: title,
        html: html,
        background: "#F8D7A5",
        width: '70vw',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
    }).then(onClose);
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

const copyCurrentPageLink = () => {
    let currentPageLink = window.location.href;
    navigator.clipboard.writeText(currentPageLink)
        .then(function() {
            showToast("success", "Link copiato nella clipboard");
        })
        .catch(function(err) {
            console.error("Impossibile copiare il link nella clipboard: ", err);
        });
}

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

const setCookie = (cookieName, element) => {
    const now = new Date();
    const expirationTime = new Date(now.getTime() + 1 * 60 * 60 * 1000); // 1 hour
    const listaString = JSON.stringify(element);
    document.cookie = `${cookieName}=${listaString}; expires=${expirationTime.toUTCString()}; path=/`;
};

const getCookie = (cookieName) => {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');

    for(let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return null;
};

const deleteCookie = (cookieName) => {
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
};

const setCookiesAndGoToHome = (cookieName, element) => {
    setCookie(cookieName, element);
    window.location.href = "home.php";
};

const watchGnamsFrom = (id, result) => {
    const cookieData = {
        startFrom: id,
        list: result.map(item => item.id)
    };
    setCookiesAndGoToHome('gnamsToWatch', cookieData);
};

const readAndDeleteCookie = (cookieName) => {
    const cookieValue = getCookie(cookieName);
    if (cookieValue !== null) {
        deleteCookie(cookieName);
    }
    return cookieValue;
};