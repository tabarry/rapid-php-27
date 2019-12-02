<?php

$autoCompleteCount = "";
$remoteCodeAutoInsert = "";
$remoteCodeAutoComplete = "";
$addReloadParent = "";
//Add section starts
$addPath = $appPath . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '-add.php';

for ($i = 0; $i <= sizeof($_POST['frmField']) - 1; $i++) {
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
//$pageTitle = 'Add ' . ucwords(str_replace('-', ' ', substr(trim($_POST['frmFormsetvalue']), 0, -1)));
$pageTitle = 'Add ' . ucwords(str_replace('-', ' ', trim($_POST['frmFormsetvalue'])));
$pageTitle = "\$pageName='" . $pageTitle . "';\$pageTitle='" . $pageTitle . "';";
$addCodeStart = '
        <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>' . $_POST['frmFormsetvalue'] . '-remote<?php echo PHP_EXTENSION;?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" ' . $multipart . '>

            <div class="gallery clearfix">
                <div class="form-group">';

$addCodeEnd = "
                </div>
        <!--Child Table Place-->
        </div>
        <p>
        <?php
        \$arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
        echo suInput('input', \$arg);
        ?>                              
        </p>
        <p>&nbsp;</p>
        </form>
";
//If child table checkboxes
include('inc-checkbox.php');
$addCode = $addCodeStart . $addCode . $addCodeEnd;
$switchView = "<div class=\"pull-right\">
                                        
                                    <a href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION;?>/?overlay=<?php echo \$_GET['overlay'];?>\"><i class=\"fa fa-table\"></i></a>
                                </div>";
//Write add code
//Write view template
$addCode = str_replace('[RAPID-CODE]', $addCode, $template);
$addCode = str_replace("/* rapidSql */", $pageTitle, $addCode);
$addCode = str_replace('<!--Child Table Place-->', $addCheckBox, $addCode);
$addCode = str_replace("<!-- SWITCH-VIEW-CODE -->", $switchView, $addCode);

suWrite($addPath, $addCode);
//Add section ends
?>
