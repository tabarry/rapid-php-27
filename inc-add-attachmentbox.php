<?php

if ($doUpdate == TRUE) {
    $updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
}
$multipart = TRUE;
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'] , 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "','class'=>'form-control');
                                echo suInput('input', \$arg);
                                ?>
</div>
                               ";
if ($doUpdate == TRUE) {
    $addCode .="
    <?php if(file_exists(ADMIN_UPLOAD_PATH . \$row['" . $_POST['frmField'][$i] . "'])){?>
    <div class=\"container\"><a class=\"underline\" href=\"<?php echo BASE_URL.'files/'.\$row['" . $_POST['frmField'][$i] . "'] ;?>\" target=\"_blank\"><?php echo VIEW_FILE;?></a></div>
    <?php } ?>    
    ";
}
$addCode .="
<div class=\"container\"><?php echo \$getSettings['allowed_attachment_formats']; ?></div>
    
";
if ($doUpdate == TRUE) {
    $addCode .="
    <?php    
    \$arg = array('type' => 'hidden', 'name' => 'previous_" . $_POST['frmField'][$i] . "', 'id' => 'previous_" . $_POST['frmField'][$i] . "', 'value' => \$row['" . $_POST['frmField'][$i] . "'],\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req']);
    echo suInput('input', \$arg);     
    ?>  
";
}
$extraSqlx3 = "
    //for attachment
    if (\$_FILES['" . $_POST['frmField'][$i] . "']['name'] != '') {
        \$uid = uniqid();
        \$" . $_POST['frmField'][$i] . " = suSlugify(\$_FILES['" . $_POST['frmField'][$i] . "']['name'], \$uid);
        \$uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        \$extraSql.=\" ," . $_POST['frmField'][$i] . "='\".\$uploadPath . \$" . $_POST['frmField'][$i] . ".\"' \";
    }    
";
$uploadCheck.="
        // attachment
        if (\$_FILES['" . $_POST['frmField'][$i] . "']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . \$uploadPath .\$" . $_POST['frmField'][$i] . ");
            @unlink(ADMIN_UPLOAD_PATH . \$_POST['previous_" . $_POST['frmField'][$i] . "']);
            copy(\$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'], ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . ");
        }    
";
$resetUploadValidation.="
    \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']='';
    
";
?>
