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

let isDescriptionShort = true;
const showFullDescription = () => {
    isDescriptionShort = false;
    $("#videoDescriptionShort").addClass("d-none");
    $("#videoDescriptionLong").removeClass("d-none");
    $("#moreTagsButton").addClass("d-none");
    let videoTags = $("[id='videoTag']");
    for (let i = 0; i < videoTags.length; i++) {
        $(videoTags[i]).removeClass("d-none");
    }
}

const showShortDescription = () => {
    isDescriptionShort = true;
    $("#videoDescriptionLong").addClass("d-none");
    $("#videoDescriptionShort").removeClass("d-none");
    $("#moreTagsButton").removeClass("d-none");
    let videoTags = $("[id='videoTag']");
    for (let i = 2; i < videoTags.length; i++) {
        $(videoTags[i]).addClass("d-none");
    }
}

$(window).on("load resize change", resizeContentDiv);
$(window).on("load", function() {
    $("#videoCaption").on("click", function() {
        if (isDescriptionShort) {
            showFullDescription();
        } else {
            showShortDescription();
        }
    });
    $("#videoOverlay").on("click", function() {
        if (!isDescriptionShort) {
            showFullDescription();
        }
    });
    $("#likeButton").on("click", function() {
        let likeButton = $("#likeButton").children().children();
        if (likeButton.hasClass("color-secondary")) {
            likeButton.removeClass("color-secondary");
            likeButton.addClass("color-alert");
        } else {
            likeButton.addClass("color-secondary");
            likeButton.removeClass("color-alert");
        }
    });
});
