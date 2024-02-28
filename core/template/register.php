<div class="align-content-center p-4 h-100 text-center">
    <header class="header-log-sign">
        <h1 class="hide center logo-center" tabindex="1" aria-label="Logo del sito: Gnammy">Gnammy</h1>
        <h2 class="fw-bold">Registrati</h2>
    </header>
    <input type="text" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Username" id="username" aria-label="Input di testo per inserire l'username" tabindex="3" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Password" id="password" aria-label="Input di testo per inserire la password" tabindex="3" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Conferma Password" id="rpassword" aria-label="Input di testo per confermare la password" tabindex="3" />
    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-50 mt-3" id="registerButton" aria-label="Pulsante per registrarsi" tabindex="3">Registrati</button>
    <hr class="mt-3 w-75" />
    <p class="h6 fw-bold">Hai già un account?</p>
    <a href="login.php" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white" aria-label="Pulsante per accedere" tabindex="3">Accedi</a>
</div>

<script>
    const register = () => {
        const username = $("#username").val();
        const password = $("#password").val();
        const rpassword = $("#rpassword").val();

        if(password == "" || rpassword == "" || username == "") {
            showToast("error", "<p class='fs-6 text-center pt-3'>Compila tutti i campi</p>");
            return;
        }

        if (password != rpassword) {
            showToast("error", "<p class='fs-6 text-center pt-3'>Le password non coincidono</p>");
            return;
        }

        $.post("api/users.php", {
            username: username,
            password: password,
            rpassword: rpassword,
            action: "register"
        }, (result) => {
            let decodedResult = JSON.parse(result);
            if (decodedResult.status === "success") {
                showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>", "login.php");
            } else showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>");
        });
    }

    $(document).keypress(function(e) {
        if (e.which == 13) {
            register();
        }
    });

    $("#registerButton").on("click", register);
</script>