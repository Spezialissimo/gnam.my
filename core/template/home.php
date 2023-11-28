<div class="position-relative w-100 p-0">
    <video class="w-100 p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/prova.png" src="assets/prova.mp4"></video>
    <div class="justify-content-center align-items-end top-0 left-0 w-100 d-flex position-absolute p-0 bg opacity-25" id="videoOverlay">
        <p>This is an overlay</p>
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