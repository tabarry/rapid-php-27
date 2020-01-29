<?php

/*
 * SULATA FRAMEWORK
 * Version: #VERSION#, November 2019
 * Project Creation Date: #DATE#
 */
//Error reporting
error_reporting("E_ALL & ~E_NOTICE & ~E_DEPRECATED");
//ini_set('display_errors',1);
//MISC SETTINGS
define('LOCAL_URL', 'http://localhost/#SITE_FOLDER#/');
define('WEB_URL', 'http://localhost/#SITE_FOLDER#/');
define('SESSION_PREFIX', 'x#SESSION_PREFIX#');
define('UID_LENGTH', 14);
define('COOKIE_EXPIRY_DAYS', '30');
define('DEFAULT_USER_NAME', '#DEFAULT_USER_NAME#@sulata.com.pk'); //This is admin default user
define('DEFAULT_USER_PASSWORD', '#DEFAULT_USER_PASSWORD#'); //This is password for default user
//URLs and db settings
//Other settings are in sulata_settings table
//If local
if (!strstr($_SERVER['HTTP_HOST'], ".")) {
    if (!isset($_GET['debug'])) { //Debug mode can be toggled from querystring as ?debug=0 or ?debug=1
        define('DEBUG', TRUE);
    } else {
        define('DEBUG', $_GET['debug']);
    }
    define('PHP_EXTENSION', '.php'); //This will add or remove '.php' in file links
    define('BASE_URL', LOCAL_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'static/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', TRUE);
    //API Settings
    define('API_URL', BASE_URL . 'phpMyRest/');
    define('API_KEY', '#API_KEY#');
    define('API_DEBUG', FALSE);
    //MySQL DB Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', '#DB_NAME#');
    define('DB_USER', '#DB_USER#');
    define('DB_PASSWORD', '#DB_PASSWORD#');
} else {
    if (!isset($_GET['debug'])) { //Debug mode can be toggled from querystring as ?debug=0 or ?debug=1
        define('DEBUG', FALSE);
    } else {
        define('DEBUG', $_GET['debug']);
    }
    define('PHP_EXTENSION', '.php'); //This will add or remove '.php' in file links
    define('BASE_URL', WEB_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'sulata/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', FALSE);
    //API Settings
    define('API_URL', BASE_URL . 'phpMyRest/');
    define('API_KEY', '#API_KEY#');
    define('API_DEBUG', FALSE);
    //MySQL Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', '#DB_NAME#');
    define('DB_USER', '#DB_USER#');
    define('DB_PASSWORD', '#DB_PASSWORD#');
}
//Display errors
if (DEBUG == TRUE) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}
//Default access variables
$GLOBALS['editAccess'] = TRUE;
$GLOBALS['inlineEditAccess'] = TRUE;
$GLOBALS['previewAccess'] = TRUE;
$GLOBALS['duplicateAccess'] = TRUE;
$GLOBALS['deleteAccess'] = TRUE;
$GLOBALS['restoreAccess'] = TRUE;
$GLOBALS['addAccess'] = TRUE;
$GLOBALS['downloadAccessCSV'] = TRUE;
$GLOBALS['downloadAccessPDF'] = TRUE;
$GLOBALS['searchAccess'] = TRUE;
$GLOBALS['sortable'] = TRUE;
//======
$module_prefix = '_____a_____';
$module_postfix = '_____z_____';
$previous_password_prefix = '_____previous_password_____';
//======
//Exclude pages from permissions check
$permissionsExclude = array(
    'index.php',
    'modules.php',
    'notes.php',
    'themes.php',
    'themes-remote.php',
    'users-change-password.php',
);
//Exclude pages from the sidebar and modules
$sidebarExclude = array(
    '.',
    '..',
    'index.html',
    'index.php',
    'login.php',
    'reload.php',
    /*'settings.php',*/
    'template.php',
    'logout.php',
    'message.php',
    'lost-password.php',
    'users-change-password.php',
    'notes.php',
    'themes.php',
    'modules.php',
    'css',
    'scss',
    'fonts',
    'img',
    'js',
    'less'
);
