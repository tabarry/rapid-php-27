<?php


$thisVal = "''";
if ($doUpdate == TRUE) {
    $thisVal = " suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";
}
//Get dropdown text
$tableFieldText = explode(".", $_POST['frmForeignkeytext'][$i]);
$table = $tableFieldText[0];
$fieldText = $tableFieldText[1];
//Get dropdown value
$tableFieldId = explode(".", $_POST['frmForeignkeyvalue'][$i]);
$table = $tableFieldId[0];
$fieldId = $tableFieldId[1];
//add page name
$addpage = explode('_', $table);
$addpage = $addpage[1];
//Get felf prefix
$fieldPrefix1 = explode('__', $tableFieldText[1]);
$fieldPrefix1 = $fieldPrefix1[0];


$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">        
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:
<?php if (\$addAccess == 'true') { ?>    
<a title=\"Add new record..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>" . $addpage . "-add<?php echo PHP_EXTENSION;?>/?overlay=yes&iframe=true&width=80%&height=100%\"><i class=\"fa fa-plus\"></i></a>

<a onclick=\"suReload3('radioLinkArea_" . $_POST['frmField'][$i] . "','<?php echo ADMIN_URL; ?>','<?php echo suCrypt('" . $table . "',TRUE);?>','<?php echo suCrypt('" . $fieldId . "',TRUE);?>','<?php echo suCrypt('" . $fieldText . "',TRUE);?>');\" href=\"javascript:;\"><i class=\"fa fa-undo\"></i></a>    
<?php } ?>    
</label>
                                <div id=\"radioLinkArea_" . $_POST['frmField'][$i] . "\">

                                <?php
                                
                                \$sql = \"SELECT " . $fieldId . " AS f1, " . $fieldText . " AS f2 FROM " . $table . " where ".$fieldPrefix1."__dbState='Live' ORDER BY f2\";
                                echo suMakeRadio(\$sql, '" . $_POST['frmField'][$i] . "',\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req'], " . $thisVal . ");
                                ?>
</div>
</div>
";
?>