<div class="container text-center font-text">
    <div class="row-2 py-2 h4">
        <h1 class="fw-bold">Pubblica Gnam</h1>
    </div>

    <div class="row container p-0 m-0 align-content-center" id="pageContentDiv">
        <!-- video chooser field -->
        <div class="row-md px-4 h4">
            <h2 class="fw-bold">Scegli video</h2>
            <input type="file" class="form-control bg-primary rounded shadow-sm" id="videoInput" accept="video/mp4" />
            <video id="hiddenVideoDiv" class="d-none position-absolute" style="height: 1px!important; width: 1px!important"></video>
            <canvas id="videoCanvas" class="d-none"></canvas>
        </div>
        <!-- thumbnail chooser field -->
        <div class="row-md px-4 h4">
            <h2 class="fw-bold">Scegli copertina</h2>
            <input type="file" class="form-control bg-primary rounded shadow-sm" id="thumbnailInput" accept="image/jpg, image/jpeg, image/png" />
        </div>
        <!-- description field -->
        <div class="row-md-6 px-4 h4">
            <h2 class="fw-bold">Descrizione</h2>
            <textarea class="form-control bg-primary rounded shadow-sm" rows="3" id="descriptionInput"></textarea>
        </div>
        <!-- ingredients -->
        <div class="row-sm pt-2 pb-0 ">
            <!-- Button con counter -->
            <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="ingredientsButton">
                Ingredienti <span class="badge rounded-pill bg-accent" id="ingredientsCount">0</span>
            </button>
        </div>
        <!-- tag -->
        <div class="row-sm pt-1 h-0">
            <!-- Button con counter -->
            <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="hashtagsButton" >
                Hashtag <span class="badge rounded-pill bg-accent" id="hashtagsCount">0</span>
            </button>
        </div>
        <!-- read all notification button -->
        <div class="row-md-4 pt-4">
            <a href="#" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white" id="publishBtn">Pubblica Gnam</a>
        </div>
    </div>
</div>

