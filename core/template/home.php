<div class="swiper h-100">
    <div id="gnamSlider" class="swiper-wrapper">
        <!-- TODO dummy -->
        <div id="dummySlide" class="swiper-slide">
            <video id="gnamPlayer" class="w-100 h-100 object-fit-fill p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/gnams_thumbnails/1.jpg" src="assets/gnams/1.mp4"></video>
            <div class="video-overlay" id="videoOverlay">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-10 align-self-end">
                            <a href="profile.php" class="row text-link">
                                <div class="col-3">
                                    <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/profile_pictures/1.jpg" />
                                </div>
                                <div class="col-9 d-flex align-items-center p-0">
                                    <p class="fs-6 fw-bold m-0">name</p>
                                </div>
                            </a>
                            <div class="row" id="videoDescription">
                                <span class="fs-7 m-0" id="videoDescriptionShort">description
                                    <span class="fs-7 m-0 color-accent">Leggi di piú...</span>
                                </span>
                                <p class="fs-7 m-0 d-none" id="videoDescriptionLong">description</p>
                            </div>
                            <div class="row" id="videoTags">
                                <div class="col-4" class="videoTag">
                                    <span class="badge rounded-pill bg-primary fw-light text-black">
                                        <i class="fa-solid fa-oil-can"></i>tag1
                                    </span>
                                </div>
                                <div class="col-4 d-none" class="videoTag">
                                    <span class="badge rounded-pill bg-primary fw-light text-black">
                                        <i class="fa-solid fa-leaf"></i>tag2
                                    </span>
                                </div>
                                <div class="col-2 pe-0" id="moreTagsButton">
                                    <span class="badge rounded-pill bg-primary fw-light text-black">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="container p-0">
                                <div class="col">
                                    <div class="row pb-4" id="recipeButton">
                                        <span><i class="fa-solid fa-utensils fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row" id="likeButton">
                                        <span><i class="fa-solid fa-heart fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="likesCounter">10</span>
                                    </div>
                                    <div class="row pt-2" id="commentsButton">
                                        <span><i class="fa-solid fa-comment-dots fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="commentsCounter">10</span>
                                    </div>
                                    <div class="row pt-2" id="shareButton">
                                        <span><i class="fa-solid fa-share-nodes fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="shareCounter">10</span>
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
<script>
    // TODO alt alle immagini

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'vertical',
        loop: false,
    });



    let isDescriptionShort = true;
    let selectedPortions = 1;
    let commentToReplyID = null;
    let commentIndex = 3;
    let currentGnamID = null;
    let currentUserID = null;

    const showFullDescription = (e) => {
        if (isDescriptionShort) {
            isDescriptionShort = false;
            $("#videoDescriptionShort-" + currentGnamID).addClass("d-none");
            $("#videoDescriptionLong-" + currentGnamID).removeClass("d-none");
            $("#moreTagsButton-" + currentGnamID).addClass("d-none");
            let videoTags = $(".videoTag");
            for (let i = 0; i < videoTags.length; i++) {
                $(videoTags[i]).removeClass("d-none");
            }
            $("#videoOverlay-" + currentGnamID).css("background-image", "linear-gradient(0deg, var(--background), rgba(248, 215, 165, 0) 40%)");
            e.stopPropagation();
        }
    }

    const showShortDescription = (e) => {
        if (!isDescriptionShort) {
            isDescriptionShort = true;
            $("#videoDescriptionLong-" + currentGnamID).addClass("d-none");
            $("#videoDescriptionShort-" + currentGnamID).removeClass("d-none");
            $("#moreTagsButton-" + currentGnamID).removeClass("d-none");
            let videoTags = $(".videoTag");
            for (let i = 2; i < videoTags.length; i++) {
                $(videoTags[i]).addClass("d-none");
            }
            $("#videoOverlay-" + currentGnamID).css("background-image", "linear-gradient(0deg, var(--background), rgba(248, 215, 165, 0) 30%)");
            e.stopPropagation();
        }
    }

    const showSwalShare = () => {
        let swalContent = `
            <div class='row-md-2 py-2 text-center text-black'>
                <div class='container'>
                    <div class='col'>
                        <div class='row-9 py-4'><i class='fa-solid fa-share-nodes fa-2xl'></i></div>
                        <div class='row-3 pt-3'><button type='button' class='btn btn-bounce rounded-pill bg-accent fw-bold
                                text-white' id="copyGnamLinkButton">Copia link</button></div>
                    </div>
                </div>
            </div>
        `;
        showSwalSmall('<p class="fs-5">Condividi Gnam</p>', swalContent);
        $("#copyGnamLinkButton").on("click", function() {
            $("#shareCounter-" + currentGnamID).text(parseInt($("#shareCounter-" + currentGnamID).text()) + 1);
            let gnamLink = buildURL("home", "gnam=" + currentGnamID);
            navigator.clipboard.writeText(gnamLink)
                .then(function() {
                    showToast("success", "Link copiato nella clipboard");
                })
                .catch(function(err) {
                    console.error("Impossibile copiare il link nella clipboard: ", err);
                });
        });
    }


    const drawAllIngredients = (recipe) => {
        $("#ingredients-" + currentGnamID).empty();
        let ingredientsHTML = "";
        recipe.forEach(ingredient => {

            ingredientsHTML += `
            <div class="row m-0 p-0 align-items-center">
                <div class="col-8 m-0 p-1 d-flex align-items-center justify-content-start">
                    <p class="m-0 fs-6">${ingredient["name"]}</p>
                </div>
                <div class="col-4 m-0 p-1 d-flex align-items-center justify-content-end">
                    <p class="m-0 fs-6 fw-bold ">${ingredient["quantity"]} ${ingredient["measurement_unit"]}</p>
                </div>
            </div>`;
        });
        $("#ingredients-" + currentGnamID).append(ingredientsHTML);
    }

    const replyButtonHandler = (e) => {
        let parent = $(e.target).closest('.subcomment');
        if (parent.length == 0) {
            parent = $(e.target).closest('.comment');
        }
        const commenterName = parent.find(".commenterName:first").text();
        $("#replyToDiv").removeClass("d-none");
        $("#replyToName").text(commenterName);
        commentToReplyID = parent.attr("id");
    }

    const publishComment = () => {
        const username = 'admin';
        const commentText = $("#commentField").val();
        if (commentText.length === 0) return;
        if (commentToReplyID == null) {
            let comment =
                `<div id="comment-${commentIndex}" class="container comment">
                    <div class="row">
                        <div class="col-2 p-0">
                        <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                    src="assets/profile_pictures/prova.png" />
                        </div>
                        <div class="col">
                            <div class="row-md-1 text-start">
                                <a href="/profile.php" class="commenterName text-link"> ${username}</a>
                            </div>
                            <div class="row-md text-normal-black fs-7 text-start">
                            <p class="m-0">${commentText}</p>
                            </div>
                            <div class="row-md-1 text-start">
                                <span class="replyButton text-button fw-bold color-accent fs-7 ">Rispondi</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            $(".comment:last").append(comment);
        } else {
            let comment = `
                <div id="comment-${commentIndex}" class="container subcomment">
                    <div class="row">
                        <div class="col-1 p-0">
                            <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne"
                                src="assets/profile_pictures/prova.png" />
                        </div>
                        <div class="col ps-1">
                            <div class="row-md-1 text-start">
                                <a href="/profile.php" class="commenterName text-link">${username}</a>
                            </div>
                            <div class="row-md text-normal-black fs-7 text-start">
                                <p class="m-0">${commentText}</p>
                            </div>
                            <div class="row-md-1 text-start">
                                <span class="replyButton text-button fw-bold color-accent fs-7">Rispondi</span>
                            </div>
                        </div>
                    </div>
                </div>`;

            const $commentToReply = $("#" + commentToReplyID);
            if ($commentToReply.hasClass("subcomment")) {
                const $parent = $commentToReply.parent();
                const shouldAppend = $commentToReply.siblings().length === 0;
                shouldAppend ? $parent.append(comment) : $parent.append(comment);
            } else if ($commentToReply.find(".subcomment").length > 0) {
                $commentToReply.find(".subcomment:last").parent().append(comment);
            } else {
                const prefix = `<div class="row"><div class="col-2"></div><div class="col">`;
                const suffix = `</div></div>`;
                $commentToReply.append(prefix + comment + suffix);
            }

        }

        commentIndex++;
        hideReplyToBox();
        $("#commentsCounter").text(parseInt($("#commentsCounter").text()) + 1);
        $("#commentField").val("");
        $(".replyButton").on("click", replyButtonHandler);
    }

    const hideReplyToBox = () => {
        $("#replyToDiv").addClass("d-none");
        commentToReplyID = null;
    }

    const buildURL = (siteSection, query) => {
        return window.location.href.split("home")[0] + siteSection + ".php?" + query;
    }

    const redirectToCurrentGnamUserPage = () => {
        let redirectPath = buildURL("profile", "user=" + currentUserID);
        window.location.href = redirectPath;
    }

    const setCurrent = (gnamID, userID) => {
        currentGnamID = gnamID;
        currentUserID = userID;
    }

    const setComments = (comments) => {
        $("#commentsCounter-" + currentGnamID).text(comments.length);
        $("#commentsButton-" + currentGnamID).on('click', function() {
            let commentContainerHTML = `
                <div class="row-8">
                    <div class="container>
                        <div class="col">
                            <div id="commentsContainer" class="row">

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
                        <input id="commentField" type="text" class="fs-7 form-control bg-primary shadow-sm" placeholder="Insercisci commento..." />
                        <span id="commentButton" class="input-group-text bg-primary border-0 fs-7 fw-bold">Commenta</span>
                    </div>
                </div>`;

            let commentsContainerElement = document.createElement('div');
            commentsContainerElement.classList.add("container", "modal-content-lg");
            commentsContainerElement.innerHTML = commentContainerHTML.trim();

            comments.sort((a, b) => {
                if (a.parent_comment_id === null && b.parent_comment_id !== null) {
                    return -1;
                } else if (a.parent_comment_id !== null && b.parent_comment_id === null) {
                    return 1;
                } else {
                    return 0;
                }
            });
            debugger;


            comments.forEach(comment => {
                if (comment['parent_comment_id'] == null) {
                    let commentHTML = `
                        <div id="comment-${comment['id']}" class="container comment">
                            <div class="row">
                                <div class="col-2 p-0">
                                <img class="border border-2 border-dark rounded-circle w-100" alt="${comments['user_name']}"
                                            src="assets/profile_pictures/${comments['user_id']}.png" />
                                </div>
                                <div class="col">
                                    <div class="row-md-1 text-start">
                                        <p class="text-link">${comments['user_name']}</a>
                                    </div>
                                    <div class="row-md text-normal-black fs-7 text-start">
                                    <p class="m-0">${comments['text']}</p>
                                    </div>
                                    <div class="row-md-1 text-start">
                                        <span class="replyButton text-button fw-bold color-accent fs-7 ">Rispondi</span>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    commentsContainerElement.querySelector('#commentsContainer').innerHTML = commentHTML;
                } else {
                    let commentHTML = `
                        <div id="comment-${comment['id']}" class="container subcomment">
                            <div class="row">
                                <div class="col-1 p-0">
                                <img class="border border-2 border-dark rounded-circle w-100" alt="${comments['user_name']}"
                                            src="assets/profile_pictures/${comments['user_id']}.png" />
                                </div>
                                <div class="col">
                                    <div class="row-md-1 text-start">
                                        <p class="text-link">${comments['user_name']}</a>
                                    </div>
                                    <div class="row-md text-normal-black fs-7 text-start">
                                    <p class="m-0">${comments['text']}</p>
                                    </div>
                                    <div class="row-md-1 text-start">
                                        <span class="replyButton text-button fw-bold color-accent fs-7 ">Rispondi</span>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }

                showSwal('Commenti', commentsContainerElement.outerHTML);
                $("#commentButton-" + currentGnamID).on("click", publishComment);
                $("#closeReplyTo-" + currentGnamID).on("click", hideReplyToBox);
                $(".replyButton-" + currentGnamID).on("click", replyButtonHandler);
            });
        });
    }

    const setInteractableItems = (comments, recipe) => {
        // TODO likes API
        $("[id^='likeButton-']").each(function() {
            let likeButton = $(this);
            let children = likeButton.children().children();
            let likesCounter = $("#likesCounter-" + currentGnamID);

            likeButton.on("click", function() {
                if (children.hasClass("color-secondary")) {
                    children.removeClass("color-secondary").addClass("color-alert");
                    likesCounter.text(parseInt(likesCounter.text()) + 1);
                } else {
                    children.addClass("color-secondary").removeClass("color-alert");
                    likesCounter.text(parseInt(likesCounter.text()) - 1);
                }
            });
        });

        // TODO secondo me mettendo gli onclik a immagine e username si puo usare il click su tutta l'area
        isDescriptionShort = true;
        $("#videoDescriptionShort-" + currentGnamID).on("click", showFullDescription);
        $("#videoTags-" + currentGnamID).on("click", showFullDescription);
        $("#videoOverlay-" + currentGnamID).on("click", showShortDescription);

        $("#shareButton-" + currentGnamID).on("click", showSwalShare);

        $("#recipeButton-" + currentGnamID).on("click", function() {
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
                <hr class="my-2" />
                <div class="text-center" id="ingredients-${currentGnamID}">
                </div>
                <hr class="m-0 mt-2" />
                </div>
            `;
            showSwal('Ricetta', html);
            $('#portionsSelect option[value="' + selectedPortions + '"]').attr("selected", true);
            $("#portionsSelect").on("change", function(e) {
                recipeWithUpdatedPortion = JSON.parse(JSON.stringify(recipe));
                recipeWithUpdatedPortion.forEach(ingredient => {
                    ingredient['quantity'] = ingredient['quantity'] * (this).value;
                });
                drawAllIngredients(recipeWithUpdatedPortion);
            });
            drawAllIngredients(recipe);
        });

        $("#userImage-" + currentGnamID).on("click", function() {
            redirectToCurrentGnamUserPage();
        });

        $("#userName-" + currentGnamID).on("click", function() {
            redirectToCurrentGnamUserPage();
        });
    }

    const addGnamSlide = (gnamsInfo) => {
        let gnamHtml = `
            <video id="gnamPlayer-${gnamsInfo['id']}" class="w-100 h-100 object-fit-fill p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/gnams_thumbnails/${gnamsInfo['id']}.jpg" src="assets/gnams/${gnamsInfo['id']}.mp4"></video>
            <div  id="videoOverlay-${gnamsInfo['id']}" class="video-overlay">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-10 align-self-end">
                            <div class="row text-link">
                                <div class="col-3">
                                    <img id="userImage-${gnamsInfo['id']}" class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/profile_pictures/${gnamsInfo['user_id']}.jpg" />
                                </div>
                                <div class="col-9 d-flex align-items-center p-0">
                                    <p id="userName-${gnamsInfo['id']}" class="fs-6 fw-bold m-0">${gnamsInfo['user_name']}</p>
                                </div>
                            </div>
                            <div class="row" id="videoDescription">
                                <span id="videoDescriptionShort-${gnamsInfo['id']}" class="fs-7 m-0">${gnamsInfo['short_description']}
                                    <span class="fs-7 m-0 color-accent">Leggi di piú...</span>
                                </span>
                                <p id="videoDescriptionLong-${gnamsInfo['id']}" class="fs-7 m-0 d-none">${gnamsInfo['description']}</p>
                            </div>
                            <div class="row" id="videoTags-${gnamsInfo['id']}">

                            </div>
                        </div>
                        <div class="col-2">
                            <div class="container p-0">
                                <div class="col">
                                    <div class="row pb-4" id="recipeButton-${gnamsInfo['id']}">
                                        <span><i class="fa-solid fa-utensils fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row" id="likeButton-${gnamsInfo['id']}">
                                        <span><i class="fa-solid fa-heart fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="likesCounter-${gnamsInfo['id']}">${gnamsInfo['likes_count']}</span>
                                    </div>
                                    <div class="row pt-2" id="commentsButton-${gnamsInfo['id']}">
                                        <span><i class="fa-solid fa-comment-dots fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="commentsCounter-${gnamsInfo['id']}">0</span>
                                    </div>
                                    <div class="row pt-2" id="shareButton-${gnamsInfo['id']}">
                                        <span><i class="fa-solid fa-share-nodes fa-2xl fa-fw color-secondary"></i></span>
                                    </div>
                                    <div class="row pt-2 color-accent fw-bold text-center">
                                        <span id="shareCounter-${gnamsInfo['id']}">${gnamsInfo['shares_count']}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
        const slideElement = document.createElement('div');
        slideElement.classList.add("swiper-slide");
        slideElement.innerHTML = gnamHtml.trim();

        let count = 0;
        let tagHTML = '';

        gnamsInfo['tags'].forEach(tag => {
            let tagText = tag['text'];

            if (count < 2) {
                tagHTML += `
                    <div class="col-4 videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-oil-can"></i> ${tagText}
                        </span>
                    </div>`;
            } else {
                tagHTML += `
                    <div class="col-4 d-none videoTag">
                        <span class="badge rounded-pill bg-primary fw-light text-black">
                            <i class="fa-solid fa-leaf"></i> ${tagText}
                        </span>
                    </div>`;
            }
            count++;

        });

        tagHTML += `
            <div class="col-2 pe-0" id="moreTagsButton-${gnamsInfo['id']}">
                <span class="badge rounded-pill bg-primary fw-light text-black">
                    <i class="fa-solid fa-ellipsis"></i>
                </span>
            </div>`;

        slideElement.querySelector('#videoTags-' + gnamsInfo['id']).innerHTML = tagHTML;

        if ($("#gnamSlider #dummySlide").length > 0) {
            $("#gnamSlider #dummySlide").remove();
        }
        $("#gnamSlider").append(slideElement);
    }


    $(window).on("load", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('gnam')) {
            $.get("api/gnams.php", {
                api_key: "<?php echo $_SESSION['api_key']; ?>",
                gnam: urlParams.get('gnam')
            }, function(data) {
                gnamInfo = JSON.parse(data);
                setCurrent(gnamInfo['id'], gnamInfo['user_id']);
                addGnamSlide(gnamInfo);
                setInteractableItems(gnamInfo['recipe']);

                $.get("api/comments.php", {
                    api_key: "<?php echo $_SESSION['api_key']; ?>",
                    gnam_id: urlParams.get('gnam')
                }, function(commentsData) {
                    comments = JSON.parse(commentsData);
                    setComments(comments);
                });
            });
        } else {
            $.get("api/search.php", {
                api_key: "<?php echo $_SESSION['api_key']; ?>",
                action: 'random'
            }, function(data) {
                var gnams_id = JSON.parse(data);

                gnams_id.forEach(function(id) {
                    $.get("api/gnams.php", {
                        api_key: "<?php echo $_SESSION['api_key']; ?>",
                        gnam: id
                    }, function(gnamsData) {

                    });
                });
            });

        }

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
                                                        src="assets/profile_pictures/prova.png" />
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
                                                        src="assets/profile_pictures/prova.png" />
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
                                                                    src="assets/profile_pictures/prova.png" />
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
                            <input id="commentField" type="text" class="fs-7 form-control bg-primary shadow-sm" placeholder="Insercisci commento..." />
                            <span id="commentButton" class="input-group-text bg-primary border-0 fs-7 fw-bold">Commenta</span>
                        </div>
                    </div>
                </div>`;

            showSwal('Commenti', html);
            $("#commentButton").on("click", publishComment);
            $("#closeReplyTo").on("click", hideReplyToBox);
            $(".replyButton").on("click", replyButtonHandler);
        });

    });
</script>