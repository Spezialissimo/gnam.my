<div class="container text-center font-text" id="headerDiv">
    <div class="row-2 py-2">
        <h1 class="fw-bold">Cerca</h1>
    </div>
    <!-- search field -->
    <div class="row-md-2 py-2">
        <div class="input-group rounded">
            <span class="input-group-text bg-primary border-0"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca">
    	</div>
    </div>
    <!-- ingredients -->
    <div class="row-md-2 py-2">
        <!-- Button con counter -->
        <button type="button" onclick="showSwal('Scegli ingredienti', 'Crazy')" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white">
            Ingredienti <span class="badge rounded-pill bg-accent">1</span>
        </button>
    </div>
</div>
<div class="container text-center font-text overflow-auto" id="pageContentDiv">
    <!-- search results content -->
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
