<?php include('includes/include.php'); ?>
<?php

//print_array($_POST);

@mkdir('../' . $_POST['directory']);
//Copy folder
//function recurse_copy($src,$dst,$directory,$db,$db_user,$db_password)
recurse_copy('./blank-project', '../' . $_POST['directory'], $_POST['directory'], $_POST['db'], $_POST['db_user'], $_POST['db_password']);
//Set cookie
setcookie('ck_db_user', $_POST['db_user'], time() + 14400000);
setcookie('ck_db_password', $_POST['db_password'], time() + 14400000);
//Create database
$sql = "DROP DATABASE IF EXISTS " . $_POST['db'];
mysqli_query($cn, $sql) or die(mysqli_error($cn));
$sql = "CREATE DATABASE " . $_POST['db'];
mysqli_query($cn, $sql) or die(mysqli_error($cn));
$sql = "USE " . $_POST['db'];
mysqli_query($cn, $sql) or die(mysqli_error($cn));
$sql = file_get_contents('./blank-project/db/db.sql');
$sql = explode(';', $sql);
for ($i = 0; $i <= sizeof($sql); $i++) {
    //echo $sql[$i].'<br>'.'<br>';
    if ($sql[$i]) {
        mysqli_query($cn, $sql[$i]) or die(mysqli_error($cn));
    }
}
//Update default_user_password
$user_email = $_POST['directory'] . "@sulata.com.pk";
$user_password = $_POST['default_user_password'];
$sql2 = "UPDATE sulata_users SET user__Email='" . $_POST['directory'] . "@sulata.com.pk',user__Password='" . crypt($user_password, $user_email) . "' WHERE user__ID='1'";
mysqli_query($cn, $sql2) or die(mysqli_error($cn));
//Update project name
$sql2 = "UPDATE sulata_settings SET setting__Value='" . ucwords($_POST['directory']) . "' WHERE setting__ID='1'";
mysqli_query($cn, $sql2) or die(mysqli_error($cn));

//Drop unwanted tables and files
if ($_POST['sulata_faqs'] == 'drop') {
    $sql = "DROP TABLE IF EXISTS sulata_faqs";
    mysqli_query($cn, $sql) or die(mysqli_error($cn));
    unlink('../' . $_POST['directory'] . '/_admin/faqs.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-sort.php');
}
if ($_POST['sulata_media'] == 'drop') {
    $sql = "DROP TABLE IF EXISTS sulata_media";
    mysqli_query($cn, $sql) or die(mysqli_error($cn));
    unlink('../' . $_POST['directory'] . '/_admin/media.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-sort.php');
}

if ($_POST['sulata_pages'] == 'drop') {
    $sql = "DROP TABLE IF EXISTS sulata_pages";
    mysqli_query($cn, $sql) or die(mysqli_error($cn));
    $sql = "DROP TABLE IF EXISTS sulata_headers";
    mysqli_query($cn, $sql) or die(mysqli_error($cn));
    unlink('../' . $_POST['directory'] . '/_admin/pages.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-sort.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-sort.php');
}

$response = "Project created.<br/>"
        . "Default User: " . $_POST['directory'] . "@sulata.com.pk<br/>"
        . "Password: " . $_POST['default_user_password'];
echo "
<script>
top.$('#result').html('" . $response . "');
top.$('#Submit').val('Create');
top.$('#countdown').html(''); 
top.$('#Submit').attr('disabled', false);
top.clearCounter();
top.document.getElementById('Submit').classList.add('enabled');
top.document.getElementById('Submit').classList.remove('disabled');
</script>
";
?>