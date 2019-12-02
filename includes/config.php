<?php

//Error reporting
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//ini_set('display_errors',1);
define('VERSION', '27');
$version = "Rapid PHP " . VERSION; //If this is changed, please also change config.php in sulata/includes folder
$debug = FALSE;
$sitePath = '../' . $_POST['folder'] . '/sulata/';
$appPath = '../' . $_POST['folder'] . '/';
$backupPath = '../' . $_POST['folder'] . '/backup/';
/* --COMMON SETTINGS */
date_default_timezone_set('Asia/Karachi');
define('SITE_TITLE', $version);
define('TAG_LINE', 'RAD Tool for PHP Development with Bootstrap Framework');
define('SITE_FOOTER', 'Rapid PHP is a product of <a href="http://www.sulata.com.pk" target="_blank">Sulata iSoft</a>.');
//==
$columnCount = array('1/12'=>'1','2/12'=>'3','3/12'=>'3','4/12'=>'4','5/12'=>'5','6/12'=>'6','7/12'=>'7','8/12'=>'8','9/12'=>'9','10/12'=>'10','11/12'=>'11','12/12'=>'12',);
?>
