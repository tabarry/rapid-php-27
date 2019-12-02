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
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                
                                \$sql = \"SELECT " . $fieldId . " AS f1, " . $fieldText . " AS f2 FROM " . $table . " where ".$fieldPrefix1."__dbState='Live' ORDER BY f2\";
                                echo suSearchableDropdown('" . $_POST['frmField'][$i] . "', \$sql, ".$thisVal.", ''); 
                                ?>
                                <script>
                                    $(function() {
                                        $('#".$_POST['frmField'][$i]."').chosen();
                                    });
                                </script>
</div>
";
?>