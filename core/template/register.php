<div class="align-content-center p-4 h-100 text-center">
    <h1 class="fw-bold">Registrati</h1>
    <input type="text" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Username" id="username" title="username" aria-label="username" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Password" id="password" title="password" aria-label="password" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Conferma Password" id="rpassword" title="confermaPassword" aria-label="confermaPassword" />
    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-50 mt-3" id="registerButton">Registrati</button>
    <hr class="mt-3 w-75" />
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