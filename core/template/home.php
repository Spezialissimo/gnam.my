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
    let selectedPortions = 1;
    let commentToReplyID = null;

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

    const drawAllIngredients = (e) => {
        let ingredients = [`
            <div class="row m-0 p-0 align-items-center">
                <div class="col-8 m-0 p-1 d-flex align-items-center justify-content-start">
                    <p class="m-0 fs-6">Cannella</p>
                </div>
            <div class="col-4 m-0 p-1 d-flex align-items-center justify-content-end">
                    <p class="m-0 fs-6 fw-bold ">50 gr.</p>
                </div>
            </div>`];
        ingredients.forEach(i => $("#ingredients").append(i));
    }

    const publishComment = (e) => {
        const username = 'admin';
        const commentText = $("#commentField").val();
        let comment = `<div id="comment-0 class="container comment">
                                        <div class="row">
                                        <div class="col-2 p-0">
                                        <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                                    src="assets/prova-profile.png" />
                                            </div>
                                            <div class="col">
                                                <div class="row-md-1 text-start">
                                                    <a href="/profile.php" class="commenterName text-link">` + username + `</a>
                                                </div>
                                                <div class="row-md text-normal-black fs-7 text-start">
                                                <p class="m-0">` + commentText + `</p>
                                                </div>
                                                <div class="row-md-1 text-start">
                                                    <span class="text-button fw-bold color-accent fs-7 ">Rispondi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
        $(".comment:last").append(comment);
    }

    $(window).on("load", function() {
        isDescriptionShort = true;
        $("#videoDescription").on("click", showFullDescription);
        $("#videoTags").on("click", showFullDescription);
        $("#videoOverlay").on("click", showShortDescription);
        $("#recipeButton").on("click", function() {
            let html = `
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <p class="m-0 me-2 fs-6">Numero di porzioni:</p>
                    <div class="mx-0 ps-0">
                        <select class="form-select bg-primary rounded shadow-sm fs-6" id="portionsSelect">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="row mx-0 my-2">
                    <div class="col-6 d-flex align-items-center justify-content-start">
                        <p class="m-0 p-0 fs-6 fw-bold">Nome:</p>
                    </div>
                    <div class="col-6 d-flex align-items-center justify-content-end">
                        <p class="m-0 p-0 fs-6 fw-bold">Quantità</p>
                    </div>
                </div>
                <hr class="my-2">
                <div class="text-center" id="ingredients">
                </div>
                <hr class="m-0 mt-2">
                </div>
            `;
            showSwal('Ricetta', html);
            $('#portionsSelect option[value="' + selectedPortions + '"]').attr("selected", true);
            $("#portionsSelect").on("change", function(e) {
                $("#ingredients").empty();
                selectedPortions = this.value;
                drawAllIngredients();
            });
            drawAllIngredients();
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

        $("#commentsButton").on("click", function() {
            let html = `
                <div class="container modal-content-lg">
                    <div class="row-8">
                        <div class="container>
                            <div class="col">
                                <div class="row">

                                    <!-- Commento -->
                                    <div id="comment-0" class="container comment">
                                        <div class="row">
                                            <div class="col-2 p-0">
                                            <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                                        src="assets/prova-profile.png" />
                                            </div>
                                            <div class="col">
                                                <div class="row-md-1 text-start">
                                                    <a href="/profile.php" class="commenterName text-link">CiccioGamer89</a>
                                                </div>
                                                <div class="row-md text-normal-black fs-7 text-start">
                                                <p class="m-0">ad un certo punto ho scritto: con tutto quello che mi è costata quella
                                                        crostata, e
                                                        guardando,
                                                        ho notato che costata... e crostata... hanno di differenza solo una lettera, e questo
                                                        per me
                                                        è incredibile cioè, va bene che 1+1 fa 2, ma questa è una scoperta pazzesca cioè...
                                                        ragazzi... vi potete vantare tutta una vita, l\'abbiamo scoperta noi paguri questa
                                                        cosa...
                                                        costata... cro cioè crostata... ragazzi è pazzesco, pazzesco</p>
                                                </div>
                                                <div class="row-md-1 text-start">
                                                    <span class="replyButton text-button fw-bold color-accent fs-7 ">Rispondi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Commento con risposta -->
                                    <div id="comment-1" class="container comment">
                                        <div class="row">
                                            <div class="col-2 p-0">
                                                <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                                        src="assets/prova-profile.png" />
                                                        </div>
                                                <div class="col">
                                                    <div class="row-md-1 text-start">
                                                        <a href="/profile.php" class="commenterName text-link">Pello</a>
                                                        </div>
                                                        <div class="row-md text-normal-black fs-7 text-start">
                                                        <p class="m-0">sono gay sono gay sono gay sono gay sono gay sono gay sono gay sono gay sono
                                                        gay sono gay sono gay sono gay sono gay sono gay sono gay sono gay sono gay sono gay
                                                            sono gay sono gay sono gay sono gay sono</p>
                                                            </div>
                                                            <div class="row-md-1 text-start">
                                                        <span class="replyButton text-button fw-bold color-accent fs-7">Rispondi</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2"></div>
                                                <div class="col">
                                                <!-- Sottocommento -->
                                                    <div id="comment-2" class="container subcomment">
                                                        <div class="row">
                                                            <div class="col-1 p-0">
                                                                <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                                                    src="assets/prova-profile.png" />
                                                            </div>
                                                            <div class="col ps-1">
                                                                <div class="row-md-1 text-start">
                                                                    <a href="/profile.php" class="commenterName text-link">Pier</a>
                                                                </div>
                                                                <div class="row-md text-normal-black fs-7 text-start">
                                                                    <p class="m-0">Io di più</p>
                                                                </div>
                                                                <div class="row-md-1 text-start">
                                                                    <span class="replyButton text-button fw-bold color-accent fs-7">Rispondi</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-1 bg-primary rounded">
                        <div class="rounded bg-primary p-1 d-none"  id="replyToDiv">
                            <div class="rounded bg container">
                                <div class="row">
                                    <div class="col-11 align-items-center">
                                        <span class="border-0 fs-7">Stai rispondendo a: <span id="replyToName" class="text-link"></span></span>
                                    </div>
                                    <div class="col-1 d-flex align-items-center p-0">
                                        <i id="closeReplyTo" class="fa-solid fa-xmark color-accent"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group rounded">
                            <input id="commentField" type="text" class="fs-7 form-control bg-primary shadow-sm" placeholder="Insercisci commento...">
                            <span id="commentButton" class="input-group-text bg-primary border-0  fs-7">Commenta</span>
                        </div>
                    </div>
                </div>`;

                showSwal('Commenti', html);
                $("#commentButton").on("click", publishComment);
                $("#closeReplyTo").on("click", function (e) {
                    $("#replyToDiv").addClass("d-none");
                    commentToReplyID = null;
                });
                $(".replyButton").on("click", function (e) {
                    let parent = $(this).closest('.subcomment');

                    if (parent.length == 0) {
                        parent = $(this).closest('.comment');
                    }
                    const commenterName = parent.find(".commenterName:first").text();
                    $("#replyToDiv").removeClass("d-none");
                    $("#replyToName").text(commenterName);
                    commentToReplyID = parent.attr("id");
                })
        });
    });


    const showSwalShare = (e) => {
        let swalContent = '<div class=\'row-md-2 py-2 text-center text-black\'><div class=\'container\'><div class=\'col\'><div class=\'row-9 py-4\'><i class=\'fa-solid fa-share-nodes fa-2xl\'></i></div><div class=\'row-3 pt-3\'><button type=\'button\' class=\'btn btn-bounce rounded-pill bg-accent fw-bold text-white\'>Copia link</button></div></div></div></div>';
        showSwalSmall('Condividi Gnam', swalContent);
    }

    $("#shareButton").on("click", showSwalShare);
</script>