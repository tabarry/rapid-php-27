<!-- Title here -->
<title><?php echo $getSettings['site_name'] . ' | ' . $getSettings['site_tagline']; ?></title>
<noscript>
<meta http-equiv="refresh" content="0;url=<?php echo NOSCRIPT_URL; ?>"/>
</noscript>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Styles -->
<!-- Bootstrap CSS -->
<link href="<?php echo ADMIN_URL; ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Custom Color CSS -->
<link href="<?php echo ADMIN_URL; ?>css/less-style.css" rel="stylesheet">	
<!-- Custom CSS -->
<link href="<?php echo ADMIN_URL; ?>css/style.css" rel="stylesheet">
<link href="<?php echo ADMIN_URL; ?>css/this-site.css" rel="stylesheet">
<!-- Theme CSS -->
<?php
if ($_SESSION[SESSION_PREFIX . 'user__Theme'] == '') {
    $_SESSION[SESSION_PREFIX . 'user__Theme'] = 'default';
}
?>
<link id="themeCss" href="<?php echo ADMIN_URL; ?>css/themes/<?php echo $_SESSION[SESSION_PREFIX . 'user__Theme']; ?>/style.css" rel="stylesheet">
<!-- Chosen CSS -->
<link href="<?php echo BASE_URL; ?>sulata/chosen/bootstrap-chosen.css" rel="stylesheet" type="text/css"/>
<!-- JQUI -->
<link href="<?php echo BASE_URL; ?>sulata/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>sulata/font-awesome/css/all.min.css" type="text/css" media="screen" />
<!-- Sulata CSS -->
<link href="<?php echo BASE_URL; ?>sulata/css/style.css" rel="stylesheet">
<!-- CK Editor -->
<script src="<?php echo BASE_URL; ?>sulata/ckeditor/ckeditor.js"></script>
<!-- Pretty Photo -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>sulata/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<!-- jQuery -->
<script src="<?php echo BASE_URL; ?>sulata/jquery-ui/js/jquery-1.8.3.js" type="text/javascript"></script>
<!-- Chosen JQuery -->
<script src="<?php echo BASE_URL; ?>sulata/chosen/chosen.jquery.js" type="text/javascript"></script>
<!-- Other JS files go in the footer -->
