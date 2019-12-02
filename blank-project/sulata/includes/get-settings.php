<?php

/*
 * Get setting in array from settings table
 */
//Start session
session_start();


//if ($_SESSION[SESSION_PREFIX . 'getSettings'] == '') {

    $sql = "SELECT setting__Key, setting__Value FROM sulata_settings WHERE setting__dbState='Live' ORDER by setting__Key";
    $result = suQuery($sql);
    if ($result['connect_errno'] == 0 && $result['errno'] == 0) {
        foreach ($result['result'] as $row) {
            $_SESSION[SESSION_PREFIX . 'getSettings'][suUnstrip($row['setting__Key'])] = suUnstrip($row['setting__Value']);
        }
    } else {
        suExit(GENERIC_ERROR);
    }
//}
//Pass array the getSettings session value;
$getSettings = array();
$getSettings = $_SESSION[SESSION_PREFIX . 'getSettings'];

//Site settings
define('DATE_FORMAT', $getSettings['date_format']); //mm-dd-yy or dd-mm-yy
if (DATE_FORMAT == 'mm-dd-yy') {
    $today = date("m-d-Y");
} else {
    $today = date("d-m-Y");
}
//Include the language file
include('language.php');
//Pagination size
define('PAGE_SIZE', $getSettings['page_size']);
//Set time zone
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set($getSettings['timezone']);
}
//Default image resize dimension
$defaultWidth = '640';
$defaultHeight = '480';

//Default database ids not to be deleted
$pageId = 1; //CMS page id

