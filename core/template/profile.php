<?php

$user_id = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_NUMBER_INT);

if($user_id === null || $user_id <= 0 || !userExits($user_id) || !isset($user_id)) {
    $_GET['user'] = $_SESSION['id'];
}

$user = getUser($_GET['user']);
$followers = getUserFollowers($user['id']);
$followed = getUserFollowed($user['id']);
$userGnams = getUserGnams($user['id']);
$userLikedGnams = getUserLikedGnams($user['id']);

?>
<div class="container text-center mt-3">
    <div class="row">
        <div class="col-4">
            <img class="border border-2 border-dark rounded-circle w-75" alt="Foto profilo di <?php echo $user['name'] ?>" src="assets/profile_pictures/<?php echo $user['id'] ?>.jpg" />
        </div>
        <div class="col-8">
            <div class="row">
                <div class="h4 mt-2 ps-0"><?php echo $user['name'] ?></div>
            </div>
            <div class="row">
                <a id="followerButton" href="#" class="col p-0 text-link">
                    <p class="fw-bold p-0 mb-0">Follower</p>
                    <p class="text-normal-black" id="followersCount"><?php echo count($followers); ?></p>
                </a>

                <a id="followedButton" href="#" class="col p-0 text-link">
                    <div class="col p-0">
                        <p class="fw-bold mb-0">Seguiti</p>
                        <p class="text-normal-black"><?php echo count($followed); ?></p>
                    </div>
                </a>
                <div class="col p-0 text-link">
                    <p class="fw-bold mb-0">Gnam</p>
                    <p class="text-normal-black"><?php echo count($userGnams); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <?php if($user['id'] != $_SESSION['id']) { ?>
            <div class="col-4">
                <button type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100" id="followButton"><?php echo isCurrentUserFollowing($user['id']) ? "Seguito" : "Segui" ?></button>
            </div>
        <?php } ?>
        <div class="col-4 px-0">
            <button id="shareButton" type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100">Condividi</button>
        </div>
        <?php if($user['id'] == $_SESSION['id']) { ?>
            <div class="col-2">
                <button type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black" id="settingsButton">
                    <em class="fa-solid fa-gear fa-l"></em>
                </button>
            </div>
        <?php } ?>
    </div>
    <div class="row align-items-center text-center mt-2">
        <div class="col-1"></div>
        <div class="col-3 cursor-pointer">
            <p class="mb-0 fw-bold" id="allPostsButton">Post</p>
        </div>
        <div class="col-2"></div>
        <div class="col-5 cursor-pointer">
            <p class="mb-0" id="likedPostsButton">Gnam Piaciuti</p>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="row row justify-content-center">
        <hr class="w-75" id="horizontalLine" />
    </div>
</div>

<div class="container">
    <div id="postedGnams">
        <?php
            $gnamPerRow = 3;
            if(count($userGnams) > 0) {
                echo '<div class="row">';
                for($i = 0; $i < count($userGnams); $i++) {
                    echo '<img class="img-grid col-4 btn-bounce" onclick="setGnamsToWatchFrom(' . $userGnams[$i]['id'] . ', getGnamsIdsFromDiv(\'postedGnams\'))" alt="Copertina Gnam di ' . $user['name'] . '" src="assets/gnams_thumbnails/' . $userGnams[$i]['id'] . '.jpg" />';
                    $gnamPerRow--;
                    if($i == count($userGnams) - 1) {
                        echo '</div>';
                    } else if($gnamPerRow == 0) {
                        echo '</div><div class="row my-3">';
                        $gnamPerRow = 3;
                    }
                }
            } else {
                echo '
                <div class="row text-center mt-3">
                    <div class="fs-6">Nessuno Gnam pubblicato.</div>
                </div>
                ';
            }
        ?>
    </div>
    <div id="likedGnams">
        <?php
            $gnamPerRow = 3;
            if(count($userLikedGnams) > 0) {
                echo '<div class="row">';
                for($i = 0; $i < count($userLikedGnams); $i++) {
                    echo '<img class="img-grid col-4 btn-bounce" onclick="setGnamsToWatchFrom(' . $userLikedGnams[$i]['gnam_id'] . ', getGnamsIdsFromDiv(\'likedGnams\'))" alt="Copertina Gnam di ' . $user['name'] . '" src="assets/gnams_thumbnails/' . $userLikedGnams[$i]['gnam_id'] . '.jpg" />';
                    $gnamPerRow--;
                    if($i == count($userLikedGnams) - 1) {
                        echo '</div>';
                    } else if($gnamPerRow == 0) {
                        echo '</div><div class="row my-3">';
                        $gnamPerRow = 3;
                    }
                }
            } else {
                echo '
                <div class="row text-center mt-3">
                    <div class="fs-6">Nessuno Gnam fra i preferiti.</div>
                </div>
                ';
            }
        ?>
    </div>
</div>

