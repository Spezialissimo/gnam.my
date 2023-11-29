<div class="d-flex flex-column align-items-center p-4 h-100 justify-content-center text-center">
    <h1 class="fw-bold">Registrati</h1>
    <input type="text" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Username">
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Password">
    <input type="password" class="form-control bg-primary rounded shadow-sm mb-3 mt-3" placeholder="Conferma Password">
    <button type="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white w-50 mt-3" onclick="register();">Registrati</button>
    <hr class="mt-3">
    <p class="h6 fw-bold">Hai già un account?</p>
    <a href="login.php" role="button" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white">Accedi</a>
</div>

<script>
    const register = () => {
        // TO DO: Handling dati con PHP

        let html = '<div class="row-md-2 py-2 text-center text-black"><i class="fa-solid fa-check fa-2xl"></i></div>';
        showSwal('Profilo registrato', html);
    }
</script>