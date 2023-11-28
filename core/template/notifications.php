<div class="container text-center font-text">
    <div id="headerDiv" class="row-2 py-2">
        <h1 class="fw-bold">Notifiche</h1>
    </div>

    <!-- notification content -->
    <div id="notificationsDiv" class="row-md-8 overflow-auto">
        <div class="container">


            <?php
            for ($i=0; $i < 10; $i++) {
                ?>
                <!-- notification template -->
            <div class="row m-1 p-0">
                <a href="#" role="button" class="btn btn-bounce rounded-pill bg-secondary p-0 notification-pill-text">
                    <div class="container">
                        <div class="row">
                            <div class="p-1 col-2 d-flex flex-wrap align-items-center">
                                <img class="border border-4 border-dark rounded-circle w-100 align-middle" alt="Filippo Champagne" src="assets/prova-profile.png"/>
                            </div>
                            <div class="col align-self-center">
                                <p class="m-0"><b>Nome utente </b>ha messo mi piace al tuo Gnam!</p>
                            </div>
                            <div class="col-2 align-self-center">
                                <p class="m-0">1h</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
                <?php } ?>
        </div>

        <!-- read all notification button -->
        <div class="row-md-4 py-2">
            <a href="#" role="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white">Segna come lette</a>
        </div>
    </div>

</div>

<script>
    function resizeContentDiv() {
        navbar = document.getElementById("navbarDiv");
        document.getElementById("contentDiv").style.height = String(window.innerHeight - navbar.clientHeight) + "px";

        header = document.getElementById("headerDiv");
        document.getElementById("notificationsDiv").style.maxHeight = String(window.innerHeight - navbar.clientHeight - header.clientHeight) + "px";
    }

    window.onload = resizeContentDiv;
    window.onresize = resizeContentDiv;
</script>