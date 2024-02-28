<?php

require_once("core/functions.php");

if (!isloggedIn() && PAGE_TITLE != 'Login' && PAGE_TITLE != 'Registrati') {
	header("Location: login.php");
}

if (isloggedIn() && (PAGE_TITLE == 'Login' || PAGE_TITLE == 'Registrati')) {
	header("Location: profile.php");
}

?>
<!DOCTYPE html>
<html lang="it" class="h-100">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="assets/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css" />
	<script src="js/main.js"></script>

	<script src="https://kit.fontawesome.com/1df86e7f33.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

	<title>Gnam.my - <?php echo PAGE_TITLE ?></title>
</head>
<body class="bg w-100 h-100">
	<?php if (isloggedIn()) { ?>
	<script>
		let notified = false;
		let focusedElement;

		const checkNotifications = () => {
			$.get("api/notifications.php", { api_key: "<?php echo $_SESSION['api_key']; ?>" }, function(data) {
				if (JSON.parse(data).length > 0) {
					$("#notificationsNavbarImg").attr("src", "assets/notifications-alert.png");
					if (!notified) {
						setTimeout(function() {
							notified = true;
							let announceLiveRegion = $('<div>', {
								role: 'status',
								'aria-live': 'polite',
								'aria-atomic': 'true',
								class: 'text-hide'
							}).appendTo('body');
							announceLiveRegion.text("Hai notifiche da leggere!");
							focusedElement = document.activeElement;
							announceLiveRegion.focus();
						}, 3000);
						setTimeout(function() {
							focusedElement.focus();
							$('[role="status"]').remove();
						}, 5000);
					}
				} else {
					$("#notificationsNavbarImg").attr("src", "assets/notifications.png");
					if (notified) {
						notified = false;
					}
				}
			});
		};

		$(window).on("load", function() {
			checkNotifications();
			setInterval(checkNotifications, 5000);
		});
	</script>
	<?php } ?>
	<?php if(PAGE_TITLE != 'Login' && PAGE_TITLE != 'Registrati') { ?>
		<main class="d-flex" id="mainDiv">
		<div class="d-flex w-100 h-100 p-0 m-0" id="pageContainer">
			<div class="p-0 m-0 w-100<?php echo PAGE_TITLE != 'Home' ? " overflow-auto" : ""; ?>" id="pageDiv">
	<?php } else { ?>
		<main class="align-content-center">
	<?php }?>