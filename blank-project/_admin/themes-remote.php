<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

$do = suSegment(1);
$newTheme = suSegment(2);
//Update record
if ($do == "change") {
//Check referrer
    suCheckRef();
//Validate

    $sql = "UPDATE sulata_users SET user__Theme='" . $newTheme . "' WHERE user__ID='" . $_SESSION[SESSION_PREFIX . 'user__ID'] . "'";
    suQuery($sql);
    //Set theme in session
    $_SESSION[SESSION_PREFIX . 'user__Theme'] = $newTheme;
    //Set theme in cookie
    setcookie('ck_theme', $_SESSION[SESSION_PREFIX . 'user__Theme'], time() + (COOKIE_EXPIRY_DAYS * 86400), '/');

    suPrintJs('
            parent.document.getElementById("themeCss").setAttribute("href", "' . ADMIN_URL . 'css/themes/' . $newTheme . '/style.css");
        ');
}
?>    
