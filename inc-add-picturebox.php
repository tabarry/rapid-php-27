<?php

if ($doUpdate == TRUE) {
    $updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
}
$multipart = TRUE;
if ($doUpdate == TRUE) {

    $addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">  

<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
<?php
\$ext = suGetExtension(suUnstrip(\$row['" . $_POST['frmShow'][$i] . "']));
\$allowed_image_format = explode(',', \$getSettings['allowed_image_formats']);    
if (in_array(\$ext, \$allowed_image_format)) {
                                                        \$thumbnail = suMakeThumbnailName(suUnstrip(\$row['" . $_POST['frmField'][$i] . "']));

                                                        if (suCheckFileAtURL(BASE_URL . 'files/' . \$thumbnail) && suUnstrip(\$row['" . $_POST['frmField'][$i] . "']) != '') {
                                                            \$defaultImage = BASE_URL . 'files/' . \$thumbnail;
                                                            echo '<img src=\"' . \$defaultImage . '\" class=\"imgThumb\"/>';
                                                        }
                                                    }
                                                    

                              
                                ?>

                                
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "','class'=>'form-control');
                                echo suInput('input', \$arg);
                                
                                                    
                                ?>
                                
                                <?php if((file_exists(ADMIN_UPLOAD_PATH . \$row['" . $_POST['frmField'][$i] . "']))&&(\$row['" . $_POST['frmField'][$i] . "']!='')){?>
    <div class=\"container\"><a class=\"underline\" href=\"<?php echo BASE_URL.'files/'.\$row['" . $_POST['frmField'][$i] . "'] ;?>\" target=\"_blank\"><?php echo VIEW_FILE;?></a></div>
        <div class=\"container\"><?php echo \$getSettings['allowed_image_formats']; ?></div>
    <?php } ?>  
</div>
                               ";
} else {

    $addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "',\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req']);
                                echo suInput('input', \$arg);
                                ?>
                                <div class=\"container\"><?php echo \$getSettings['allowed_image_formats']; ?></div>
</div>
                               ";
}
/*
if ($doUpdate == TRUE) {
    $addCode11 .="
        
    <?php if((file_exists(ADMIN_UPLOAD_PATH . \$row['" . $_POST['frmField'][$i] . "']))&&(\$row['" . $_POST['frmField'][$i] . "']!='')){?>
    <div class=\"container\"><a class=\"underline\" href=\"<?php echo BASE_URL.'files/'.\$row['" . $_POST['frmField'][$i] . "'] ;?>\" target=\"_blank\"><?php echo VIEW_FILE;?></a></div>
        <div class=\"container\"><?php echo \$getSettings['allowed_image_formats']; ?></div>
    <?php } ?>    
    ";
}
 * /
 */
/*$addCode .="<div class=\"container\"><?php echo \$getSettings['allowed_image_formats']; ?></div>";*/
/*
if ($doUpdate == TRUE) {
    $addCode11 .="
    <?php    
    \$arg = array('type' => 'hidden', 'name' => 'previous_" . $_POST['frmField'][$i] . "', 'id' => 'previous_" . $_POST['frmField'][$i] . "', 'value' => \$row['" . $_POST['frmField'][$i] . "']);
    echo suInput('input', \$arg);     
    ?>   
";
}
 */
$extraSqlx1.="
    //for picture
    if (\$_FILES['" . $_POST['frmField'][$i] . "']['name'] != '') {
        \$uid = uniqid();
        \$" . $_POST['frmField'][$i] . " = suSlugify(\$_FILES['" . $_POST['frmField'][$i] . "']['name'], \$uid);
        \$uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        \$extraSql.=\" ," . $_POST['frmField'][$i] . "='\".\$uploadPath . \$" . $_POST['frmField'][$i] . ".\"' \";
    }    
";
if ($_POST['frmResize'][$i] == 'Y') {
    $uploadCheck.="
            // picture
            if (\$_FILES['" . $_POST['frmField'][$i] . "']['name'] != '') {
                @unlink(ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . ");
                if(\$_POST['duplicate']!=1){
                    @unlink(ADMIN_UPLOAD_PATH . \$_POST['previous_" . $_POST['frmField'][$i] . "']);
                }
                //Thumbnails
                \$" . $_POST['frmField'][$i] . "_thumbnail = 'th-' . \$" . $_POST['frmField'][$i] . ";
                @unlink(ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . "_thumbnail);
                \$previous_thumbnail = suMakeThumbnailName(\$_POST['previous_" . $_POST['frmField'][$i] . "']);
                if(\$_POST['duplicate']!=1){    
                    @unlink(ADMIN_UPLOAD_PATH . \$previous_thumbnail);
                }
                //==
                //Image
                suResize(\$defaultWidth, \$defaultHeight, \$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'], ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . ");
                //Thumbnail
                \$defaultWidth = \$getSettings['thumbnail_width'];
                \$defaultHeight = \$getSettings['thumbnail_height'];                
                suResize(\$defaultWidth, \$defaultHeight, \$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'], ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . "_thumbnail);    
            }    
    ";
} else {
    $uploadCheck.="
            // picture
            if (\$_FILES['" . $_POST['frmField'][$i] . "']['name'] != '') {
                @unlink(ADMIN_UPLOAD_PATH . \$uploadPath . \$" . $_POST['frmField'][$i] . ");
                copy(\$_FILES['" . $_POST['frmField'][$i] . "']['tmp_name'], ADMIN_UPLOAD_PATH . \$uploadPath .\$" . $_POST['frmField'][$i] . ");
            }    
    ";
}
$resetUploadValidation.="
    \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']='';
    
";
?>
