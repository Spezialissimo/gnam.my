<video class="w-100 p-0" autoplay disablepictureinpicture loop playsinline preload="auto" poster="assets/prova.png" src="assets/prova.mp4"></video>

<script>
    function resizeContentDiv() {
        navbar = document.getElementById("navbarDiv");
        document.getElementById("contentDiv").style.height = String(window.innerHeight - navbar.clientHeight) + "px";
    }

    window.onload = resizeContentDiv;
    window.onresize = resizeContentDiv;
</script>