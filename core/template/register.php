<div class="align-content-center p-4 h-100 text-center">
    <h1 class="fw-bold">Registrati</h1>
    <input type="text" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Username" id="username" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Password" id="password" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Conferma Password" id="rpassword" />
    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-50 mt-3" onclick="register();">Registrati</button>
    <hr class="mt-3">
    <p class="h6 fw-bold">Hai già un account?</p>
    <a href="login.php" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white">Accedi</a>
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

        $.post("core/?doRegister", "username=" + username + "&password=" + password + "&rpassword=", (result) => {
            if (result.includes("success")) {
                showToast("success", "<p class='fs-6 text-center pt-3'>Fatto! Accesso in corso...</p>", "home.php");
            } else showToast("error", "<p class='fs-6 text-center pt-3'>Errore!</p>");
        });
    }

    $(document).keypress(function(e) {
        if (e.which == 13) {
            register();
        }
    });
</script>