<script>
    let measurementUnits = <?php
        global $db;
        $stmt = $db->prepare("SELECT `name` FROM `measurement_units`");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    ?>;
    let measurementUnitsOptions = "";
    measurementUnits.forEach(unit => {
        measurementUnitsOptions += "<option>" + unit["name"] + "</option>";
    });

    let hashtags = [];
    let ingredients = [];
    let selectedPortions = 1;

    const openIngredients = () => {
        let modalContent = '';

        if (ingredients.length > 0) {
            modalContent = ingredients.map(ingredient => `
                <div class="row m-0 p-0 align-items-center text-black">
                    <div class="col-3 m-0 p-1">
                        <p class="m-0 fs-7">${ingredient["name"]}</p>
                    </div>
                    <div class="col-3 m-0 p-1">
                        <input type="number" id="${ingredient["name"]}Quantity" class="form-control bg-primary rounded shadow-sm fs-7 text-black" placeholder="1" />
                    </div>
                    <div class="col-4 m-0 p-1"><select id="${ingredient["name"]}MeasurementUnit" class="form-select bg-primary rounded shadow-sm fs-7 text-black">` +
                        measurementUnitsOptions + `</select></div>
                    <div class="col-2 m-0 p-1"><button type="button" class="btn btn-bounce bg-primary text-black fs-7"
                            onclick="removeIngredient(this)"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button></div>
                </div>
            `).join('');
        }

        let html = `
            <div class="d-flex align-items-center justify-content-center mb-2">
                <p class="m-0 me-2 fs-6">Numero di porzioni:</p>
                <input type="number" value="1" min="1" max="100" class="form-control bg-primary rounded shadow-sm fs-6 fw-bold text-center" id="portionsInput" />
            </div>
            <div class="row mx-0 my-2">
                <div class="input-group rounded">
                    <span class="input-group-text bg-primary border-0" id="searchIngredientIcon">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca Ingredienti" id="searchIngredients" />
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
                    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100" id="okButtonIngredients">Ok</button>
                </div>
            </div>
        `;

        const modal = showSwal('Scegli Ingredienti', html);
        $('#portionsInput').val(selectedPortions);
        $("#portionsInput").on("change", function(e) {
            selectedPortions = this.value;
        });
        ingredients.forEach(ingredient => {
            $('[id="' + ingredient["name"] + 'Quantity"]').val(ingredient["quantity"]);
            $('[id="' + ingredient["name"] + 'MeasurementUnit"]').val(ingredient["measurement_unit"]);
            $('[id="' + ingredient["name"] + 'Quantity"]').on("change", function() {
                ingredient["quantity"] = $('[id="' + ingredient["name"] + 'Quantity"]').val();
            });
            $('[id="' + ingredient["name"] + 'MeasurementUnit"]').on("change", function() {
                if (ingredient["measurement_unit"] == "qb") {
                    $('[id="' + ingredient["name"] + 'Quantity"]').removeClass("d-none");
                }
                ingredient["measurement_unit"] = $('[id="' + ingredient["name"] + 'MeasurementUnit"]').val();
                if (ingredient["measurement_unit"] == "qb") {
                    $('[id="' + ingredient["name"] + 'Quantity"]').addClass("d-none");
                }
            });
            if (ingredient["measurement_unit"] == "qb") {
                $('[id="' + ingredient["name"] + 'Quantity"]').addClass("d-none");
            }
        });

        if (ingredients.length == 0) {
            $("#noIngredientsText").removeClass("d-none");
        }
        $('#searchIngredientIcon').on("click", addIngredient);
        $('#resetIngredients').on("click", resetIngredients);
        $('#searchIngredients').keypress(function(event) {
            if (event.which === 13) {
                addIngredient();
            }
        });

        $('#okButtonIngredients').click(function() {
            closeSwal();
        });
    }

    const addIngredient = () => {
        let newIngredient = $('#searchIngredients').val().trim();
        if (!newIngredient || ingredients.some(i => i["name"] === newIngredient)) {
            return;
        }
        $("#searchedIngredients").append(`
            <div class="row text-black m-0 p-0 align-items-center text-black">
                <div class="col-3 m-0 p-1">
                    <p class="m-0 fs-7">${newIngredient}</p>
                </div>
                <div class="col-3 m-0 p-1">
                    <input type="number" id="${newIngredient}Quantity" class="form-control bg-primary rounded shadow-sm fs-7 text-black" placeholder="1" />
                </div>
                <div class="col-4 m-0 p-1"><select id="${newIngredient}MeasurementUnit" class="form-select bg-primary rounded shadow-sm fs-7 text-black">` +
                    measurementUnitsOptions + `</select></div>
                <div class="col-2 m-0 p-1"><button type="button" class="btn btn-bounce bg-primary text-black fs-7"
                        onclick="removeIngredient(this)"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button></div>
            </div>
        `);
        if (ingredients.length == 0) {
            $("#noIngredientsText").addClass("d-none");
        }
        ingredients.push({"name": newIngredient, "quantity": $('[id="' + newIngredient + 'Quantity"]').val(), "measurement_unit": $('[id="' + newIngredient + 'MeasurementUnit"]').val()});
        let newIngredientIndex = ingredients.length - 1;
        $('[id="' + newIngredient + 'Quantity"]').on("change", function() {
            ingredients[newIngredientIndex]["quantity"] = $('[id="' + newIngredient + 'Quantity"]').val();
        });
        $('[id="' + newIngredient + 'MeasurementUnit"]').on("change", function() {
            if (ingredients[newIngredientIndex]["measurement_unit"] == "qb") {
                $('[id="' + newIngredient + 'Quantity"]').removeClass("d-none");
            }
            ingredients[newIngredientIndex]["measurement_unit"] = $('[id="' + newIngredient + 'MeasurementUnit"]').val();
            if (ingredients[newIngredientIndex]["measurement_unit"] == "qb") {
                $('[id="' + newIngredient + 'Quantity"]').addClass("d-none");
            }
        });
        if (ingredients[newIngredientIndex]["measurement_unit"] == "qb") {
            $('[id="' + newIngredient + 'Quantity"]').addClass("d-none");
        }
        $('#searchIngredients').val('');
        $('#ingredientsCount').html(ingredients.length);
    }

    const removeIngredient = (element) => {
        let ingredientRow = $(element).closest('.row');
        let ingredientName = ingredientRow.find('p').text().trim();
        ingredients = ingredients.filter(ingredient => ingredient["name"] !== ingredientName);
        ingredientRow.remove();
        $('#ingredientsCount').html(ingredients.length);
        if (ingredients.length === 0) {
            $("#noIngredientsText").removeClass("d-none");
        }
    }

    const resetIngredients = () => {
        ingredients = [];
        $("#searchedIngredients").empty();
        $('#ingredientsCount').html(ingredients.length);
        $("#noIngredientsText").removeClass("d-none");
    }

    const openHashtags = () => {
        let modalContent = '';

        if (hashtags.length > 0) {
            modalContent = hashtags.map(hashtag => `
                <p class="text-black"><button type="button" class="btn btn-bounce bg-primary text-black" onclick="removeHashtag(this)">
                    <i class="fa-solid fa-trash-can"></i></button>&nbsp#${hashtag}</p>
            `).join('');
        }

        let html = `<div class="row-md-2 py-2">
                        <div class="input-group rounded">
                            <span class="input-group-text bg-primary border-0" id="searchHashtagIcon"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" id="hashtagInput" class="form-control bg-primary shadow-sm" placeholder="Cerca Hashtag" />
                        </div>
                    </div>
                    <hr />
                    <p id="noHashtagsText" class="d-none">Non hai selezionato hashtag.</p>
                    <div class="text-center" id="searchedHashtags">${modalContent}</div>
                    <hr />
                    <div class="row m-0 p-0">
                        <div class="col-6">
                            <button type="button" class="btn btn-bounce rounded-pill bg-alert fw-bold text-white w-100" id="resetHashtags">Reset</button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="okButton" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100">Ok</button>
                        </div>
                    </div>`;

        const modal = showSwal('Scegli hashtag', html);

        if (hashtags.length == 0) {
            $("#noHashtagsText").removeClass("d-none");
        }
        $('#searchHashtagIcon').on("click", addHashtag);
        $('#resetHashtags').on("click", resetHashtags);
        $('#hashtagInput').keypress(function(event) {
            if (event.which === 13) {
                addHashtag();
            }
        });

        $('#okButton').click(function() {
            closeSwal();
        });
    }

    const addHashtag = () => {
        let newHashtag = $('#hashtagInput').val().trim();
        while(newHashtag.startsWith('#')) {
            newHashtag = newHashtag.slice(1);
        }
        if(!newHashtag) {
            return
        }
        newHashtag = newHashtag.replace(/(?:^\w|[A-Z]|\b\w)/g, (w, i) => {return w.toUpperCase()}).replace(/\s+/g, '');
        if (hashtags.includes(newHashtag)) {
            return;
        }
        if (hashtags.length == 0) {
            $("#noHashtagsText").addClass("d-none");
        }
        hashtags.push(newHashtag);
        $("#searchedHashtags").append(`
            <p class="text-black"><button type="button" class="btn btn-bounce bg-primary text-black" onclick="removeHashtag(this)">
                <i class="fa-solid fa-trash-can"></i></button>&nbsp#${newHashtag}</p>
        `);
        $('#hashtagInput').val('');
        $('#hashtagsCount').html(hashtags.length);
    }

    const removeHashtag = (element) => {
        let indexToRemove = $(element).parent().index();
        hashtags.splice(indexToRemove, 1);
        $(element).parent().remove();
        $('#hashtagsCount').html(hashtags.length);
        if (hashtags.length == 0) {
            $("#noHashtagsText").removeClass("d-none");
        }
    }

    const resetHashtags = () => {
        hashtags = [];
        $("#searchedHashtags").empty();
        $('#hashtagsCount').html(hashtags.length);
        $("#noHashtagsText").removeClass("d-none");
    }

    const uploadVideo = (formData) => {
        $.ajax({
            url : 'api/gnams.php',
            type : 'POST',
            data : formData,
            processData: false,
            contentType: false,
            success : function(data) {
                let html = `<div class="row-md-2 py-2 text-center text-black"><i class="fa-solid fa-check fa-2xl"></i></div>`;
                showSwalSmall('Gnam pubblicato', html, () => {
                    window.location.reload();
                });
            }
        });
    }

    const publish = () => {
        if ($("#videoInput").prop("files").length != 1) {
            let html = `<div class="row-md-2 py-2 text-center text-black"><p>Nessun video selezionato!</p><i class="fa-solid fa-triangle-exclamation fa-2xl color-alert"></i></div>`;
            showSwalSmall('Errore!', html);
        } else {
            let scaledIngredients = [];
            ingredients.forEach(i => {
                newI = i;
                newI["quantity"] /= selectedPortions;
                scaledIngredients.push(newI);
            });

            let formData = new FormData();
            formData.append("video", $("#videoInput").prop("files")[0]);
            formData.append("description", $("#descriptionInput").val());
            formData.append("ingredients", JSON.stringify(scaledIngredients));
            formData.append("hashtags", JSON.stringify(hashtags));
            formData.append("action", "create");
            formData.append("api_key", "<?php echo $_SESSION['api_key']; ?>");
            if ($("#thumbnailInput").prop("files").length == 1) {
                formData.append("thumbnail", $("#thumbnailInput").prop("files")[0]);
                uploadVideo(formData);
            } else {
                $("#hiddenVideoDiv").removeClass("d-none");
                setTimeout(function() {
                    let videoCanvas = $("#videoCanvas")[0];
                    videoCanvas.width = $("#hiddenVideoDiv")[0].videoWidth;
                    videoCanvas.height = $("#hiddenVideoDiv")[0].videoHeight;
                    videoCanvas.getContext("2d").drawImage($("#hiddenVideoDiv")[0], 0, 0, videoCanvas.width, videoCanvas.height);
                    videoCanvas.toBlob(function(blob) {
                        formData.append("thumbnail", blob, "blob.jpg");
                        uploadVideo(formData);
                    }, "image/jpg");
                    $("#hiddenVideoDiv").addClass("d-none");
                }, 200);
            }
        }
    }

    $("#publishBtn").on("click", publish);
    $("#hashtagsButton").on("click", openHashtags);
    $("#ingredientsButton").on("click", openIngredients);
    $("#videoInput").on("change", function() {
        $("#hiddenVideoDiv").attr("src", URL.createObjectURL($("#videoInput").prop("files")[0]));
    });
</script>