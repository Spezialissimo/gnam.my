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
<html class="h-100">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="assets/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css?<?php echo time(); ?>" />
	<script src="js/main.js?<?php echo time(); ?>"></script>

	<script src="https://kit.fontawesome.com/1df86e7f33.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

	<title>Gnam.my - <?php echo PAGE_TITLE ?></title>
</head>
<body class="bg w-100 h-100">
	<?php if (isloggedIn()) { ?>
	<script>
		const checkNotifications = () => {
			$.get("api/notifications.php", { api_key: "<?php echo $_SESSION['api_key']; ?>" }, function(data) {
				if (JSON.parse(data).length > 0) {
					$("#notificationsNavbarButton").addClass("color-alert");
					$("#notificationsNavbarButton").removeClass("color-accent");
					$("#notificationsNavbarButton").removeClass("nav-btn");
				} else {
					$("#notificationsNavbarButton").addClass("nav-btn");
					$("#notificationsNavbarButton").addClass("color-accent");
					$("#notificationsNavbarButton").removeClass("color-alert");
				}
			});
		};

		$(window).on("load", function() {
			checkNotifications();
			setInterval(checkNotifications, 2000);
		});
	</script>
	<?php } ?>
	<main class="w-100 h-100 d-flex" id="mainDiv">
	<?php if(PAGE_TITLE != 'Login' && PAGE_TITLE != 'Registrati') { ?>
		<div class="container d-flex w-100 h-100 p-0 m-0" id="pageContainer">
			<div class="row p-0 m-0 w-100 overflow-hidden" id="pageDiv">
				<div class="position-relative w-100 h-100 p-0" id="pageBodyDiv">
	<?php } ?>