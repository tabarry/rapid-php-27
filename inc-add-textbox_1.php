<?php

if ($doUpdate == TRUE) {
    $updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
} else {
    $thisVal = "'" . $_POST['frmDefaultvalue'][$i] . "'";
    $updateValue = " , 'value'=>'".$_POST['frmDefaultvalue'][$i]."'";
}
if ($_POST['frmField'][$i] == $uniqueField) {
    $doMaxLength = "\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max']";
} else {
    $doMaxLength = "\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max']";
}
$addCode .="
<div class=\"form-group\">
<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">                
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'] " . $updateValue . ", 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "', 'autocomplete' => 'off', 'maxlength' =>  $doMaxLength " . $updateValue . ",\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'],'class'=>'form-control');
                                echo suInput('input', \$arg);
                                ?>
</div>
</div>
";
?>
