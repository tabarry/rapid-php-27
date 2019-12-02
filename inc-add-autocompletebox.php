<?php

$autoCompleteCount = $autoCompleteCount + 1;
$thisVal = "''";

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


if ($doUpdate == TRUE) {
    $updateValue = " , 'value'=>suUnstrip(\$row['" . $_POST['frmField'][$i] . "'])";

    $updateFieldValue = "
        
        //Get the field value
        \$sqlVal = \"SELECT " . $fieldText . "  FROM " . $table . " WHERE " . $fieldPrefix1 . "__dbState='Live' AND  " . $fieldPrefix1 . "__ID = '\" . \$row['" . $_POST['frmField'][$i] . "'] . \"' \";
        \$resultVal = suQuery(\$sqlVal);
        \$rowVal = \$resultVal['result'][0];
        \$row['" . $_POST['frmField'][$i] . "'] = \$rowVal['" . $fieldText . "'];
        ";
} else {
    $autoCompleteFrameBuster .= ' && ($_GET["do"] != "autocomplete' . $autoCompleteCount . '") ';
    $updateFieldValue = "";
}
if ($_POST['frmField'][$i] == $uniqueField) {
    $doMaxLength = "\$dbs_" . $table . "['" . $fieldText . "_max']";
} else {
    $doMaxLength = "\$dbs_" . $table . "['" . $fieldText . "_max']";
}
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">                
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                
                                " . $updateFieldValue . "
                                                    
                                \$arg = array('type' => \$dbs_" . $table . "['" . $fieldText . "_html5_type'] " . $updateValue . ", 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "', 'autocomplete' => 'off', 'maxlength' =>  $doMaxLength "  . ",\$dbs_" . $table . "['" . $fieldText . "_html5_req'] => \$dbs_" . $table . "['" . $fieldText . "_html5_req'],'class'=>'form-control');
                                echo suInput('input', \$arg);
                                ?>
<script>
    //Autocomplete code
    jQuery(document).ready(function() {
        $('#" . $_POST['frmField'][$i] . "').autocomplete(
                {source: '<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-remote.php?do=autocomplete" . $autoCompleteCount . "', minLength: 2}
        );
    });
</script>
</div>

";
$remoteCodeAutoInsert .= "
            \$selectSql = \"SELECT " . $fieldId . "  FROM " . $table . " WHERE " . $fieldPrefix1 . "__dbState='Live' AND  " . $fieldText . " = '\" . suUnstrip(\$_POST['" . $_POST['frmField'][$i] . "']) . \"' \";
                    
            \$insertSql = \"INSERT INTO  " . $table . " SET " . $fieldText . "='\".suUnstrip(\$_POST['" . $_POST['frmField'][$i] . "']).\"'," . $fieldPrefix1 . "__Last_Action_On='\".date('Y-m-d H:i:s').\"'," . $fieldPrefix1 . "__Last_Action_By='suDoInsert()'," . $fieldPrefix1 . "__dbState='Live' \";
                
             \$_POST['" . $_POST['frmField'][$i] . "']=suDoInsert(\$insertSql, \$selectSql, '" . $fieldPrefix1 . "__ID');
        "
;
$remoteCodeAutoComplete .= "
//if autocomplete
if (\$_GET['do'] == 'autocomplete" . $autoCompleteCount . "') {

 \$sql = \"SELECT " . $fieldId . " AS f1, " . $fieldText . " AS f2 FROM " . $table . " WHERE " . $fieldPrefix1 . "__dbState='Live' AND  " . $fieldText . " LIKE '%\" . suUnstrip(\$_REQUEST['term']) . \"%' ORDER BY f2\";
     

    

    \$result = suQuery(\$sql);

    \$data = array();
    if (\$result && \$result['num_rows']) {
        foreach (\$result['result'] as \$row) {
            \$data[] = array(
                'label' => \$row['f2'],
                'value' => \$row['f2']
            );
        }
    }

    echo json_encode(\$data);
    flush();
}
";
?>
