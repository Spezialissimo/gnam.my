<div class="swiper">
    <div id="gnamSlider" class="swiper-wrapper"></div>
</div>
<script>
    let isDescriptionShort = true;
    let selectedPortions = 1;
    let commentToReplyID = null;
    let currentGnamID = null;
    let gnamsQueue = null;
    let firstSlideIndex = 0;
    let threshold = 5;
    let gnamsLeft = threshold;
    let wentUp = false;
    let swiper;

    const initializeSwiper = () => {
        swiper = new Swiper('.swiper', {
            initialSlide: firstSlideIndex,
            direction: 'vertical',
            width: "90vh",
            a11y: false,
            loop: false,
            keyboard: {
                enabled: true
            },
            on: {
                slideChangeTransitionEnd: function() {
                    if ($(".swiper-slide-active").length != 0) {
                        stopCurrentVideo();
                        $("#gnamPlayer-" + currentGnamID)[0].currentTime = 0;
                        setTabIndexOnCurrentGnam(-1);
                        currentGnamID = $(".swiper-slide-active").attr('id').split('-')[1];
                        setTabIndexOnCurrentGnam(3);
                        $("#gnam-" + currentGnamID).focus();
                        playCurrentVideo();
                    }
                },
                slideNextTransitionEnd: function() {
                    const currentIndex = gnamsQueue.findIndex(item => item[0] === parseInt(currentGnamID));
                    let newIndex = currentIndex + Math.floor(threshold / 2);
                    if (newIndex < gnamsQueue.length && !gnamsQueue[newIndex][1]) {
                        drawGnam(newIndex);
                    }
                },
                slidePrevTransitionEnd: function() {
                    const currentIndex = gnamsQueue.findIndex(item => item[0] === parseInt(currentGnamID));
                    let newIndex = Math.max(0, currentIndex - Math.floor(threshold / 2));
                    if (newIndex >= 0 && !gnamsQueue[newIndex][1]) {
                        wentUp = true;
                        drawGnam(newIndex);
                    }
                },
                beforeInit: function() {
                    document.querySelectorAll('[id^="gnam-"]').forEach(element => {
                        element.classList.remove('d-none');
                    });
                    setTabIndexOnCurrentGnam(3);
                }
            }
        });
    }

    const setTabIndexOnCurrentGnam = (value) => {
        $("#gnam-" + currentGnamID).attr('tabindex', value - 1);
        $("#descriptionBox-" + currentGnamID + " > div:first-child").attr('tabindex', value);
        $("#videoDescriptionShort-" + currentGnamID).attr('tabindex', value);
        $(".videoTag-" + currentGnamID).attr('tabindex', value);
        $("#recipeButton-" + currentGnamID).attr('tabindex', value);
        $("#likeButton-" + currentGnamID).attr('tabindex', value);
        $("#commentsButton-" + currentGnamID).attr('tabindex', value);
        $("#shareButton-" + currentGnamID).attr('tabindex', value);
    }

    $(window).on("load", function() {

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('gnam')) {
            gnamsQueue = [
                [(urlParams.get('gnam')), false]
            ];
            currentGnamID = urlParams.get('gnam');
            drawFirstGnams();
        } else {
            gnamsInCookies = JSON.parse(readAndDeleteCookie('gnamsToWatch'));
            if (gnamsInCookies == null) {
                $.get("api/search.php", {
                    api_key: "<?php echo $_SESSION['api_key']; ?>",
                    action: 'random'
                }, function(data) {
                    gnamsQueue = JSON.parse(data);
                    currentGnamID = gnamsQueue[0];
                    for (let i = 0; i < gnamsQueue.length; i++) {
                        const element = gnamsQueue[i];
                        newArray = [element, false];
                        gnamsQueue[i] = newArray;
                    }
                    drawFirstGnams();
                });
            } else {
                gnamsQueue = [];
                currentGnamID = gnamsInCookies['startFrom'];
                let firstGnamIndex = 0;
                for (let i = 0; i < gnamsInCookies['list'].length; i++) {
                    const element = gnamsInCookies['list'][i];
                    newArray = [element, false];
                    gnamsQueue[i] = newArray;
                    if (element == gnamsInCookies['startFrom']) {
                        firstGnamIndex = i
                    }
                }
                firstSlideIndex = Math.min(firstGnamIndex, Math.floor(threshold / 2));
                drawFirstGnams();
            }
        }

        $("#gnamSlider").on('click', function() {
            let gnamPlayer = $("#gnamPlayer-" + currentGnamID)[0];

            if (gnamPlayer.paused) {
                gnamPlayer.play();
            } else {
                gnamPlayer.pause();
            }
        });
    });

    const drawFirstGnams = () => {
        const firstIndex = gnamsQueue.findIndex(item => item[0] == parseInt(currentGnamID));
        let newIndex = firstIndex + Math.ceil(threshold / 2) - gnamsLeft;
        if (newIndex < 0) {
            gnamsLeft--;
            drawFirstGnams();
        } else {
            const id = gnamsQueue[newIndex][0];
            $.get("api/gnams.php", {
                api_key: "<?php echo $_SESSION['api_key']; ?>",
                gnam: id
            }, function(gnamsData) {
                addGnamSlide(JSON.parse(gnamsData));
                $.get("api/comments.php", {
                    api_key: "<?php echo $_SESSION['api_key']; ?>",
                    gnam_id: id
                }, function(commentsData) {
                    setComments(JSON.parse(commentsData), id);
                    gnamsLeft--;
                    if (gnamsLeft > 0 && newIndex != gnamsQueue.length - 1) {
                        drawFirstGnams();
                    } else {
                        gnamsLeft = 0;
                        initializeSwiper();
                    }
                });
            });
        }
    }

    const drawGnam = (index) => {
        const id = gnamsQueue[index][0];
        $.get("api/gnams.php", {
            api_key: "<?php echo $_SESSION['api_key']; ?>",
            gnam: id
        }, function(gnamsData) {
            addGnamSlide(JSON.parse(gnamsData));
            $("#gnamPlayer-" + id).on('loadedmetadata', function() {
                $("#gnam-" + id).removeClass("d-none");
                $.get("api/comments.php", {
                    api_key: "<?php echo $_SESSION['api_key']; ?>",
                    gnam_id: id
                }, function(commentsData) {
                    setComments(JSON.parse(commentsData), id);
                });
                if (wentUp) {
                    swiper.destroy();
                    firstSlideIndex = Math.floor(threshold / 2);
                    initializeSwiper();
                    swiper.update();
                    wentUp = false;
                } else {
                    swiper.update();
                }
            });
        });
    }

    const addGnamSlide = (gnamsInfo) => {
        let gnamHtml = `
            <video id="gnamPlayer-${gnamsInfo['id']}" class="w-100 h-100 p-0" loop playsinline preload="auto" poster="assets/gnams_thumbnails/${gnamsInfo['id']}.jpg" src="assets/gnams/${gnamsInfo['id']}.mp4" aria-live="off" aria-label="Video di ${gnamsInfo['user_name']}"></video>
            <div id="videoOverlay-${gnamsInfo['id']}" class="video-overlay" aria-live="off" aria-label="Gnam di ${gnamsInfo['user_name']}, usa freccie su e giù per cambiare Gnam, usa spazio per controllare il video.">
                <div class="container" aria-live="off">
                    <div class="row mb-3" aria-live="off">
                        <div id="descriptionBox-${gnamsInfo['id']}" class="col-10 align-self-end text-black">
                            <div class="row text-link"  aria-label="Autore dello gnam: ${gnamsInfo['user_name']}, premere invio per andare al profilo">
                                <div class="col-3">
                                    <img id="userImage-${gnamsInfo['id']}" class="cursor-pointer border border-2 border-dark rounded-circle w-100" alt="Immagine profilo di ${gnamsInfo['user_name']}" src="assets/profile_pictures/${gnamsInfo['user_id']}.jpg" />
                                </div>
                                <div class="col-9 d-flex align-items-center p-0">
                                    <p id="userName-${gnamsInfo['id']}" class="cursor-pointer fs-6 fw-bold m-0">${gnamsInfo['user_name']}</p>
                                </div>
                            </div>
                            <div class="row">
                                <span id="videoDescriptionShort-${gnamsInfo['id']}" class="m-0">
                                    <span>${gnamsInfo['short_description']}</span>
                                    <span class="text-nowrap m-0 color-accent fw-semibold cursor-pointer">Leggi di piú</span>
                                </span>
                                <span id="videoDescriptionLong-${gnamsInfo['id']}" class="m-0 d-none" aria-label="Descrizione gnam: ${gnamsInfo['description']}"><span>${gnamsInfo['description']}<span><br>
                                    <span class="text-nowrap m-0 color-accent fw-semibold cursor-pointer">Mostra di meno</span>
                                </span>
                            </div>
                            <div class="row" id="videoTags-${gnamsInfo['id']}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row pb-4 text-center btn-bounce" role="button" id="recipeButton-${gnamsInfo['id']}">
                                <img alt="Ingredienti della ricetta" src="assets/recipe.png">
                            </div>
                            <div class="row text-center btn-bounce" role="button" id="likeButton-${gnamsInfo['id']}">
                                <img alt="Metti mi piace" src="assets/like.png">
                            </div>
                            <div class="row pt-2 color-accent fw-bold text-center">
                                <span id="likesCounter-${gnamsInfo['id']}">${gnamsInfo['likes_count']}</span>
                            </div>
                            <div class="row pt-2 text-center btn-bounce" role="button" id="commentsButton-${gnamsInfo['id']}">
                                <img alt="Commenta Gnam" src="assets/comments.png">
                            </div>
                            <div class="row pt-2 color-accent fw-bold text-center">
                                <span id="commentsCounter-${gnamsInfo['id']}">0</span>
                            </div>
                            <div class="row pt-2 text-center btn-bounce" role="button" id="shareButton-${gnamsInfo['id']}">
                                <img alt="Condividi Gnam" src="assets/share.png">
                            </div>
                            <div class="row pt-2 color-accent fw-bold text-center">
                                <span id="shareCounter-${gnamsInfo['id']}">${gnamsInfo['shares_count']}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
        const slideElement = document.createElement('div');
        slideElement.classList.add("swiper-slide");
        slideElement.classList.add("d-none");
        slideElement.setAttribute("aria-label", `Gnam di ${gnamsInfo['user_name']}, usa freccie su e giù per cambiare Gnam, usa spazio per controllare il video.`);
        slideElement.setAttribute('tabindex', '-1');
        slideElement.id = "gnam-" + gnamsInfo['id'];
        slideElement.innerHTML = gnamHtml.trim();

        if (gnamsInfo['short_description'] != gnamsInfo['description']) {
            slideElement.querySelector('#videoDescriptionShort-' + gnamsInfo['id'] + ' span').innerText += "...";
        }

        let count = 0;
        let tagHTML = '';
        gnamsInfo['tags'].forEach(tag => {
            let tagText = tag['text'];

            if (count < 2) {
                tagHTML += `
                    <div class="col-4 videoTag-${gnamsInfo['id']}">
                        <span class="w-100 px-1 badge rounded-pill bg-primary fw-light text-black cursor-pointer">
                            #${tagText}
                        </span>
                    </div>`;
            } else {
                tagHTML += `
                    <div class="col-4 d-none videoTag-${gnamsInfo['id']}">
                        <span class="w-100 px-1 badge rounded-pill bg-primary fw-light text-black cursor-pointer">
                            #${tagText}
                        </span>
                    </div>`;
            }
            count++;
        });

        if (gnamsInfo['tags'].length > 2) {
            tagHTML += `
                <div class="col-4 text-center" id="moreTagsButton-${gnamsInfo['id']}">
                    <span class="w-100 px-1 badge rounded-pill bg-primary fw-light text-black cursor-pointer">
                        <em class="fa-solid fa-ellipsis" aria-hidden="true"></em>
                    </span>
                </div>`;
        }

        slideElement.querySelector('#videoTags-' + gnamsInfo['id']).innerHTML = tagHTML;
        let indexOfId = gnamsQueue.findIndex(item => item[0] == gnamsInfo['id']);
        if (currentGnamID == gnamsInfo['id']) {
            slideElement.querySelector("#gnamPlayer-" + currentGnamID).setAttribute("autoplay", "");
        }
        if ($(".swiper-slide").length == 0) {
            $("#gnamSlider").append(slideElement);
        } else if (indexOfId - 1 >= 0 && gnamsQueue[indexOfId - 1][1] == true) {
            let lastGnamChild = $("#gnamSlider").children("[id^='gnam-']").last();
            $(slideElement).insertAfter(lastGnamChild);
        } else if (indexOfId + 1 < gnamsQueue.length && gnamsQueue[indexOfId + 1][1] == true) {
            let firstGnamChild = $("#gnamSlider").children("[id^='gnam-']").first();
            $(slideElement).insertBefore(firstGnamChild);
        }
        gnamsQueue[indexOfId][1] = true;

        $.get('api/likes.php', {
            "api_key": '<?php echo $_SESSION["api_key"] ?>',
            "gnam_id": gnamsInfo['id']
        }, function(data) {
            let children = $("#likeButton-" + gnamsInfo['id']).children();
            if (JSON.parse(data) && children.attr("src") == "assets/like.png") {
                children.attr("aria-label", "Togli mi piace");
                children.attr("src", "assets/like-alert.png");
            }
        });

        $("#likeButton-" + gnamsInfo['id']).each(function() {
            let likeButton = $(this);
            let children = likeButton.children();
            let likesCounter = $("#likesCounter-" + gnamsInfo['id']);
            likeButton.on("click", function(e) {
                if (children.attr("src") == "assets/like.png") {
                    children.attr("aria-label", "Togli mi piace");
                    children.attr("src", "assets/like-alert.png");
                    likesCounter.text(parseInt(likesCounter.text()) + 1);
                } else {
                    children.attr("aria-label", "Metti mi piace");
                    children.attr("src", "assets/like.png");
                    likesCounter.text(parseInt(likesCounter.text()) - 1);
                }
                $.post('api/likes.php', {
                    "api_key": '<?php echo $_SESSION["api_key"] ?>',
                    "gnam_id": gnamsInfo['id'],
                    "action": "TOGGLE_LIKE"
                });
                e.stopPropagation();
            });
        });

        isDescriptionShort = true;
        $("#descriptionBox-" + gnamsInfo['id']).on("click", function(e) {
            showFullDescription();
            e.stopPropagation();
        });
        $("#videoDescriptionLong-" + gnamsInfo['id'] + ">span>span ").on("click", function(e) {
            showShortDescription(e);
        });
        $("#videoDescriptionShort-" + gnamsInfo['id']).on("focus", function(e) {
            showFullDescription();
            let value = $("#videoDescriptionShort-" + currentGnamID).attr("tabindex");
            $("#videoDescriptionLong-" + currentGnamID).attr('tabindex', value).focus();
            e.stopPropagation();
        });
        $("#gnam-" + gnamsInfo['id']).on("focus", showShortDescription);
        $("#videoOverlay-" + gnamsInfo['id']).on("click", showShortDescription);

        $("#shareButton-" + gnamsInfo['id']).on("click", function(e) {
            let swalContent = `
            <div class='row-md-2 py-2 text-center text-black'>
                <div class='container'>
                    <div class='col'>
                        <div class='row-9 py-4'><em class='fa-solid fa-share-nodes fa-2xl' aria-hidden="true"></em></div>
                        <div class='row-3 pt-3'><button type='button' class='btn btn-bounce rounded-pill bg-accent fw-bold
                                text-white' id="copyGnamLinkButton" aria-label="Pulsante per copiare il link dello gnam" tabindex="3">Copia link</button></div>
                    </div>
                </div>
            </div>`;
            showSmallSwal('Condividi Gnam', swalContent, function() {
                $("#gnam-" + currentGnamID).attr('tabindex', '1').focus();
                playCurrentVideo();
            }, true);
            $("#copyGnamLinkButton").on("click", function() {
                $("#shareCounter-" + currentGnamID).text(parseInt($("#shareCounter-" + currentGnamID).text()) + 1);
                let gnamLink = buildURL("home", "gnam=" + currentGnamID);
                copyToClipboard(gnamLink);
                $.post('api/gnams.php', {
                    "api_key": '<?php echo $_SESSION["api_key"] ?>',
                    "gnam_id": currentGnamID,
                    "action": "INCREMENT_SHARE"
                });
            });

            e.stopPropagation();
        });

        $("#recipeButton-" + gnamsInfo['id']).on("click", function(e) {
            let html = `
                <div class="container">
                    <div class="col">
                        <div class="row p-1 pb-3">
                            <span class="text-black" tab-index="1">Ingredienti non disponibili, prova a chiederli all'autore dello Gnam!</span>
                        </div>
                    </div>
                </div>`;
            if (gnamsInfo['recipe'].length != 0) {
                html = `
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <p class="m-0 me-2 fs-6 text-black">Numero di porzioni:</p>
                        <input type="number" value="1" min="1" max="100" class="form-control bg-primary rounded shadow-sm fs-6 fw-bold text-center" id="portionsInput" aria-label="numero di porzioni" tabindex="3" />
                    </div>
                    <div class="text-center text-black" id="ingredients-${gnamsInfo['id']}">
                        <table class='w-100' aria-label='Tabella ingredienti' tabindex="3">
                            <thead class='border-bottom border-dark'>
                                <tr>
                                    <th id='it-header-name' class='text-start' scope='col' tabindex="3">Nome</th>
                                    <th id='it-header-quantity' class='text-end' scope='col' tabindex="3">Quantità</th>
                                </tr>
                            </thead>
                            <tbody id='it-body' class='border-bottom border-dark'>
                            </tbody>
                        </table>
                    </div>
                `;
            }
            stopCurrentVideo();
            showSwal('Ricetta', html, function() {
                playCurrentVideo();
                setTimeout(function() {
                    $("#recipeButton-" + gnamsInfo['id']).attr('tabindex', '3').focus();
                }, 100);
            });
            if (gnamsInfo['recipe'].length != 0) {
                $('#portionsInput').val(selectedPortions);
                $('#portionsInput').on("focus", function() {
                    $("#swal2-html-container table").attr("tabindex", "-1");
                    $("#swal2-html-container table td").attr("tabindex", "-1");
                })
                $('#portionsInput').on("focusout", function() {
                    $("#swal2-html-container table").attr("tabindex", "3");
                    $("#swal2-html-container table td").attr("tabindex", "3");
                })
                $("#portionsInput").on("change", function(e) {
                    if ((this).value > 0) {
                        selectedPortions = (this).value;
                        drawAllIngredients(gnamsInfo['recipe']);
                    } else {
                        (this).value = selectedPortions;
                    }
                });
                drawAllIngredients(gnamsInfo['recipe']);
                $("#portionsInput").focus();
            }
            e.stopPropagation();
        });

        $("#userImage-" + gnamsInfo['id']).on("click", function(e) {
            redirectToGnamUserPage(gnamsInfo['user_id']);
            e.stopPropagation();
        });

        $("#userName-" + gnamsInfo['id']).on("click", function(e) {
            redirectToGnamUserPage(gnamsInfo['user_id']);
            e.stopPropagation();
        });

        $(".videoTag-" + gnamsInfo['id']).on("click", function(e) {
            window.location = "search.php?q=" + encodeURIComponent($(this).text().trim());
        });
    }

    const showFullDescription = () => {
        if (isDescriptionShort) {
            isDescriptionShort = false;
            $("#videoDescriptionShort-" + currentGnamID).addClass("d-none");
            $("#videoDescriptionLong-" + currentGnamID).removeClass("d-none");
            $("#moreTagsButton-" + currentGnamID).addClass("d-none");
            let videoTags = $(".videoTag-" + currentGnamID);
            for (let i = 0; i < videoTags.length; i++) {
                $(videoTags[i]).removeClass("d-none");
            }
            $("#videoOverlay-" + currentGnamID).css("background-image", "linear-gradient(0deg, var(--background), rgba(247, 209, 151, 0) 40%)");
        }
    }

    const showShortDescription = (e) => {
        if (!isDescriptionShort) {
            isDescriptionShort = true;
            $("#videoDescriptionLong-" + currentGnamID).addClass("d-none");
            $("#videoDescriptionShort-" + currentGnamID).removeClass("d-none");
            $("#moreTagsButton-" + currentGnamID).removeClass("d-none");
            let videoTags = $(".videoTag-" + currentGnamID);
            for (let i = 2; i < videoTags.length; i++) {
                $(videoTags[i]).addClass("d-none");
            }
            $("#videoOverlay-" + currentGnamID).css("background-image", "linear-gradient(0deg, var(--background), rgba(247, 209, 151, 0) 30%)");
            e.stopPropagation();
        }
    }

    const drawAllIngredients = (recipe) => {
        $("#ingredients-" + currentGnamID + " tbody").empty();
        let ingredientsHTML = "";
        recipe.forEach(ingredient => {
            ingredientsHTML += `
            <tr class="align-items-center">
                <td class="text-start" headers="it-header-name" tabindex="4">${ingredient["name"]}</td>
                <td class="text-end fw-bold" headers="it-header-quantity" tabindex="4">${ingredient["quantity"] > 0 ? ingredient["quantity"] * selectedPortions : ""} ${ingredient["measurement_unit"]}</td>
            </tr>`;
        });
        $("#ingredients-" + currentGnamID + " tbody").append(ingredientsHTML);
    }

    const buildURL = (siteSection, query) => {
        return window.location.href.split("home")[0] + siteSection + ".php?" + query;
    }

    const redirectToGnamUserPage = (userId) => {
        let redirectPath = buildURL("profile", "user=" + userId);
        window.location.href = redirectPath;
    }


    document.onkeypress = function(e) {
        if (e.keyCode == 13) {
            document.activeElement.click();
            if ($("#commentsBoxContainer-" + currentGnamID).length > 0 && document.activeElement != document.querySelector("#commentButton-" + currentGnamID)) {
                publishComment();
            } else if(document.querySelector("#descriptionBox-" + currentGnamID + " > div:first-child") == document.activeElement) {
                document.activeElement.querySelector("img").click();
            }
        } else if (e.keyCode == 32 && document.activeElement != document.querySelector("#commentField-" + currentGnamID)) {
            toggleCurrentVideo();
        }
    }

    const publishComment = () => {
        const commentText = $("#commentField-" + currentGnamID).val();
        if (commentText.length === 0) return;
        $.post("api/comments.php", {
            api_key: "<?php echo $_SESSION['api_key']; ?>",
            "gnam_id": currentGnamID,
            "text": commentText,
            "parent_comment_id": commentToReplyID
        }, (result) => {
            $.get("api/comments.php", {
                api_key: "<?php echo $_SESSION['api_key']; ?>",
                gnam_id: currentGnamID
            }, function(commentsData) {
                let comments = JSON.parse(commentsData);
                $("#commentsBoxContainer-" + currentGnamID).parent().html(getCommentsHTML(comments));
                setComments(comments, currentGnamID);
                setHandlersForCommentsContainer(comments);
                commentToReplyID = null;
            });
        });
        $("#commentField-" + currentGnamID).attr("aria-label", "Scrivi commento");

        let announceLiveRegion = $('<div>', {
            role: 'status',
            'aria-live': 'polite',
            'aria-atomic': 'true'
        }).appendTo('body');
        announceLiveRegion.text("Commento pubblicato");
        announceLiveRegion.focus();
        setTimeout(function() {
            announceLiveRegion.remove();
            $("#commentField-" + currentGnamID).focus();
        }, 1000);
    }

    const getCommentsHTML = (comments) => {
        if (comments.length == 0) {
            let firstCommentHTML = `
                <div class="row-8 modal-content-lg text-black">
                    <div class="container">
                        <div class="col">
                            <div class="row p-1 pb-3">
                                <span tabindex="1" aria-label="Non ci sono commenti, sii il primo a commentare">Sii il primo a commentare!</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-1 bg-primary rounded">
                    <div class="input-group rounded">
                        <input id="commentField-${currentGnamID}" type="text" class="fs-6 form-control bg-primary shadow-sm" placeholder="Scrivi..." aria-label="Scrivi commento" />
                        <span role="button" tabindex="0" id="commentButton-${currentGnamID}" class="input-group-text bg-primary border-0 fs-6 fw-bold cursor-pointer text-black">Commenta</span>
                    </div>
                </div>`;

            let commentsContainerElement = document.createElement('div');
            commentsContainerElement.classList.add("container");
            commentsContainerElement.setAttribute("aria-live", "off");
            commentsContainerElement.id = "commentsBoxContainer-" + currentGnamID;
            commentsContainerElement.innerHTML = firstCommentHTML.trim();
            return commentsContainerElement.outerHTML;
        } else {
            let commentContainerHTML = `
                <div class="row-8 modal-content-lg">
                    <div class="container">
                        <div class="col">
                            <div id="commentsContainer" class="row">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-1 bg-primary rounded">
                    <div class="rounded bg-primary p-1 d-none" id="replyToDiv-${currentGnamID}" aria-hidden="true">
                        <div class="rounded bg container">
                            <div class="row">
                                <div class="col-11 align-items-center">
                                    <span class="border-0 fs-6">Stai rispondendo a: <span id="replyToName-${currentGnamID}" class="text-link"></span></span>
                                </div>
                                <div class="col-1 d-flex align-items-center p-0 cursor-pointer">
                                    <em id="closeReplyTo-${currentGnamID}" class="fa-solid fa-xmark color-accent" aria-hidden="true"></em>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group rounded">
                        <input id="commentField-${currentGnamID}" type="text" class="fs-6 form-control bg-primary shadow-sm" placeholder="Scrivi..." aria-label="scrivi commento" tabindex="1" />
                        <span role="button" tabindex="1" id="commentButton-${currentGnamID}" class="input-group-text bg-primary border-0 fs-6 fw-bold cursor-pointer">Commenta</span>
                    </div>
                </div>`;

            let commentsContainerElement = document.createElement('div');
            commentsContainerElement.classList.add("container");
            commentsContainerElement.setAttribute("aria-live", "off");
            commentsContainerElement.id = "commentsBoxContainer-" + currentGnamID;
            commentsContainerElement.innerHTML = commentContainerHTML.trim();

            comments.sort((a, b) => {
                if (a.parent_comment_id === null && b.parent_comment_id !== null) {
                    return -1;
                } else if (a.parent_comment_id !== null && b.parent_comment_id === null) {
                    return 1;
                } else {
                    return a.timestamp - b.timestamp;
                }
            });

            let commentIndex = 1;
            comments.forEach(comment => {
                if (comment['parent_comment_id'] == null) {
                    let commentHTML = `
                    <div id="comment-${comment['id']}" class="container comment py-1">
                        <div class="row" tabindex="2" aria-label="Commento ${commentIndex} su ${comments.length}, ${comment['user_name']} dice: ${comment['text']}">
                            <div class="col-2 p-0">
                                <img id="commenterImg-${comment['id']}" class="border border-2 border-dark rounded-circle w-100" alt="${comment['user_name']}"
                                    src="assets/profile_pictures/${comment['user_id']}.jpg" />
                            </div>
                            <div class="col">
                                <div class="row-md-1 text-start">
                                    <span id="commenterUserName-${comment['id']}" class="text-link">${comment['user_name']}</span>
                                </div>
                                <div class="row-md text-black fw-normal fs-6 text-start">
                                    <p class="m-0">${comment['text']}</p>
                                </div>
                                <div class="row-md-1 text-start">
                                    <span id="replyButton-${comment['id']}" class="text-button fw-bold color-accent fs-6" tabindex="2">Rispondi</span>
                                </div>
                            </div>
                        </div>
                        <div id="subcommentsContainer-${comment['id']}" class="row d-none">
                        </div>
                    </div>`;

                    commentsContainerElement.querySelector('#commentsContainer').innerHTML += commentHTML;
                } else {
                    let commentHTML = `
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col">
                            <div id="comment-${comment['id']}" class="container subcomment py-1" aria-label="Commento in risposta, ${comment['user_name']} risponde dicendo: ${comment['text']}" tabindex="2">
                                <div class="row">
                                    <div class="col-2 p-0">
                                        <img class="border border-2 border-dark rounded-circle w-100" alt="${comment['user_name']}"
                                            src="assets/profile_pictures/${comment['user_id']}.jpg" />
                                    </div>
                                    <div class="col">
                                        <div class="row-md-1 text-start">
                                            <span id="commenterUserName-${comment['id']}" class="text-link">${comment['user_name']}</span>
                                        </div>
                                        <div class="row-md text-black fw-normal fs-6 text-start">
                                            <p class="m-0">${comment['text']}</p>
                                        </div>
                                        <div class="row-md-1 text-start">
                                            <span id="replyButton-${comment['id']}" class="replyTo-${comment['parent_comment_id']} text-button fw-bold color-accent fs-6" tabindex="2">Rispondi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    commentsContainerElement.querySelector('#subcommentsContainer-' + comment['parent_comment_id']).classList.remove('d-none');
                    commentsContainerElement.querySelector('#subcommentsContainer-' + comment['parent_comment_id']).innerHTML += commentHTML;
                }
                commentIndex++;
            });
            return commentsContainerElement.outerHTML;
        }
    }

    const setHandlersForCommentsContainer = (comments) => {
        comments.forEach(comment => {
            $("#replyButton-" + comment['id']).off("click");
            $("#replyButton-" + comment['id']).on("click", function(e) {

                const id = $(e.target).attr('id').split('-')[1];
                const parent = $("#comment-" + id);
                if (parent.hasClass('subcomment')) {
                    commentToReplyID = $(e.target).attr('class').split(' ')[0].split('-')[1];
                } else {
                    commentToReplyID = id;
                }

                let commenterName = parent.find("#commenterUserName-" + id).text();
                $("#replyToDiv-" + currentGnamID).removeClass("d-none");
                $("#replyToName-" + currentGnamID).text(commenterName);
                $("#commentField-" + currentGnamID).attr("aria-label", "Rispondendo a " + commenterName + ", premere esc per smettere di rispondere");
                $("#commentField-" + currentGnamID).focus();
            });
            $("#commenterUserName-" + comment['id']).off("click");
            $("#commenterUserName-" + comment['id']).on("click", function() {
                redirectToGnamUserPage(comment['user_id']);
            });
            $("#commenterImg-" + comment['id']).off("click");
            $("#commenterImg-" + comment['id']).on("click", function() {
                redirectToGnamUserPage(comment['user_id']);
            });
        });
        $("#commentButton-" + currentGnamID).off("click");
        $("#commentButton-" + currentGnamID).on("click", publishComment);
        $("#closeReplyTo-" + currentGnamID).off("click");
        $("#closeReplyTo-" + currentGnamID).on("click", function() {
            $("#replyToDiv-" + currentGnamID).addClass("d-none");
            commentToReplyID = null;
        });
    }

    const setComments = (comments, gnam_id) => {
        $("#commentsCounter-" + gnam_id).text(comments.length);
        $("#commentsButton-" + gnam_id).off('click');
        $("#commentsButton-" + gnam_id).on('click', function(e) {
            stopCurrentVideo();
            showSwal('Commenti', getCommentsHTML(comments), function() {
                playCurrentVideo();
                commentToReplyID = null;
                setTimeout(function() {
                    $("#commentsButton-" + gnam_id).attr('tabindex', '3').focus();
                }, 100);
            });
            setHandlersForCommentsContainer(comments);
            e.stopPropagation();
        });
    }

    const toggleCurrentVideo = () => {
        let video = $("#gnamPlayer-" + currentGnamID);

        let videoElement = video.get(0);

        if (videoElement.paused) {
            playCurrentVideo();
        } else {
            stopCurrentVideo();
        }
    }

    const stopCurrentVideo = () => {
        $("#gnamPlayer-" + currentGnamID)[0].pause();
    }

    const playCurrentVideo = () => {
        $("#gnamPlayer-" + currentGnamID)[0].play();
    }
</script>