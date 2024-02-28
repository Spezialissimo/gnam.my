<div class="container text-center font-text text-black">
    <div class="row-2 py-2 h4">
        <h2 class="fw-bold">Pubblica Gnam</h2>
    </div>

    <div class="row container p-0 m-0 align-content-center">
        <!-- video chooser field -->
        <div class="row-md px-4 h4">
            <h3 class="fw-bold">Scegli video</h3>
            <input type="file" class="form-control bg-primary rounded shadow-sm" id="videoInput" accept="video/mp4" aria-label="Seleziona il file con il video dello gnam che vuoi pubblicare" tabindex="3" />
            <video id="hiddenVideoDiv" class="d-none position-absolute" style="height: 1px!important; width: 1px!important"></video>
            <canvas id="videoCanvas" class="d-none"></canvas>
        </div>
        <!-- thumbnail chooser field -->
        <div class="row-md px-4 h4">
            <h3 class="fw-bold">Scegli copertina</h3>
            <input type="file" class="form-control bg-primary rounded shadow-sm" id="thumbnailInput" accept="image/jpg, image/jpeg, image/png" aria-label="Seleziona il file con la copertina dello gnam che vuoi pubblicare" tabindex="3" />
        </div>
        <!-- description field -->
        <div class="row-md-6 px-4 h4">
            <h3 class="fw-bold">Descrizione</h3>
            <textarea class="form-control bg-primary rounded shadow-sm" rows="3" id="descriptionInput" aria-label="Inserisci la descrizione dello gnam che vuoi pubblicare" tabindex="3"></textarea>
        </div>
        <!-- ingredients -->
        <div class="row-sm pt-2 pb-0 ">
            <!-- Button con counter -->
            <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="ingredientsButton" aria-label="Pulsante per selezionare gli ingredienti dello gnam" tabindex="3">
                Ingredienti <span class="badge rounded-pill bg-accent" id="ingredientsCount">0</span>
            </button>
        </div>
        <!-- tag -->
        <div class="row-sm pt-1 h-0">
            <!-- Button con counter -->
            <button type="button" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white" id="hashtagsButton" aria-label="Pulsante per selezionare gli hashtag dello gnam" tabindex="3">
                Hashtag <span class="badge rounded-pill bg-accent" id="hashtagsCount">0</span>
            </button>
        </div>
        <!-- read all notification button -->
        <div class="row-md-4 pt-4">
            <a href="#" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white" id="publishBtn" aria-label="Pulsante per pubblicare il tuo gnam" tabindex="3">Pubblica Gnam</a>
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

    const getIngredientHTML = (ingredientName, ingredientId) => {
        return `<tr class="row m-0 p-0 align-items-center">
                    <td class="col-4 m-0 p-1" headers="it-header-name">
                        <p class="m-0 fs-6 text-black" aria-label="Ingrediente: ${ingredientName}" tabindex="3">${ingredientName}</p>
                    </td>
                    <td class="col-2 m-0 p-1" headers="it-header-quantity">
                        <input type="number" value="1" min="1" max="100" id="${ingredientId}Quantity" class="form-control bg-primary rounded shadow-sm fs-6 px-0 text-center" placeholder="1" aria-label="quantità di ${ingredientName}" tabindex="3" />
                    </td>
                    <td class="col-4 m-0 p-1" headers="it-header-measurement-unit"><select id="${ingredientId}MeasurementUnit" class="form-select bg-primary rounded shadow-sm fs-6" aria-label="unità di misura ${ingredientName}" tabindex="3">` +
                        measurementUnitsOptions + `</select></td>
                    <td class="col-2 m-0 p-1" headers="it-header-delete"><button type="button" aria-label="Pulsante per rimuovere l'ingrediente: ${ingredientName}" tabindex="3" class="btn btn-bounce bg-primary text-black" id="removeIngredient-${ingredientId}"><em class="fa-solid fa-trash-can" aria-hidden="true"></em></button></td>
                </tr>`;
    };

    const openIngredients = () => {
        let html = `
            <div class="d-flex align-items-center justify-content-center mb-2">
                <p class="m-0 me-2 fs-6 text-black">Numero di porzioni:</p>
                <input type="number" value="1" min="1" max="100" class="form-control bg-primary rounded shadow-sm fs-6 fw-bold text-center" id="portionsInput" aria-label="Input per inserire il numero di porzioni a cui si riferiscono gli ingredienti" tabindex="3" />
            </div>
            <div class="row mx-0 my-2">
                <div class="input-group rounded">
                    <span class="input-group-text bg-primary border-0 cursor-pointer shadow-sm" id="searchIngredientIcon">
                        <em class="fa-solid fa-magnifying-glass" aria-hidden="true"></em>
                    </span>
                    <input type="text" class="form-control bg-primary shadow-sm" placeholder="Cerca Ingredienti" id="searchIngredients" aria-label="Input per inserire degli ingredienti" tabindex="3" />
                </div>
            </div>
            <div class='border-top border-bottom border-dark py-2 my-3'>
                <p id="noIngredientsText" class="d-none text-black" tabindex="3">Non hai selezionato ingredienti.</p>
                <table class="text-center w-100 d-none" aria-label='Tabella ingredienti' tabindex="3">
                    <thead class='d-none'>
                        <tr>
                        <th id='it-header-name' class='text-start' scope='col' tabindex="3">Nome</th>
                        <th id='it-header-quantity' class='text-end' scope='col' tabindex="3">Quantità</th>
                        <th id='it-header-measurement-unit' class='text-end' scope='col' tabindex="3">Quantità</th>
                        <th id='it-header-delete' class='text-end' scope='col' tabindex="3">Quantità</th>
                        </tr>
                    </thead>
                    <tbody id="searchedIngredients">`;
        ingredients.forEach((element, index) => {
            html += getIngredientHTML(element['name'], index);
        })

        html += `    </tbody>
                </table>
            </div>
            <div class="row m-0 p-0">
                <div class="col-6">
                    <button type="button" class="btn btn-bounce rounded-pill bg-alert fw-bold text-white w-100" id="resetIngredients" aria-label="Pulsante per resettare gli ingredienti selezionati" tabindex="3">Reset</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100" id="okButtonIngredients" aria-label="Pulsante per salvare gli ingredienti selezionati" tabindex="3">Ok</button>
                </div>
            </div>
        `;


        showSwal('Scegli Ingredienti', html);
        $('#portionsInput').val(selectedPortions);
        $("#portionsInput").on("change", function(e) {
            selectedPortions = this.value;
        });

        for (let i = 0; i < ingredients.length; i++) {
            $(`[id="${i}Quantity"]`).val(ingredients[i]["quantity"]);
            $(`[id="${i}MeasurementUnit"]`).val(ingredients[i]["measurement_unit"]);
            if (ingredients[i]["measurement_unit"] == "qb") {
                $(`[id="${i}Quantity"]`).addClass("d-none");
            }
            addHandlersToIngredient(i);
        }

        if (ingredients.length == 0) {
            $("#noIngredientsText").removeClass("d-none");
            $("table").addClass("d-none");
        } else {
            $("#noIngredientsText").addClass("d-none");
            $("table").removeClass("d-none");
        }

        $('#resetIngredients').on("click", function () {
            ingredients = [];
            $("#searchedIngredients").empty();
            $("#searchedIngredients").parent().addClass("d-none");
            $('#ingredientsCount').html(ingredients.length);
            $("#noIngredientsText").removeClass("d-none");
        });

        $('#searchIngredientIcon').on("click", addIngredient);
        $('#searchIngredients').keypress(function(event) {
            if (event.which === 13) {
                addIngredient();
            }
        });

        $('#okButtonIngredients').click(closeSwal);
        $('#okButtonIngredients').keypress(function(e) {
            if (e.keyCode == 13) {
                closeSwal();
            }
        });
    }

    const addIngredient = () => {
        let newIngredientName = $('#searchIngredients').val().trim();
        if (!newIngredientName || ingredients.some(i => i["name"] === newIngredientName)) {
            return;
        }
        $("#searchedIngredients").append(getIngredientHTML(newIngredientName, ingredients.length));
        if (ingredients.length == 0) {
            $("#noIngredientsText").addClass("d-none");
            $("#searchedIngredients").parent().removeClass("d-none");
        }
        ingredients.push({"name": newIngredientName, "quantity": $(`[id="${ingredients.length}Quantity"]`).val(), "measurement_unit": $(`[id="${ingredients.length}MeasurementUnit"]`).val()});
        addHandlersToIngredient(ingredients.length - 1);
        $('#searchIngredients').val('');
        $('#ingredientsCount').html(ingredients.length);
    }

    const addHandlersToIngredient = (ingredientIndex) => {
        let quantityInput = $(`[id="${ingredientIndex}Quantity"]`);
        let measurementUnitInput = $(`[id="${ingredientIndex}MeasurementUnit"]`);

        quantityInput.on("change", function() {
            ingredients[ingredientIndex]["quantity"] = quantityInput.val();
        });

        measurementUnitInput.on("change", function() {
            ingredients[ingredientIndex]["measurement_unit"] = measurementUnitInput.val();
            if (ingredients[ingredientIndex]["measurement_unit"] == "qb") {
                quantityInput.addClass("d-none");
            } else {
                quantityInput.removeClass("d-none");
            }
        });

        $(`[id="removeIngredient-${ingredientIndex}"]`).on("click", function () {
            let ingredientRow = $(this).closest('tr');
            ingredients = ingredients.filter(ingredient => ingredient["name"] != ingredientRow.children("td:first-child").text().trim());
            ingredientRow.remove();
            $('#ingredientsCount').html(ingredients.length);
            if (ingredients.length === 0) {
                $("#noIngredientsText").removeClass("d-none");
            }
        });
    };

    const getHashtagHTML = (hashtag) => {
        return `<li class="text-black"><button type="button" aria-label="Pulsante per rimuovere l'hashtag: ${hashtag}" tabindex="3" class="btn btn-bounce bg-primary text-black" id="removeHashtag-${hashtag}">
                    <em class="fa-solid fa-trash-can" aria-hidden="true"></em></button>&nbsp#${hashtag}</li>`;
    };

    const openHashtags = () => {
        let html = `<div class="row-md-2 py-2">
                        <div class="input-group rounded">
                            <span class="input-group-text bg-primary border-0 cursor-pointer shadow-sm" id="searchHashtagIcon"><em class="fa-solid fa-magnifying-glass" aria-hidden="true"></em></span>
                            <input type="text" id="hashtagInput" class="form-control bg-primary shadow-sm" placeholder="Cerca Hashtag" aria-label="Input di testo per inserire un hashtag" tabindex="3" />
                        </div>
                    </div>
                    <hr />
                    <p id="noHashtagsText" class="d-none text-black" tabindex="3">Non hai selezionato hashtag.</p>
                    <ul class="text-center p-0" id="searchedHashtags">${hashtags.map(getHashtagHTML).join('')}</ul>
                    <hr />
                    <div class="row m-0 p-0">
                        <div class="col-6">
                            <button type="button" class="btn btn-bounce rounded-pill bg-alert fw-bold text-white w-100" id="resetHashtags" aria-label="Pulsante per resettare gli hashtag selezionati" tabindex="3" tabindex="3">Reset</button>
                        </div>
                        <div class="col-6">
                            <button type="button" id="okButton" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-100" aria-label="Pulsante per salvare gli hashtag selezionati" tabindex="3" tabindex="3">Ok</button>
                        </div>
                    </div>`;

        showSwal('Scegli hashtag', html);
        if (hashtags.length == 0) {
            $("#noHashtagsText").removeClass("d-none");
        }
        hashtags.forEach(addHandlersToHashtag);

        $('#resetHashtags').on("click", function () {
            hashtags = [];
            $("#searchedHashtags").empty();
            $('#hashtagsCount').html(hashtags.length);
            $("#noHashtagsText").removeClass("d-none");
        });

        $('#searchHashtagIcon').on("click", addHashtag);
        $('#hashtagInput').keypress(function(event) {
            if (event.which === 13) {
                addHashtag();
            }
        });

        $('#okButton').click(closeSwal);
        $('#okButton').keypress(function(e) {
            if (e.keyCode == 13) {
                closeSwal();
            }
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
        $("#searchedHashtags").append(getHashtagHTML(newHashtag));
        $('#hashtagInput').val('');
        $('#hashtagsCount').html(hashtags.length);
        addHandlersToHashtag(newHashtag);
    }

    const addHandlersToHashtag = (hashtag) => {
        $("#removeHashtag-" + hashtag).on("click", function () {
            let indexToRemove = $(this).parent().index();
            hashtags.splice(indexToRemove, 1);
            $(this).parent().remove();
            $('#hashtagsCount').html(hashtags.length);
            if (hashtags.length == 0) {
                $("#noHashtagsText").removeClass("d-none");
            }
        });
    }

    const uploadVideo = (formData) => {
        $.ajax({
            url : 'api/gnams.php',
            type : 'POST',
            data : formData,
            processData: false,
            contentType: false,
            success : function(data) {
                let html = `<div class="row-md-2 py-2 text-center text-black"><p tabindex="3">Gnam pubblicato!</p><em class="fa-solid fa-check fa-2xl" aria-hidden="true"></em></div>`;
                showSmallSwal('Successo!', html, () => {
                    window.location.reload();
                });
            }
        });
    }

    const publish = () => {
        if ($("#videoInput").prop("files").length != 1) {
            let html = `<div class="row-md-2 py-2 text-center text-black"><p tabindex="3">Nessun video selezionato!</p><em class="fa-solid fa-triangle-exclamation fa-2xl color-alert" aria-hidden="true"></em></div>`;
            showSmallSwal('Errore!', html);
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