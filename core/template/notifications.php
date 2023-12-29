<div class="container text-center font-text">
    <div id="headerDiv" class="row-2 py-2">
        <h1 class="fw-bold">Notifiche</h1>
    </div>
    <div id="pageContentDiv" class="row-md-8 overflow-auto align-content-center">
        <?php
            global $assetsPath;
            $notifications = getNotifications($_SESSION["api_key"]);
            if (count($notifications) > 0) { ?>
            <div class="container h-auto" id="notificationsContainer">
                <?php foreach ($notifications as $notification) { ?>
                <div class="row m-1 p-0">
                    <button id="notification<?php echo $notification['notification_id'] ?>" class="btn btn-bounce rounded-pill bg-primary p-0 notification-pill-text notification-btn">
                        <div class="container">
                            <div class="row">
                                <div class="p-1 col-2 d-flex flex-wrap align-items-center">
                                    <img class="border border-1 border-dark rounded-circle w-100 align-middle" alt="<?php echo $notification['source_user_name'] ?>" src="<?php echo 'assets/profile_pictures/' . $notification['source_user_id'] . '.jpg' ?>" />
                                </div>
                                <div class="col align-self-center fs-7">
                                    <div class="m-0 text-link d-inline"><?php echo $notification["source_user_name"];?></div><span class="m-0 text-normal-black"> <?php echo $notification["template_text"];?></span>
                                </div>
                                <div class="col-1 m-0 ps-3 pe-0 pt-2 pb-2 d-flex">
                                    <div class="vr"></div>
                                </div>
                                <div class="col-2 align-self-center">
                                    <span class="m-0 text-normal-black"><?php echo getPrettyTimeDiff($notification["timestamp"], time()); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <button id="clearNotificationsButton" class="btn btn-bounce rounded-pill bg-secondary fw-bold text-white mt-2">Segna come lette</button>
            </div>
        <?php } else { ?>
        <p class="fs-6">Non hai nuove notifiche.</p>
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

    notifications = <?php echo json_encode($notifications) ?>;
    notifications.forEach(notification => {
        $("#notification" + notification["notification_id"]).on("click", function () {
            $.post('api/notifications.php', {
                "api_key" : '<?php echo $_SESSION["api_key"] ?>',
                "id" : notification["notification_id"],
                "action" : "delete"
            }, function(data, status) {
                window.location = "home.php?q=" + notification["gnam_id"];
            });
        });
    });
</script>
