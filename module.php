<?php
require_once "php/config/config.php";

if (!$Login->IsUserLoggedInAndChangedPassword()) {
    header("Location: start");
    return;
}

if (!filter_has_var(INPUT_GET, "type")) {
    header("Location: error-module-does-not-exists");
    return;
}

$moduleTypeString = filter_input(INPUT_GET, "type");

if ($moduleTypeString == "panel-glowny") {
    $moduleType = Modules::PanelGlowny;
} else if ($moduleTypeString == "pojazdy") {
    $moduleType = Modules::Pojazdy;
} else if ($moduleTypeString == "flota") {
    $moduleType = Modules::Flota;
} else if ($moduleTypeString == "mtg") {
    $moduleType = Modules::MTG;
} else if ($moduleTypeString == "ksiazka-kucharska") {
    $moduleType = Modules::KsiazkaKucharska;
} else if ($moduleTypeString == "test") {
    $moduleType = Modules::Test;
} else if ($moduleTypeString == "krypto") {
    $moduleType = Modules::Krypto;
} else {
    header("Location: error-module-does-not-exists");
    return;
}

if (!$Permissions->CheckFunctionPermissions($moduleType . "001")) {
    header("Location: error-module-view-permission");
    return;
}
?>
﻿<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>Bolid - <?php
            echo strtoupper($moduleTypeString[0]) . str_replace("-", " ", substr($moduleTypeString, 1));
            ?></title>

        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <?php
        require_once PROJECT_ROOT . "views/_includes_css.php";

        $cssFilesList = array_diff(scandir(PROJECT_ROOT . "modules/" . $moduleTypeString . "/css/"), array('..', '.'));

        foreach ($cssFilesList as $cssFile) {
            ?>
            <link href="./modules/<?php echo $moduleTypeString; ?>/css/<?php echo $cssFile; ?>" rel="stylesheet">
            <?php
        }
        ?>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed text-sm">
        <div id="loading">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            <div class="lds-caption"></div>
        </div>
        <div class="wrapper">
            <?php
            require_once PROJECT_ROOT . "views/_navbar_top.php";
            require_once PROJECT_ROOT . "views/_navbar_left.php";
            ?>

            <div class="content-wrapper">
                <?php
                if ($Permissions->CheckIfModuleIsEnabled($moduleType)) {
                    require_once PROJECT_ROOT . "modules/" . $moduleTypeString . "/views/_content.php";
                } else {
                    require_once PROJECT_ROOT . "views/_content_module_off.php";
                }
                ?>
                <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Przewiń do góry">
                    <i class="fas fa-chevron-up"></i>
                </a>

            </div>
            <?php
            require_once PROJECT_ROOT . "views/_includes_js.php";

            $jsFilesList = array_diff(scandir(PROJECT_ROOT . "modules/" . $moduleTypeString . "/js/"), array('..', '.'));

            foreach ($jsFilesList as $jsFile) {
                $jsFileNameExploded = explode(".", $jsFile);
                if ($jsFileNameExploded[count($jsFileNameExploded) - 1] == "php") {
                    $jsFileNameParts = explode("-", $jsFileNameExploded[count($jsFileNameExploded) - 2]);

                    if ($jsFileNameParts[count($jsFileNameParts) - 1] != "last") {
                        require_once PROJECT_ROOT . "modules/$moduleTypeString/js/$jsFile";
                    }
                }
            }

            foreach ($jsFilesList as $jsFile) {
                $jsFileNameExploded = explode(".", $jsFile);
                if ($jsFileNameExploded[count($jsFileNameExploded) - 1] == "js") {
                    ?>
                    <script src="./modules/<?php echo $moduleTypeString; ?>/js/<?php echo $jsFile . "?" . time(); ?>" type="text/javascript"></script>
                    <?php
                }
            }

            foreach ($jsFilesList as $jsFile) {
                $jsFileNameExploded = explode(".", $jsFile);
                if ($jsFileNameExploded[count($jsFileNameExploded) - 1] == "php") {
                    $jsFileNameParts = explode("-", $jsFileNameExploded[count($jsFileNameExploded) - 2]);

                    if ($jsFileNameParts[count($jsFileNameParts) - 1] == "last") {
                        require_once PROJECT_ROOT . "modules/$moduleTypeString/js/$jsFile";
                    }
                }
            }

            $viewsFilesList = array_diff(scandir(PROJECT_ROOT . "modules/" . $moduleTypeString . "/views/"), array('..', '.'));
            foreach ($viewsFilesList as $viewFile) {
                if (substr($viewFile, 0, 7) == "_modals") {
                    require_once PROJECT_ROOT . "modules/$moduleTypeString/views/$viewFile";
                }
            }

            require_once PROJECT_ROOT . "views/_notifications.php";
            ?>
        </div>
    </body>
</html>