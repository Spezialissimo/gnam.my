<div class="container text-center font-text" id="headerDiv">
    <div class="row-2 py-2">
        <h1 class="fw-bold">Cerca</h1>
    </div>
    <!-- search field -->
    <div class="row-md-2 py-2">
        <div class="input-group rounded" id="searchBar">
            <span class="input-group-text bg-primary border-0" id="searchIcon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca" id="searchBarInput" />
    	</div>
    </div>
    <!-- ingredients -->
    <div class="row-md-2 py-2">
        <!-- Button con counter -->
        <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="ingredientsButton">
            Ingredienti <span class="badge rounded-pill bg-accent" id="ingredientsCount">0</span>
        </button>
    </div>
</div>

<div class="d-none justify-content-center align-items-center mt-5" id="loaderDiv">
  <div class="loadingspinner"></div>
</div>

<div class="d-none container overflow-y-scroll" id="pageContentDiv">
    <!-- search results content -->
</div>

<script>
    let ingredients = [];

    const openIngredients = () => {
        let modalContent = '';

        if (ingredients.length > 0) {
            modalContent = ingredients.map(ingredient => `
                <p class="text-black"><button type="button" class="btn btn-bounce bg-primary text-black" onclick="removeIngredient(this)">
                    <i class="fa-solid fa-trash-can"></i></button>&nbsp${ingredient}</p>
            `).join('');
        }

        let html = `<div class="row-md-2 py-2">
                        <div class="input-group rounded">
                            <span class="input-group-text bg-primary border-0" id="searchIngredientsIcon"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" id="ingredientInput" class="form-control bg-primary shadow-sm" placeholder="Cerca Ingredienti" />
                        </div>
                    </div>
                    <hr />
                    <p id="noIngredientsText" class="d-none">Non hai selezionato ingredienti.</p>
                    <div class="text-center" id="searchedIngredients">${modalContent}</div>
                    <hr />
                    <div class="row m-0 p-0">
                        <div class="col-6">
                            <button type="button" class="btn btn-bounce rounded-pill bg-alert fw-bold text-white w-100" id="resetIngredients">Reset</button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="okButton" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100">Ok</button>
                        </div>
                    </div>`;

        const modal = showSwal('Scegli ingredienti', html);

        if (ingredients.length == 0) {
            $("#noIngredientsText").removeClass("d-none");
        }
        $('#searchIngredientsIcon').on("click", addIngredient);
        $('#ingredientInput').keypress(function(event) {
            if (event.which === 13) {
                addIngredient();
            }
        });

        $('#okButton').click(function() {
            closeSwal();
        });
        $("#resetIngredients").on("click", resetIngredients);
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
        $("#searchedIngredients").append(`
            <p class="text-black"><button type="button" class="btn btn-bounce bg-primary text-black" onclick="removeIngredient(this)">
                <i class="fa-solid fa-trash-can"></i></button>&nbsp${newIngredient}</p>
        `);
        $('#ingredientInput').val('');
        $('#ingredientsCount').html(ingredients.length);
    }

    const removeIngredient = (element) => {
        let indexToRemove = $(element).parent().index();
        ingredients.splice(indexToRemove, 1);
        $(element).parent().remove();
        $('#ingredientsCount').html(ingredients.length);
        if (ingredients.length == 0) {
            $("#noIngredientsText").removeClass("d-none");
        }
    }

    const resetIngredients = () => {
        ingredients = [];
        $("#searchedIngredients").empty();
        $('#ingredientsCount').html(ingredients.length);
        $("#noIngredientsText").removeClass("d-none");
    }

    const searchVideos = () => {
        let query = $('#searchBarInput').val().trim();

        if (!query) { return; }

        $('#searchBarInput').val('');
        $('#pageContentDiv').addClass('d-none');
        $('#loaderDiv').addClass('d-flex').removeClass('d-none');

        $.get("api/search.php", {
            query: query,
            api_key: "<?php echo $_SESSION['api_key']; ?>",
            action: "byQuery"
        }, (result) => {
            $('#loaderDiv').removeClass('d-flex').addClass('d-none');
            $('#pageContentDiv').removeClass('d-none');
            $('#pageContentDiv').html('');
            let decodedResult = JSON.parse(result);

            if (result === '[]') {
                $('#pageContentDiv').html('<div class="fs-6 mt-4 text-center">Nessuno gnam trovato.</div>');
                return;
            }
            
            let gnamPerRow = 3;
            let rowDiv = $('<div class="row my-3">');

            for (let o in decodedResult) {
                let img = $(`<img class="img-grid col-4 btn-bounce" onclick="window.location.href = 'home.php?gnam=${decodedResult[o].id}'" alt="Copertina gnam" src="assets/gnams_thumbnails/${decodedResult[o].id}.jpg" />`);
                rowDiv.append(img);
                gnamPerRow--;

                if (gnamPerRow === 0) {
                    $('#pageContentDiv').append(rowDiv);
                    rowDiv = $('</div><div class="row my-3">');
                    gnamPerRow = 3;
                }
            }
            
            if (gnamPerRow !== 3) {
                $('#pageContentDiv').append(rowDiv);
            }
        });
    }

    $("#ingredientsButton").on("click", openIngredients);

    $(document).ready(function(){
        $('#searchBar').keypress(function(e) {
            if (e.which === 13){
                searchVideos();
            }
        });
        $('#searchIcon').on("click", searchVideos);
    });
</script>