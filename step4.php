<?php


include('includes/include.php');
set_time_limit(0);
if (!is_dir($sitePath)) {
    mkdir($sitePath)
            or die("
	       <script>
	       alert('Destination folder `$sitePath` does not exist.');
	       </script>
	       ");
    if (file_exists('files/access-denied.html')) {
        copy('files/access-denied.html', $sitePath . '/index.html');
    }
}
//Get template
$template = file_get_contents('template/template.php');
//Add section
$uploadCheck = '';
include('inc-add.php');
//Update section
$uploadCheck = '';
include('inc-update.php');
//View section
include('inc-view.php');
//Sort section
include('inc-sort.php');
//remote section
include('inc-remote.php');

echo "
<script>
top.$('#result').html(top.$('#result').html()+'" . $_POST['frmFormsetvalue'] . " formset created.<br/>');
</script>
";
?>