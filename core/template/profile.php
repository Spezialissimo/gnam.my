
<div class="container text-center" id="headerDiv">
    <div class="row text-end">
        <a class="btn text-button fw-bold color-accent text-end" href="#">Log out</a>
    </div>
  <div class="row">
    <div class="col-4">
        <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/prova-profile.png" />
    </div>
    <div class="col-8">
        <div class="row">
            <div class="h4 mt-2 ps-0">GiorgioneErRomano</div>
        </div>
        <div class="row">

        <a id="followerButton" href="#" class="col p-0 text-link">
            <p class="fw-bold p-0 mb-0">Follower</p>
            <p class="text-normal-black">0</p>
        </a>

        <a id="followedButton" href="#" class="col p-0 text-link">
            <div class="col p-0">
                <p class="fw-bold mb-0">Seguiti</p>
                <p class="text-normal-black">0</p>
            </div>
        </a>
            <div class="col p-0 text-link">
                <p class="fw-bold mb-0">Gnam</p>
                <p class="text-normal-black">0</p>
            </div>
        </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-4">
    <button type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100">Segui</button>
    </div>
    <div class="col-4 px-0">

    <button id="shareButton" type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100">Condividi</button>
    </div>
  </div>
  <div class="row align-items-center text-center mt-2">
        <div class="col-1"></div>
        <div class="col-3 fw-bold" id="allPostsButton">
            <p class="mb-0">Post</p>
        </div>
        <div class="col-2"></div>
        <div class="col-5" id="likedPostsButton">
        <p class="mb-0">Gnam Piaciuti</p>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="row row justify-content-center">
        <hr class="w-75" id="horizontalLine" />
    </div>
</div>

<div class="container overflow-y-scroll" id="pageContentDiv">
    <div class="row">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row my-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row my-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row my-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
</div>

<script>
    let isShowingAllPosts = true;

    const showAllPosts = (e) => {
        if (!isShowingAllPosts) {
            isShowingAllPosts = true;
            $("#allPostsButton").addClass("fw-bold");
            $("#likedPostsButton").removeClass("fw-bold");
        }
    }

    const showLikedPosts = (e) => {
        if (isShowingAllPosts) {
            isShowingAllPosts = false;
            $("#allPostsButton").removeClass("fw-bold");
            $("#likedPostsButton").addClass("fw-bold");
        }
    }

    const showSwalShare = (e) => {
        let swalContent = '<div class=\'row-md-2 py-2 text-center text-black\'><div class=\'container\'><div class=\'col\'><div class=\'row-9 py-4\'><i class=\'fa-solid fa-share-nodes fa-2xl\'></i></div><div class=\'row-3 pt-3\'><button type=\'button\' class=\'btn btn-bounce rounded-pill bg-accent fw-bold text-white\'>Copia link</button></div></div></div></div>';
        showSwalSmall('Condividi Profilo', swalContent);
    }

    const showSwalFollower = (e) => {
        let swalContent = '<ul class="list-group modal-content-lg"><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li></ul>';
        showSwal('Follower', swalContent);
    }


    const showSwalFollowed = (e) => {
        let swalContent = '<ul class="list-group modal-content-lg"><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li><li class="list-group-item bg border-0"><a href="#" class="text-link"><div class="container"><div class="row"><div class="col-2 d-flex flex-wrap align-items-center p-0"><img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"></div><div class="col-8 d-flex flex-wrap align-items-center">Nome utente</div></div></div></a></li></ul>';
        showSwal('Seguiti', swalContent);
    }

    $("#followerButton").on("click", showSwalFollower);
    $("#followedButton").on("click", showSwalFollowed);
    $("#shareButton").on("click", showSwalShare);
    $("#allPostsButton").on("click", showAllPosts);
    $("#likedPostsButton").on("click", showLikedPosts);
</script>