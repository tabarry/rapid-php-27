<?php

$thisVal = "''";
if ($doUpdate == TRUE) {
    $thisVal = " urldecode(\$row['" . $_POST['frmField'][$i] . "'])";
}
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">
                                                <!-- //MEDIA MANAGER -->
                                                <div class=\"pull-right\">
                                                    <a title=\"Media..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/?overlay=yes&iframe=true&width=80%&height=100%\"><i class=\"fa fa-images\"></i></a>
                                                </div>
                                                <!-- MEDIA MANAGER// -->    
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "');
                                echo suInput('textarea', \$arg," . $thisVal . ",TRUE);
                                 suCKEditor('" . $_POST['frmField'][$i] . "');
                                ?>
</div>
";
?>