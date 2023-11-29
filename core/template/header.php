<?php

// Check if user is logged in

?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css?<?php echo time(); ?>" />
	<script src="js/main.js?<?php echo time(); ?>"></script>

	<script src="https://kit.fontawesome.com/1df86e7f33.js" crossorigin="anonymous"></script>

	<title>Gnam.my - <?php echo PAGE_TITLE ?></title>
</head>
<body class="bg h-100">
	<main class="h-100">
	<?php if(PAGE_TITLE != 'Login' && PAGE_TITLE != 'Registrati') { ?>
		<div class="container p-0">
			<div class="row p-0 m-0 overflow-hidden" id="pageDiv">
	<?php } ?>
