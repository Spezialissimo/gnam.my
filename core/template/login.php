<div class="align-content-center p-4 h-100">
    <header class="header-log-sign">
        <h1 class="hide center logo-center">Gnammy</h1>
        <h2 class="fw-bold">Accedi</h2>
    </header>
    <input type="text" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Username" id="username" aria-label="Input di testo per inserire l'username" tabindex="3" />
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-4" placeholder="Password" id="password" aria-label="Input di testo per inserire la password" tabindex="3" />
    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-50 mt-3" id="loginButton" aria-label="Pulsante per effettuare il login" tabindex="3">Login</button>
    <hr class="mt-3 w-75" />
    <p class="h6 fw-bold">Non hai un account?</p>
    <a href="register.php" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white" aria-label="Pulsante per registrarsi" tabindex="3">Registrati</a>
    <button type="button" class="btn btn-bounce rounded bg-alert fw-bold text-white w-50 mt-3" id="loginDemoButton" aria-label="Login with demo account" tabindex="3">Login with demo account</button>
</div>

<script>
    const login = () => {
        const username = $("#username").val();
        const password = $("#password").val();

        if(username == "" || password == "") {
            showToast("error", "<p class='fs-6 text-center pt-3'>Compila tutti i campi</p>");
            return;
        }

        $.post("api/login.php", {
            "username": username,
            "password": password
        }, (result) => {
            let decodedResult = JSON.parse(result);
            if (decodedResult.status === "success") {
                showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>", "home.php");
            } else showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>");
        });
    }

    const loginDemo = () => {
        const username = "Davide";
        const password = "Davide";

        $.post("api/login.php", {
            "username": username,
            "password": password
        }, (result) => {
            let decodedResult = JSON.parse(result);
            if (decodedResult.status === "success") {
                showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>", "home.php");
            } else showToast(decodedResult.status, "<p class='fs-6 text-center pt-3'>" + decodedResult.message + "</p>");
        });
    }

    document.onkeypress = function(e) {
        if (e.keyCode == 13) {
            login();
        }
    }

    $("#loginButton").on("click", login);
    $("#loginDemoButton").on("click", loginDemo);
</script>