const showSwal = (title, html, onClose) => {
    Swal.fire({
        title: title,
        html: html,
        background: "#F7D197",
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: true,
        closeButtonAriaLabel: "Chiudi il popup",
        didOpen: () => {
            const modal = Swal.getPopup();
            modal.setAttribute('aria-live', 'off');
        },
        didClose: () => {
            if (onClose) {
                onClose();
            }
        }
    })
};

const showSmallSwal = (title, html, onClose) => {
    Swal.fire({
        title: title,
        html: html,
        customClass: "swal-small",
        background: "#F7D197",
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        closeButtonAriaLabel: "Chiudi il popup",
        didClose: () => {
            if (onClose) {
                onClose();
            }
        }
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
    }).then(() => {
        if (redirectURL) {
            window.location.href = redirectURL;
        }
    });
}

const closeSwal = () => {
    Swal.close();
};

const copyToClipboard = (textToCopy) => {
    const tempInput = document.createElement("input");
    tempInput.value = textToCopy;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    showToast("success", "Link copiato nella clipboard");
}

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

const setGnamsToWatchFrom = (id, result) => {
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