<?php

//Build details table checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);

    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);

    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);

    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);
    $prefix = explode('__', $f2a);
    $prefix = $prefix[0];

    //Prefix1
    $prefix1 = explode('.', $_POST['frmDetailsSourceText']);
    $prefix1 = end($prefix1);
    $prefix1 = explode('__', $prefix1);
    $prefix1 = $prefix1[0];

    //Prefix2
    $prefix2 = explode('.', $_POST['frmDetailsDestText']);
    $prefix2 = end($prefix2);
    $prefix2 = explode('__', $prefix2);
    $prefix2 = $prefix2[0];

    $newPage = explodeExtract($t1, "_", 0);
    $newPage = str_replace('_', '-', $newPage);


    //Add sections        
    $addCheckBox = " 
                               
<p class=\"clearfix\">&nbsp;</p>                                
<?php
//Build checkboxes

\$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " WHERE " . $prefix1 . "__dbState ='Live' ORDER BY " . $f2 . "\";
\$result = suQuery(\$sql);

?>
<table width=\"100%\" class=\"table table-hover table-bordered tbl\">
                                                <thead>
                                                    <tr>
                                                        <th width=\"90%\">".strtoupper(str_replace('-', ' ', explodeExtract($t1, "_", 0)))."</th>
                                                        <th width=\"10%\" class=\"right\">
                                                            &nbsp;
                                                            <?php if (\$addAccess == 'true') { ?>    
    <a title=\"Add new record..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>" . $newPage . "-add<?php echo PHP_EXTENSION;?>/?overlay=yes&iframe=true&width=100%&height=100%\"><i class=\"fa fa-plus\"></i></a>

    <a onclick=\"suReload2('checkboxLinkArea','<?php echo ADMIN_URL; ?>','<?php echo suCrypt('" . $t1 . "'); ?>','<?php echo suCrypt('" . $f1 . "'); ?>','<?php echo suCrypt('" . $f2 . "'); ?>','<?php echo suCrypt('" . $t1a . "'); ?>','<?php echo suCrypt('" . $f1a . "'); ?>','<?php echo suCrypt('" . $f2a . "'); ?>','<?php echo suCrypt(\$id); ?>');\" href=\"javascript:;\"><i class=\"fa fa-undo\"></i></a>    
<?php } ?> 
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <td colspan=\"2\">
                                                    <div id=\"checkboxLinkArea\">
<?php
foreach (\$result['result'] as \$row) {
\$chkUid = \$row['" . $f1 . "'];
    ?>
    <label class=\"btn btn-default\"><input type=\"checkbox\" name=\"" . $f2 . "[]\" value=\"<?php echo \$chkUid; ?>\" <?php echo \$checked; ?>/> <?php echo suUnstrip(\$row['" . $f2 . "']); ?></label>

    <?php
}
?>
</div>
</td>
                                                </tbody>
                                            </table>
";
//Update code
    $updateCheckBox = " 
                               
<p class=\"clearfix\">&nbsp;</p>                                
<?php
//Get entered data
\$chkArr=array();
\$sql = \"SELECT " . $f1a . " FROM " . $t1a . " WHERE " . $prefix2 . "__dbState ='Live' AND " . $f2a . "='\" . \$id . \"'\";
\$result = suQuery(\$sql);
foreach (\$result['result'] as \$row) {
    array_push(\$chkArr, \$row['" . $f1a . "']);
}
\$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " WHERE " . $prefix1 . "__dbState ='Live' ORDER BY " . $f2 . "\";
\$result = suQuery(\$sql);
?>
<table width=\"100%\" class=\"table table-hover table-bordered tbl\">
                                                <thead>
                                                    <tr>
                                                        <th width=\"90%\">".strtoupper(str_replace('-', ' ', explodeExtract($t1, "_", 0)))."</th>
                                                        <th width=\"10%\" class=\"right\">
                                                            &nbsp;
                                                            <?php if (\$addAccess == 'true') { ?>    
    <a title=\"Add new record..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>" . $newPage . "-add<?php echo PHP_EXTENSION;?>/?overlay=yes&iframe=true&width=100%&height=100%\"><i class=\"fa fa-plus\"></i></a>

    <a onclick=\"suReload2('checkboxLinkArea','<?php echo ADMIN_URL; ?>','<?php echo suCrypt('" . $t1 . "'); ?>','<?php echo suCrypt('" . $f1 . "'); ?>','<?php echo suCrypt('" . $f2 . "'); ?>','<?php echo suCrypt('" . $t1a . "'); ?>','<?php echo suCrypt('" . $f1a . "'); ?>','<?php echo suCrypt('" . $f2a . "'); ?>','<?php echo suCrypt(\$id); ?>');\" href=\"javascript:;\"><i class=\"fa fa-undo\"></i></a>    
<?php } ?> 
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <td colspan=\"2\">
                                                    <div id=\"checkboxLinkArea\">
    <?php
foreach (\$result['result'] as \$row) {
\$chkUid = \$row['" . $f1 . "'];
if (in_array(\$row['" . $f1 . "'], \$chkArr)) {
                                                        \$checked = \"checked='checked'\";
                                                    } else {
                                                        \$checked = '';
                                                    }
        ?>
<label class=\"btn btn-default\"><input type=\"checkbox\" name=\"" . $f2 . "[]\" value=\"<?php echo \$chkUid; ?>\" <?php echo \$checked; ?>/> <?php echo suUnstrip(\$row['" . $f2 . "']); ?></label>     

    <?php
}
?>

</div>
</td>
                                                </tbody>
                                            </table>

";
//Validate remote
    $validateAddRemote = "
//Check if at least one checkbox is selected
if (sizeof(\$_POST['" . $f2 . "'])==0) {
    \$vError[]=VALIDATE_EMPTY_CHECKBOX;
}  
";

//Delete remote
    $deleteCheckBoxRemote = "
//Delete from child checkboxes table
\$sql = \"UPDATE " . $t1a . " SET " . $prefix . "__Last_Action_On='\".date('Y-m-d H:i:s').\"', " . $prefix . "__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\" WHERE " . $f2a . "='\".\$_POST[\"" . $_POST['primary'] . "\"].\"'\";
suQuery(\$sql);
";


    //Add remote
    $addCheckBoxRemote = "
//Add details data
        for (\$i = 0; \$i <= sizeof(\$_POST['" . $f2 . "'])-1; \$i++) {
            \$sql = \"INSERT INTO " . $t1a . " SET " . $f2a . "='\".\$max_id.\"', $f1a='\".\$_POST['" . $f2 . "'][\$i].\"', " . $prefix . "__Last_Action_On='\".date('Y-m-d H:i:s').\"', " . $prefix . "__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\"'\";
            suQuery(\$sql);
        }
        
";
    //update remote
    $updateCheckBoxRemote = "
//update details data
        //Delete privious data
        \$sql = \"DELETE FROM " . $t1a . " WHERE " . $f2a . "='\".\$max_id.\"'\";
        suQuery(\$sql);
       
        for (\$i = 0; \$i <= sizeof(\$_POST['" . $f2 . "'])-1; \$i++) {
            \$sql = \"INSERT INTO " . $t1a . " SET " . $f2a . "='\".\$max_id.\"', $f1a='\".\$_POST['" . $f2 . "'][\$i].\"', " . $prefix . "__Last_Action_On='\".date('Y-m-d H:i:s').\"', " . $prefix . "__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\"'\";            
            suQuery(\$sql);
        }
        
";
}
?>