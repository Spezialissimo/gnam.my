<div class="container text-center font-text text-black">
    <div class="row-2 py-2">
        <h2 class="fw-bold">Notifications</h2>
    </div>
    <div class="row-md-8 align-content-center">
        <?php
            global $assetsPath;
            $notifications = getNotifications($_SESSION["api_key"]);
            if (count($notifications) > 0) { ?>
            <div class="container h-auto w-auto" id="notificationsContainer">
                <?php foreach ($notifications as $notification) { ?>
                <div class="row m-1 p-0" aria-label="Notifica con testo: <?php echo $notification["source_user_name"] . $notification["template_text"] ?>, arrivata <?php echo formatTimestampDiff($notification["timestamp"], time()); ?> fa" tabindex="3" role="button">
                    <a id="notification<?php echo $notification['notification_id'] ?>" class="btn btn-bounce rounded-pill bg-primary p-2 notification-pill-text notification-btn d-flex flex-row align-items-center justify-content-between">
                        <img class="border border-1 border-dark rounded-circle me-3 me-md-4" style="width: 10%" alt="<?php echo $notification['source_user_name'] ?>" src="<?php echo 'assets/profile_pictures/' . $notification['source_user_id'] . '.jpg' ?>" />
                        <div class="m-0 text-link d-inline"><?php echo $notification["source_user_name"];?><span class="m-0 text-black fw-normal"> <?php echo $notification["template_text"];?></span></div>
                        <span class="m-0 text-black fw-normal ms-3 ms-md-4 me-2"><?php echo formatTimestampDiff($notification["timestamp"], time()); ?></span>
                    </a>
                </div>
                <?php } ?>
                <button id="clearNotificationsButton" class="btn btn-bounce rounded-pill bg-accent fw-bold text-white mt-2" aria-label="Pulsante per segnare tutte le notifiche come lette" tabindex="3">Mark all as read</button>
            </div>
        <?php } else { ?>
        <p class="fs-6" tabindex="3">You don't have any new notifications.</p>
        <?php } ?>
    </div>
</div>

<script>
    $("#clearNotificationsButton").on("click", function () {
        $.post('api/notifications.php', {
            "api_key" : '<?php echo $_SESSION["api_key"] ?>',
            "action" : "delete"
        }, function (data, status) {
            window.location.reload();
        });
    });

    document.onkeypress = function(e) {
        if (e.keyCode == 13) {
            document.activeElement.querySelector("a").click();
        }
    }

    notifications = <?php echo json_encode($notifications) ?>;
    notifications.forEach(notification => {
        $("#notification" + notification["notification_id"]).on("click", function () {
            $.post('api/notifications.php', {
                "api_key" : '<?php echo $_SESSION["api_key"] ?>',
                "id" : notification["notification_id"],
                "action" : "delete"
            }, function(data, status) {
                if (notification["notification_type_name"] == "comment") {
                    window.location = "home.php?gnam=" + encodeURIComponent(notification["gnam_id"]);
                } else {
                    window.location = "profile.php?user=" + encodeURIComponent(notification["source_user_id"]);
                }
            });
        });
    });
</script>
