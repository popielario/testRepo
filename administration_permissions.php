<?php
require_once "php/config/config.php";

if (!$Login->IsUserLoggedInAndChangedPassword()) {
    header("Location: start");
    return;
}

if (!$Login->IsUserAdmin()) {
    header("Location: error-module-view-permission");
    return;
}

$menuType = "administracja-uprawnienia";
?>
﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Lucjan - Administracja - uprawnienia</title>

        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <?php include_once PROJECT_ROOT . "views/_includes_css.php"; ?>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed text-sm">
        <div class="wrapper">
            <?php
            require_once PROJECT_ROOT . "views/_navbar_top.php";
            require_once PROJECT_ROOT . "views/_navbar_left.php";
            ?>
            <div class="content-wrapper">
                <?php
                require_once PROJECT_ROOT . "views/_content_administration_permissions.php";
                ?>
            </div>
            <?php
            require_once PROJECT_ROOT . "views/_includes_js.php";
            ?>
            <script src="js/administration/administration-permissions.js" type="text/javascript"></script>
            <?php
            require_once PROJECT_ROOT . "views/_notifications.php";

            require_once PROJECT_ROOT . "views/modals/_modals_administration_permissions.php";
            ?>
        </div>
    </body>
</html>