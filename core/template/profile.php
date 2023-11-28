<a class="btn text-button fw-bold color-accent text-end" href="#">Log out</a>

<div class="container text-center">
  <div class="row">
    <div class="col-4">
        <img class="border border-2 border-dark rounded-circle w-100" alt="Filippo Champagne" src="assets/prova-profile.png" />
    </div>
    <div class="col-8">
        <div class="row">
            <div class="h4 mt-2 ps-0">GiorgioneErRomano</div>
        </div>
        <div class="row">
            <div class="col p-0">
                <p class="fw-bold p-0 mb-0">Follower</p>
                <p>0</p>
            </div>
            <div class="col p-0">
                <p class="fw-bold mb-0">Seguiti</p>
                <p>0</p>
            </div>
            <div class="col p-0">
                <p class="fw-bold mb-0">Gnam</p>
                <p>0</p>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="container text-center mb-3">
  <div class="row justify-content-center">
    <div class="col-4">
    <button type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100">Segui</button>
    </div>
    <div class="col-4 ps-0 pe-0">
    <button type="button" class="btn btn-bounce rounded-pill bg-primary fw-bold text-black w-100">Condividi</button>
    </div>
  </div>
</div>

<div class="container text-center">
  <div class="row align-items-center">
    <div class="col fw-bold">   <!-- TODO: con JS si swappa classe fw-bold -->
        <p class="mb-0">Post</p>
    </div>
    <div class="col">
    <p class="mb-0">Gnam Piaciuti</p>
    </div>
  </div>
  <div class="row row justify-content-center">
    <hr class="w-75" id="horizontalLine" />
  </div>
</div>

<div class="container overflow-auto" id="gridDiv">
    <div class="row">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row mt-3 mb-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row mt-3 mb-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
    <div class="row mt-3 mb-3">
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
        <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
    </div>
</div>

<script>
    const resizeContentDiv = () => {
        navbar = document.getElementById("navbarDiv");
        document.getElementById("contentDiv").style.height = String(window.innerHeight - navbar.clientHeight) + "px";

        header = document.getElementById("horizontalLine");
        document.getElementById("gridDiv").style.maxHeight = String(window.innerHeight - navbar.clientHeight - header.clientHeight) + "px";
    }

    window.onload = resizeContentDiv;
    window.onresize = resizeContentDiv;
</script>