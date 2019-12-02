<?php

$autoCompleteCount = "";
$remoteCodeAutoInsert = "";
$remoteCodeAutoComplete = "";
$addReloadParent = "";
//Update section starts
$extraSqlx1 = '';
$extraSqlx2 = '';
$extraSqlx3 = '';
$addCode = '';

$password_condition2='';
$password_condition = '';
$previous_password = '';
$class_password = '';
$toggle_div = '';
$pass_req = '';
$pass_req_star = '';

$updatePath = $appPath . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '-update.php';
$doUpdate = TRUE;

for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
    $fieldsToUpdate .= $_POST['frmField'][$i] . ',';
    if ($_POST['frmType'][$i] == 'Textbox') {
        include('inc-add-textbox.php');
    }
    if ($_POST['frmType'][$i] == 'URL') {
        include('inc-add-textbox.php');
    }
    if ($_POST['frmType'][$i] == 'IP') {
        include('inc-add-textbox.php');
    }
    if ($_POST['frmType'][$i] == 'Credit Card') {
        include('inc-add-integerbox.php');
    }
    if ($_POST['frmType'][$i] == 'Password') {
        include('inc-add-passwordbox.php');
    }
    if ($_POST['frmType'][$i] == 'Email') {
        include('inc-add-textbox.php');
    }
    if ($_POST['frmType'][$i] == 'Date') {
        include('inc-add-datebox.php');
    }
    if ($_POST['frmType'][$i] == 'Integer') {
        include('inc-add-integerbox.php');
    }
    if ($_POST['frmType'][$i] == 'Double') {
        include('inc-add-integerbox.php');
    }
    if ($_POST['frmType'][$i] == 'Float') {
        include('inc-add-integerbox.php');
    }
    if ($_POST['frmType'][$i] == 'Currency') {
        include('inc-add-integerbox.php');
    }
    if ($_POST['frmType'][$i] == 'Textarea') {
        include('inc-add-textarea.php');
    }
    if ($_POST['frmType'][$i] == 'HTML Area') {
        include('inc-add-htmlarea.php');
    }
    if ($_POST['frmType'][$i] == 'Picture field') {
        include('inc-add-picturebox.php');
    }
    if ($_POST['frmType'][$i] == 'File field') {
        include('inc-add-filebox.php');
    }
    if ($_POST['frmType'][$i] == 'Attachment field') {
        include('inc-add-attachmentbox.php');
    }
    if ($_POST['frmType'][$i] == 'Enum') {
        include('inc-add-enumbox.php');
    }
    if ($_POST['frmType'][$i] == 'Dropdown from DB') {
        include('inc-add-dbdropdownbox.php');
    }
    if ($_POST['frmType'][$i] == 'Quick Pick') {
        include('inc-add-quickpick-textarea.php');
    }
    if ($_POST['frmType'][$i] == 'Autocomplete') {
        include('inc-add-autocompletebox.php');
    }
    if ($_POST['frmType'][$i] == 'Searchable Dropdown') {
        include('inc-add-searchable-dropdown.php');
    }
}
if ($multipart == TRUE) {
    $multipart = 'enctype="multipart/form-data"';
} else {
    $multipart = '';
}
//For update
$pageTitle = ucwords(str_replace('-', ' ', substr(trim($_POST['frmFormsetvalue']), 0, -1)));
$pageTitle = ucwords(str_replace('-', ' ', trim($_POST['frmFormsetvalue'])));
//

$pageTitle = "
//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    \$do = 'add';
    \$pageName = 'Duplicate " . $pageTitle . "';
    \$pageTitle = 'Duplicate " . $pageTitle . "';
    \$mode = 'edit';
} elseif (suSegment(2) == 'preview') {
    \$do = 'update';
    \$pageName = 'Preview " . $pageTitle . "';
    \$pageTitle = '<span id=\"page-title\">Preview</span> " . $pageTitle . "';
    \$mode = 'preview';
} else {
    \$do = 'update';
    \$pageName = 'Update " . $pageTitle . "';
    \$pageTitle = '<span id=\"page-title\">Update</span> " . $pageTitle . "';
    \$mode = 'edit';    
}
";
/////////////////////////
$fieldPrefix = explode('__', $_POST['frmField'][0]);
$fieldPrefix = $fieldPrefix[0];

$fieldsToUpdate = substr($fieldsToUpdate, 0, -1);
$updateSql = "
\$id = suSegment(1);
if(!is_numeric(\$id)){
	suExit(INVALID_RECORD);
}
\$sql = \"SELECT " . $fieldsToUpdate . " FROM " . $_POST['table'] . " WHERE " . $fieldPrefix . "__dbState='Live' AND " . $_POST['primary'] . "='\" . \$id . \"'\";
\$result = suQuery(\$sql);
\$row = \$result['result'][0];
if (\$result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}
  
";
$updateCodeStart = '
        <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>' . $_POST['frmFormsetvalue'] . '-remote<?php echo PHP_EXTENSION;?>/<?php echo $do ; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" ' . $multipart . '>
            <div class="gallery clearfix">
                <div class="form-group">';

