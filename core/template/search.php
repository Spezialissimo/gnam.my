<div class="container text-center font-text text-black">
    <div class="row-2 py-2">
        <h2 class="fw-bold">Cerca</h2>
    </div>
    <!-- search field -->
    <div class="row-md-2 py-2">
        <div class="input-group rounded" id="searchBar">
            <span class="input-group-text bg-primary border-0 shadow-sm cursor-pointer" id="searchIcon"><em class="fa-solid fa-magnifying-glass" aria-hidden="true"></em></span>
            <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca" id="searchBarInput" aria-label="Input di testo per la ricerca di gnam" tabindex="3" <?php if (isset($_GET["q"])) { echo 'value="' . $_GET["q"] . '" '; } ?>/>
    	</div>
    </div>
    <!-- ingredients -->
    <div class="row-md-2 py-2">
        <!-- Button con counter -->
        <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="ingredientsButton" aria-label="Pulsante per inserire ingredienti che devono comparire negli gnam cercati" tabindex="3">
            Ingredienti <span class="badge rounded-pill bg-accent" id="ingredientsCount">0</span>
        </button>
    </div>
</div>

<div class="d-none justify-content-center align-items-center mt-5" id="loaderDiv">
  <div class="loadingspinner"></div>
</div>

<div class="d-none container" id="searchResultsDiv">
    <!-- search results content -->
</div>

<script>
    let ingredients = [];
    let currentResult;

    document.onkeypress = function(e) {
        if (e.keyCode == 13) {
            document.activeElement.click();
        }
    }

    const getIngredientHTML = (ingredient) => {
        return `<li class="text-black"><button type="button" aria-label="Pulsante per rimuovere l'ingrediente: ${ingredient}" tabindex="3" class="btn btn-bounce bg-primary text-black" id="removeIngredient-${ingredient}">
                    <em class="fa-solid fa-trash-can" aria-hidden="true"></em></button>&nbsp${ingredient}</li>`;
    };

    const openIngredients = () => {
        let html = `<div class="row-md-2 py-2">
                        <div class="input-group rounded">
                            <span class="input-group-text bg-primary border-0 shadow-sm cursor-pointer" id="searchIngredientsIcon"><em class="fa-solid fa-magnifying-glass"></em></span>
                            <input type="text" id="ingredientInput" class="form-control bg-primary shadow-sm" placeholder="Cerca Ingredienti" aria-label="Input di testo per inserire i ingredienti" tabindex="3" />
                        </div>
                    </div>
                    <hr />
                    <p id="noIngredientsText" class="d-none text-black" tabindex="3">Non hai selezionato ingredienti.</p>
                    <ul class="text-center p-0" id="searchedIngredients">${ingredients.map(getIngredientHTML).join('')}</ul>
                    <hr />
                    <div class="row m-0 p-0">
                        <div class="col-6">
                            <button type="button" class="btn btn-bounce rounded-pill bg-alert fw-bold text-white w-100" id="resetIngredients" aria-label="Pulsante per resettare gli ingredienti inseriti" tabindex="3">Reset</button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="okButton" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100" aria-label="Pulsante per confermare gli ingredienti inseriti" tabindex="3">Ok</button>
                        </div>
                    </div>`;

        showSwal('Scegli ingredienti', html);
        if (ingredients.length == 0) {
            $("#noIngredientsText").removeClass("d-none");
        }
        ingredients.forEach(addHandlersToIngredient);

        $("#resetIngredients").on("click", function () {
            ingredients = [];
            $("#searchedIngredients").empty();
            $('#ingredientsCount').html(ingredients.length);
            $("#noIngredientsText").removeClass("d-none");
        });

        $('#searchIngredientsIcon').on("click", addIngredient);
        $('#ingredientInput').keypress(function(event) {
            if (event.which === 13) {
                addIngredient();
            }
        });

        $('#okButton').click(closeSwal);
        $('#okButton').keypress(function(e) {
            if (e.keyCode == 13) {
                closeSwal();
            }
        });
    }

    const addIngredient = () => {
        let newIngredient = $('#ingredientInput').val().trim();
        if (!newIngredient || ingredients.includes(newIngredient)) {
            return;
        }
        if (ingredients.length == 0) {
            $("#noIngredientsText").addClass("d-none");
        }
        ingredients.push(newIngredient);
        $("#searchedIngredients").append(getIngredientHTML(newIngredient));
        $('#ingredientInput').val('');
        $('#ingredientsCount').html(ingredients.length);
        addHandlersToIngredient(newIngredient);
    }

    const addHandlersToIngredient = (ingredient) => {
        $(`[id="removeIngredient-${ingredient}"]`).on("click", function () {
            let indexToRemove = $(this).parent().index();
            ingredients.splice(indexToRemove, 1);
            $(this).parent().remove();
            $('#ingredientsCount').html(ingredients.length);
            if (ingredients.length == 0) {
                $("#noIngredientsText").removeClass("d-none");
            }
        });
    }

    const searchVideos = () => {
        let query = $('#searchBarInput').val().trim();

        $('#searchBarInput').val('');
        $('#searchResultsDiv').addClass('d-none');
        $('#loaderDiv').addClass('d-flex').removeClass('d-none');

        $.get("api/search.php", {
            query: query,
            api_key: "<?php echo $_SESSION['api_key']; ?>",
            ingredients: JSON.stringify(ingredients),
            action: "byQuery"
        }, (result) => {
            $('#loaderDiv').removeClass('d-flex').addClass('d-none');
            $('#searchResultsDiv').removeClass('d-none');
            $('#searchResultsDiv').html('');
            currentResult = JSON.parse(result);

            if (result === '[]') {
                $('#searchResultsDiv').html('<div class="fs-6 mt-4 text-center text-black" tabindex="3">Nessuno gnam trovato.</div>');
                return;
            }

            let gnamPerRow = 3;
            let rowDiv = $('<div class="row my-3">');

            for (let o in currentResult) {
                let img = $(`<img class="img-grid px-2 col-4 btn-bounce cursor-pointer" id="searchResultGnam-${currentResult[o].id}" alt="Copertina gnam di ${currentResult[o].name}" src="assets/gnams_thumbnails/${currentResult[o].id}.jpg" aria-label="Copertina dello gnam ${rowDiv.children.length + (3 - gnamPerRow) + 1} di ${currentResult[o].name}"  tabindex="3" />`);
                rowDiv.append(img);
                gnamPerRow--;

                if (gnamPerRow === 0) {
                    $('#searchResultsDiv').append(rowDiv);
                    rowDiv = $('</div><div class="row my-3">');
                    gnamPerRow = 3;
                }
            }

            if (gnamPerRow !== 3) {
                $('#searchResultsDiv').append(rowDiv);
            }

            currentResult.forEach(gnam => {
                $(`[id="searchResultGnam-${gnam["id"]}"]`).on('click', function() {
                    setGnamsToWatchFrom(gnam["id"], currentResult);
                });
            });
        });
    }

    $(document).ready(function(){
        $('#searchBar').keypress(function(e) {
            if (e.which === 13){
                searchVideos();
            }
        });

        $("#ingredientsButton").on("click", openIngredients);
        $('#searchIcon').on("click", searchVideos);
    });
</script>
