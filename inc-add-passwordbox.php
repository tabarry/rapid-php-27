<?php

if ($doUpdate == TRUE) {
    //$updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
    $updateValue = "";
    $class_password = 'su-hide';
    $toggle_div = "<div class=\"container su-hide\" id=\"" . $_POST['frmField'][$i] . "-note\"><?php echo suInfo(CHANGE_PASSWORD_MESSAGE);?></div>
                                                <p id=\"" . $_POST['frmField'][$i] . "-change-password\" class=\"container\"><a href=\"javascript:;\" onclick=\"doChangePassword('" . $_POST['frmField'][$i] . "')\" class=\"underline\"><i class=\"fa fa-key\"></i> <?php echo CHANGE_PASSWORD;?></a></p>";
    $pass_req = "\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req']='';";
    $pass_req_star = "\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']='';";

    $previous_password = "//Hidden previous password field\n\$arg = array('type' => 'hidden', 'name' => \$previous_password_prefix.'" . $_POST['frmField'][$i] . "','id' => \$previous_password_prefix.'" . $_POST['frmField'][$i] . "','value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "']));
                                echo suInput('input', \$arg);";
    $pfld = '';

    $password_condition = "
    //Make Password
    if (\$_POST['" . $_POST['frmField'][$i] . "'] == '') {
           \$x_" . $_POST['frmField'][$i] . " = \$_POST[\$previous_password_prefix.'" . $_POST['frmField'][$i] . "'];
    }else{
        \$x_" . $_POST['frmField'][$i] . " = crypt(\$_POST['" . $_POST['frmField'][$i] . "'],uniqid());
    }
";
    $resetUploadValidation .= "
    \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']='';
    
";
    $password_condition2 = '';
} else {
    $password_condition = '';
    $password_condition2 = "
    //Make Password
    \$x_" . $_POST['frmField'][$i] . " = crypt(\$_POST['" . $_POST['frmField'][$i] . "'],uniqid());
";
    $previous_password = '';
    $class_password = '';
    $toggle_div = '';
    $pass_req = '';
    $pass_req_star = '';
}
$addCode .= "
<!-- PASSWORD FIELDS -->   
<div>
<?php
{$pass_req}
{$pass_req_star}
?>
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . " " . $class_password . "\" id=\"" . $_POST['frmField'][$i] . "-1\">            
<label>
<?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:
    <?php if (\$getSettings['show_password'] == 'Yes') { ?>
    <a href=\"javascript:;\" onclick=\"doShowPassword();\"><i class=\"fa fa-eye\"></i></a>
    <?php } ?>
    </label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "', 'maxlength' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max'] " . $updateValue . " ,\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'],'class'=>'form-control');
                                echo suInput('input', \$arg);
                                
                                {$previous_password}

                                ?>
</div>
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . " " . $class_password . "\" id=\"" . $_POST['frmField'][$i] . "-2\">                                     
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo CONFIRM;?> <?php echo  \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "2', 'id' => '" . $_POST['frmField'][$i] . "2', 'maxlength' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max'] " . $updateValue . ",\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'],'class'=>'form-control');
                                echo suInput('input', \$arg);
                                ?>
</div>
{$toggle_div}
</div>
<!-- // -->
";
?>