$updateCodeEnd = "
                </div>
        <!--Child Table Place-->
        <p>
        <div id=\"edit-mode\">
        <?php
        \$arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
        echo suInput('input', \$arg);
        ?>
        </div>
        </p>
        </div>
        <?php
        //Referrer field
        if(isset(\$_GET['referrer'])){//This is the case when page comes from preview page
            \$_SERVER['HTTP_REFERER']=\$_GET['referrer'];
        }
        \$arg = array('type' => 'hidden', 'name' => 'referrer', 'id' => 'referrer', 'value' => \$_SERVER['HTTP_REFERER']);
        echo suInput('input', \$arg);                       
        //Id field
        \$arg = array('type' => 'hidden', 'name' => '" . $_POST['primary'] . "', 'id' => '" . $_POST['primary'] . "', 'value' => \$id);
        echo suInput('input', \$arg);
        //If Duplicate
        if (\$do == 'add') {
            \$arg = array('type' => 'hidden', 'name' => 'duplicate', 'id' => 'duplicate', 'value' => '1');
        }
        echo suInput('input', \$arg);
        ?>
        <div id=\"preview-mode\">
                                        <?php
                                        //Back
                                        \$arg = array('type' => 'button', 'name' => 'btn-back', 'id' => 'btn-back', 'class' => 'btn btn-primary', 'onclick' => 'history.back(1)');
                                        echo suInput('button', \$arg, '<i class=\"fa fa-angle-double-left\"></i> Back', TRUE) . ' ';
                                        
                                        //Print
                                        \$arg = array('type' => 'button', 'name' => 'btn-print', 'id' => 'btn-print', 'class' => 'btn btn-primary', 'onclick' => 'doPrintEle(\'suForm\');');
                                        echo suInput('button', \$arg, '<i class=\"fa fa-print\"></i> Print', TRUE) . ' ';
                                        
//Edit
                                        if(\$editAccess==TRUE){
                                            
                                            \$arg = array('type' => 'button', 'name' => 'btn-edit', 'id' => 'btn-edit', 'class' => 'btn btn-primary', 'onclick' => \"doTogglePreviewButtons('edit');\");
                                            echo suInput('button', \$arg, '<i class=\"fa fa-edit\"></i> Edit', TRUE) . ' ';
                                        }
                                        
                                        //Duplicate
                                        if(\$duplicateAccess==TRUE){
                                        \$referrer = ADMIN_URL . '" . $_POST['frmFormsetvalue'] . "' . PHP_EXTENSION . '/';
                                            \$duplicate_url = ADMIN_URL . '" . $_POST['frmFormsetvalue'] . "-update' . PHP_EXTENSION . '/' . \$id . '/duplicate/?referrer=' . \$referrer;
                                                
                                            \$js = \"parent.window.location.href='\".\$duplicate_url.\"'\";
                                            \$arg = array('type' => 'button', 'name' => 'btn-duplicate', 'id' => 'btn-duplicate', 'class' => 'btn btn-primary', 'onclick' => \$js);
                                            echo suInput('button', \$arg, '<i class=\"fa fa-copy\"></i> Duplicate', TRUE) . ' ';
                                        }
                                        
                                        //Delete
                                        if(\$deleteAccess==TRUE){
                                            \$url = ADMIN_URL . \"" . $_POST['frmFormsetvalue'] . "-remote\" . PHP_EXTENSION . \"/delete/\" . \$id . \"/" . $_POST['frmFormsetvalue'] . "/\";
                                            \$arg = array('type' => 'button', 'name' => 'btn-delete', 'id' => 'btn-delete', 'class' => 'btn btn-primary', 'onclick' => 'return doPreviewDelete(\'' . CONFIRM_DELETE . '\',\'' . \$url . '\')');
                                            echo suInput('button', \$arg, '<i class=\"fa fa-trash\"></i> Delete', TRUE) . ' ';
                                        }
                                        ?>
                                    </div>
                                    
        <p>&nbsp;</p>
        
        </form>
        <script>
            $(document).ready(function () {
                doTogglePreviewButtons('<?php echo \$mode; ?>');
            });
        </script> 
";
$updateCode = $updateCodeStart . $addCode . $updateCodeEnd;
$switchView = "<div class=\"pull-right\">

                                    <a href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION;?>/?overlay=<?php echo \$_GET['overlay'];?>\"><i class=\"fa fa-table\"></i></a>
                                </div>";
//Write update code
$updateCode = str_replace('[RAPID-CODE]', $updateCode, $template);
$updateCode = str_replace("/* rapidSql */", $updateSql . "\n" . $pageTitle, $updateCode);
$updateCode = str_replace("<!--Child Table Place-->", $updateCheckBox, $updateCode);
$updateCode = str_replace("<!-- SWITCH-VIEW-CODE -->", $switchView, $updateCode);

suWrite($updatePath, $updateCode);
//Update section ends
?>
