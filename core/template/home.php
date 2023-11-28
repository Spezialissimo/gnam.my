<div class="position-relative w-100 p-0">
    <video class="w-100 p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/prova.png" src="assets/prova.mp4"></video>
    <div class="video-overlay" id="videoOverlay">
        <div class="container">
            <div class="row">
                <div class="col-10 align-self-center">
                    <div class="row">
                        <div class="col-4">
                            <img class="border border-4 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/prova-profile.png" />
                        </div>
                        <div class="col-8 d-flex align-items-center">
                            <p class="fs-5 fw-bold m-0">Profilo Nome</p>
                        </div>
                    </div>
                    <div class="row m-0">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis blandit, tortor ut gravida pellentesque, risus. Leggi di piú...</p>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="badge rounded-pill bg-primary fw-light text-black">
                	        	<i class="fa-solid fa-oil-can"></i>&nbsp #Untazzo
                	        </span>
                        </div>
                        <div class="col-4">
                	        <span class="badge rounded-pill bg-primary fw-light text-black">
                		        <i class="fa-solid fa-leaf"></i>&nbsp #Vegan
                	        </span>
                        </div>
                        <div class="col-2 ps-0">
                	        <span class="badge rounded-pill bg-primary fw-light text-black">
                                <i class="fa-solid fa-ellipsis"></i>
                	        </span>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col">
                                <span>
                                    <i class="fa-solid fa-heart fa-2xl fa-fw"></i>
                                </span>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col">
                                <i class="fa-solid fa-utensils fa-2xl fa-fw"></i>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col">
                                <i class="fa-solid fa-comment-dots fa-2xl fa-fw"></i>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col">
                                <i class="fa-solid fa-share-nodes fa-2xl fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function resizeContentDiv() {
        navbar = document.getElementById("navbarDiv");
        document.getElementById("contentDiv").style.height = String(window.innerHeight - navbar.clientHeight) + "px";
        document.getElementById("videoOverlay").style.height = String(window.innerHeight - navbar.clientHeight) + "px";
    }

    window.onload = resizeContentDiv;
    window.onresize = resizeContentDiv;
</script>