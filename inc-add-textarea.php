<?php

$thisVal = "''";
if ($doUpdate == TRUE) {
    $thisVal = " suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
}
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">                
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "',\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'],'class'=>'form-control');
                                echo suInput('textarea', \$arg," . $thisVal . ",TRUE);
                                ?>
</div>
";
?>