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
const showFullDescription = (e) => {
    if (isDescriptionShort) {
        isDescriptionShort = false;
        $("#videoDescriptionShort").addClass("d-none");
        $("#videoDescriptionLong").removeClass("d-none");
        $("#moreTagsButton").addClass("d-none");
        let videoTags = $("[id='videoTag']");
        for (let i = 0; i < videoTags.length; i++) {
            $(videoTags[i]).removeClass("d-none");
        }
        e.stopPropagation();
    }
}

const showShortDescription = (e) => {
    if (!isDescriptionShort) {
        isDescriptionShort = true;
        $("#videoDescriptionLong").addClass("d-none");
        $("#videoDescriptionShort").removeClass("d-none");
        $("#moreTagsButton").removeClass("d-none");
        let videoTags = $("[id='videoTag']");
        for (let i = 2; i < videoTags.length; i++) {
            $(videoTags[i]).addClass("d-none");
        }
        e.stopPropagation();
    }
}

$(window).on("load resize change", resizeContentDiv);
$(window).on("load", function() {
    isDescriptionShort = true;
    $("#videoCaption").on("click", showFullDescription);
    $("#videoOverlay").on("click", showShortDescription);
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
