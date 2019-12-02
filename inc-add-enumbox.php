<?php

$thisVal = "''";
if ($doUpdate == TRUE) {
    $thisVal = " suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
} else {
    $thisVal = "'" . $_POST['frmDefaultvalue'][$i] . "'";
}
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">        
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$options = \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_array'];
                                    \$js = \"class='form-control'\";
                                echo suDropdown('" . $_POST['frmField'][$i] . "', \$options, " . $thisVal . ",\$js)
                                ?>
</div>
";
?>