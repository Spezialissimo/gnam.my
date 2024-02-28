<?php if(PAGE_TITLE != 'Login' && PAGE_TITLE != 'Registrati') { ?>
			</div>
		</div>
	</main>
	<nav class="m-0" aria-live="off">
		<div class="w-100 d-flex" id="navbarContentDiv">
			<div class="btn-bounce d-flex flex-row align-items-center justify-content-center">
				<a href="home.php" class="d-flex border-0 align-self-center" role="button" tabindex="1" aria-label="Vai alla pagina home">
					<img class="bg-primary align-self-center" alt="Pagina Home" src="assets/home.png" /><span class="nav-text text-button fw-semibold color-accent">Home</span>
				</a>
			</div>
			<div class="btn-bounce d-flex flex-row align-items-center justify-content-center">
				<a href="search.php" class="d-flex border-0 align-self-center" role="button" tabindex="1" aria-label="Vai alla pagina per cercare gnam">
					<img class="bg-primary align-self-center" alt="Pagina Cerca" src="assets/search.png" /><span class="nav-text text-button fw-semibold color-accent">Cerca</span>
				</a>
			</div>
			<div class="btn-bounce d-flex flex-row align-items-center justify-content-center">
				<a href="publish.php" class="d-flex border-0 align-self-center" role="button" tabindex="1" aria-label="Vai alla pagina per pubblicare uno gnam">
					<img class="bg-primary align-self-center" alt="Pagina Pubblica" src="assets/publish.png" />
					<span class="nav-text text-button fw-semibold color-accent">Pubblica</span>
				</a>
			</div>
			<div class="btn-bounce d-flex flex-row align-items-center justify-content-center">
				<a href="notifications.php" class="d-flex border-0 align-self-center" role="button" tabindex="1" aria-label="Vai alla pagina per vedere le notifiche">
					<img class="bg-primary align-self-center" alt="Pagina Notifiche" src="assets/notifications.png" id="notificationsNavbarImg" />
					<span class="nav-text text-button fw-semibold color-accent">Notifiche</span>
				</a>
			</div>
			<div class="btn-bounce d-flex flex-row align-items-center justify-content-center">
				<a href="profile.php" class="d-flex border-0 align-self-center" role="button" tabindex="1" aria-label="Vai alla pagina per vedere il tuo profilo">
					<img class="bg-primary align-self-center" alt="Pagina Profilo" src="assets/profile.png" />
					<span class="nav-text text-button fw-semibold color-accent">Profilo</span>
				</a>
			</div>
		</div>
	</nav>
	<?php } ?>
</body>
</html>
