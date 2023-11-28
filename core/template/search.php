<div class="container text-center font-text">
    <div id="headerDiv" class="row-2 py-2">
        <h1 class="fw-bold">Cerca</h1>
    </div>
    <!-- search field -->
    <div id="searchbarDiv" class="row-md-2 py-2">
        <div class="input-group rounded">
            <span class="input-group-text bg-primary border-0"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca">
    	</div>
    </div>
    <!-- ingredients -->
    <div id="ingredientsDiv" class="row-md-2 py-2">
        <!-- Button con counter -->
        <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white">
            Ingredienti <span class="badge rounded-pill bg-accent">1</span>
        </button>
    </div>
    <!-- search results content -->
    <div id="gridDiv" class="row-md-8 overflow-auto">
        <div class="container">
        <?php
            for ($i=0; $i < 10; $i++) {
                ?>
            <div class="row my-2">
                <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
                <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
                <img class="img-grid col" alt="Filippo Champagne" src="assets/prova.png" />
            </div>

            <?php } ?>
        </div>
    </div>
</div>

<script>
    function resizeContentDiv() {
        navbar = document.getElementById("navbarDiv");
        document.getElementById("contentDiv").style.height = String(window.innerHeight - navbar.clientHeight) + "px";

        header = document.getElementById("headerDiv");
        ingredients = document.getElementById("ingredientsDiv");
        searchbar = document.getElementById("searchbarDiv");
        document.getElementById("gridDiv").style.maxHeight = String(window.innerHeight - navbar.clientHeight - header.clientHeight - searchbar.clientHeight - ingredients.clientHeight) + "px";
    }

    window.onload = resizeContentDiv;
    window.onresize = resizeContentDiv;
</script>