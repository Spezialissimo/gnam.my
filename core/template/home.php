<video class="w-100 h-100 object-fit-fill p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/prova.png" src="assets/prova.mp4"></video>
<div class="video-overlay" id="videoOverlay">
    <div class="container">
        <div class="row mb-3">
            <div class="col-10 align-self-end">
                <a href="profile.php" class="row text-link">
                    <div class="col-3">
                        <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/prova-profile.png" />
                    </div>
                    <div class="col-9 d-flex align-items-center p-0">
                        <p class="fs-6 fw-bold m-0">Profilo Nome</p>
                    </div>
                </a>
                <div class="row" id="videoDescription">
                    <p class="fs-7 m-0" id="videoDescriptionShort">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis blandit, tortor ut gravida pellentesque, risus. Leggi di piú...</p>
                    <p class="fs-7 m-0 d-none" id="videoDescriptionLong">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada pharetra odio lobortis vulputate. Aliquam maximus ac nibh semper placerat. Maecenas pellentesque elementum auctor. Cras vel venenatis urna.</p>
                </div>
                <div class="row" id="videoTags">
                    <div class="col-4" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-oil-can"></i>&nbsp #Untazzo
                        </span>
                    </div>
                    <div class="col-4" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                        </span>
                    </div>
                    <div class="col-4 d-none" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                        </span>
                    </div>
                    <div class="col-4 d-none" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                        </span>
                    </div>
                    <div class="col-4 d-none" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                        </span>
                    </div>
                    <div class="col-4 d-none" id="videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                        </span>
                    </div>
                    <div class="col-2 ps-0" id="moreTagsButton">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-ellipsis"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="container p-0">
                    <div class="col">
                        <div class="row pt-4" id="likeButton">
                            <span><i class="fa-solid fa-heart fa-2xl fa-fw color-secondary"></i></span>
                        </div>
                        <div class="row pt-4" id="recipeButton">
                            <span><i class="fa-solid fa-utensils fa-2xl fa-fw color-secondary"></i></span>
                        </div>
                        <div class="row pt-4" id="commentsButton">
                            <span><i class="fa-solid fa-comment-dots fa-2xl fa-fw color-secondary"></i></span>
                        </div>
                        <div class="row pt-4" id="shareButton">
                            <span><i class="fa-solid fa-share-nodes fa-2xl fa-fw color-secondary"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    $(window).on("load", function() {
        isDescriptionShort = true;
        $("#videoDescription").on("click", showFullDescription);
        $("#videoTags").on("click", showFullDescription);
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


    const showSwalShare = (e) => {
        let swalContent = '<div class=\'row-md-2 py-2 text-center text-black\'><div class=\'container\'><div class=\'col\'><div class=\'row-9 py-4\'><i class=\'fa-solid fa-share-nodes fa-2xl\'></i></div><div class=\'row-3 pt-3\'><button type=\'button\' class=\'btn btn-bounce rounded-pill bg-accent fw-bold text-white\'>Copia link</button></div></div></div></div>';
        showSwalSmall('Condividi Gnam', swalContent);
    }

    $("#shareButton").on("click", showSwalShare);
</script>