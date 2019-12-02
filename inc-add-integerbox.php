<?php

if ($doUpdate == TRUE) {
    $updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
}
if ($_POST['frmType'][$i] =='Currency') {
    $currencySymbol ="<sup><?php echo \$getSettings['site_currency'];?></sup>";
}else{
     $currencySymbol="";
}
if ($_POST['primary'] != $_POST['frmField'][$i]) {
    $addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">            
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>" . $currencySymbol.":</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "', 'autocomplete' => 'off', 'maxlength' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max'] " . $updateValue . ",\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'],'class'=>'form-control');
                                echo suInput('input', \$arg);
                                ?>
</div>    
";
}
?>