<script>
    const getGnamsIdsFromDiv = (divId) => {
        const gnamsList = [];
        $('#' + divId + ' img').each(function() {
            const imgSrc = $(this).attr('src');
            const imgName = imgSrc.substring(imgSrc.lastIndexOf('/') + 1, imgSrc.lastIndexOf('.'));
            const idMatches = imgName.match(/\d+/);
            if (idMatches) {
                const gnamsId = parseInt(idMatches[0]);
                gnamsList.push({ id: gnamsId });
            }
        });
        return gnamsList;
    }

    const followUser = () => {
        $.post("api/users.php", {
            user_id: "<?php echo $user['id'] ?>",
            api_key: "<?php echo $_SESSION['api_key'] ?>",
            action: "toggleFollowState"
        }, (result) => {
            let decodedResult = JSON.parse(result);
            if (decodedResult.status === "success") {
                if(decodedResult.message == "Segui") {
                    $("#followersCount").text(parseInt($("#followersCount").text()) - 1);
                } else {
                    $("#followersCount").text(parseInt($("#followersCount").text()) + 1);
                }
                $("#followButton").text(decodedResult.message);
            } else showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>");
        });
    }

    const toggleGnamToVisualize = () => {
        if(event.target.id === 'allPostsButton') {
            $('#likedPostsButton').removeClass('fw-bold');
            $('#allPostsButton').addClass('fw-bold');
            $('#likedGnams').hide();
            $('#postedGnams').show();
        } else {
            $('#allPostsButton').removeClass('fw-bold');
            $('#likedPostsButton').addClass('fw-bold');
            $('#postedGnams').hide();
            $('#likedGnams').show();
        }
    }

    const showSwalShare = () => {
        let swalContent = `
            <div class='row-md-2 py-2 text-center text-black'>
                <div class='container'>
                    <div class='col'>
                        <div class='row-9 py-4'><em class='fa-solid fa-share-nodes fa-2xl'></em></div>
                        <div class='row-3 pt-3'><button type='button' class='btn btn-bounce rounded-pill bg-accent fw-bold
                                text-white' id="copyLinkButton">Copia link</button></div>
                    </div>
                </div>
            </div>
        `;
        showSwal('Condividi Profilo', swalContent);
        $("#copyLinkButton").on("click", copyCurrentPageLink);
    }

    const showSwalFollower = () => {
        let swalContent = `
            <ul class="list-group modal-content-lg">
                <?php
                    if(count($followers) > 0) {
                        foreach ($followers as $f) {
                            echo '
                                <li class="list-group-item bg border-0 btn-bounce"><a href="profile.php?user=' . $f['id'] . '" class="text-link">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-2 border-dark rounded-circle w-100 align-middle" alt="Foto profilo di ' . $f['name'] . '" src="assets/profile_pictures/' . $f['id'] . '.jpg" /></div>
                                            <div class="col-8 d-flex flex-wrap align-items-center">' . $f['name'] . '</div>
                                        </div>
                                    </div>
                                </a></li>';
                        }
                    } else {
                        echo 'Nessun follower.';
                    }
                ?>
            </ul>`;
        showSwal('Follower', swalContent);
    }

    const showSwalFollowed = () => {
        let swalContent = `
            <ul class="list-group modal-content-lg">
                <?php
                    if(count($followed) > 0) {
                        foreach($followed as $f) {
                            echo '
                                <li class="list-group-item bg border-0 btn-bounce"><a href="profile.php?user=' . $f['id'] . '" class="text-link">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-2 border-dark rounded-circle w-100 align-middle" alt="Foto profilo di ' . $f['name'] . '" src="assets/profile_pictures/' . $f['id'] . '.jpg" /></div>
                                            <div class="col-8 d-flex flex-wrap align-items-center">' . $f['name'] . '</div>
                                        </div>
                                    </div>
                                </a></li>
                            ';
                        }
                    } else {
                        echo 'Nessun utente seguito.';
                    }
                ?>
            </ul>`;
        showSwal('Seguiti', swalContent);
    }

    const showSwalSettings = () => {
        let swalContent = `
            <div class='row-md-2 py-2 text-center text-black overflow-hidden'>
                <div class='container px-0'>
                    <div class='row mb-3'>
                        <div class='col'>
                            <p class="fs-5">Cambia immagine profilo:</p>
                            <input type="file" class="form-control bg-primary rounded shadow-sm" id="newProfileImage" title="nuovaImmagineDiProfilo" aria-label="nuovaImmagineDiProfilo" />
                        </div>
                    </div>
                    <div class='row justify-content-center'>
                        <div class='col-4' id="saveButton">
                            <a role='button' class='btn btn-bounce rounded-pill bg-accent fw-bold text-white'>Salva</a>
                        </div>
                        <div class='col-5' id="logoutButton">
                            <a role='button' class='btn btn-bounce rounded-pill bg-alert fw-bold text-white'>Log out</a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        showSwal('Impostazioni', swalContent);

        $(document).ready(function() {
            $('#saveButton').hide();
            $('input[type=file]').change(function() {
                $('#saveButton').show();
            });

            $('#saveButton').click(function() {
                let imageFile = $('#newProfileImage')[0].files[0];
                let formData = new FormData();
                formData.append('image', imageFile);
                formData.append("action", "updateProfileImage");
                formData.append("api_key", "<?php echo $_SESSION['api_key']; ?>");

                $.ajax({
                    url: 'api/users.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let decodedResult = JSON.parse(response);
                        let html = `<div class="row-md-2 py-2 text-center text-black"><em class="fa-solid fa-check fa-2xl"></em></div>`;
                        if (decodedResult.status === "success") {
                            showSwal('Fatto', html, () => {
                                window.location.reload();
                            });
                        } else showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>");
                    }
                });
            });

            $('#logoutButton').click(function() {
                window.location.href = "logout.php";
            });
        });
    }

    $("#followerButton").on("click", showSwalFollower);
    $("#followedButton").on("click", showSwalFollowed);
    $("#shareButton").on("click", showSwalShare);
    $("#allPostsButton").on("click", toggleGnamToVisualize);
    $("#likedPostsButton").on("click", toggleGnamToVisualize);
    $("#followButton").on("click", followUser);
    $("#settingsButton").on("click", showSwalSettings);
    $("#likedGnams").hide();
</script>