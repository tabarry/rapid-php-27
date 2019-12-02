<?php

//View code starts
//Get fields to show
$fieldsToShow = "";
$fieldsToShowRemote = "";
$setSql = "";
//$colSize = sizeof($_POST['frmShow']) - 1;

for ($i = 0; $i <= sizeof($_POST['frmShow']) - 1; $i++) {
    if (strstr($_POST['frmShow'][$i], '_Date')) {
        //$colSize = $colSize + 2;
    } else {
        //$colSize = $colSize + 1;
    }
    $colSize = $colSize + 1;
}

$colSize = round(85 / ($colSize - 1));
$colData = "";
$csvHeaders = "";
$pdfHeaders = "";
$fieldsArray = "";

for ($i = 0; $i <= sizeof($_POST['frmShow']) - 1; $i++) {
    if ($_POST['frmShow'][$i] == $_POST['uniqueField']) {
        $colData .= "<li class=\"ui-state-default\">"
                . "<sup><i class=\"fa fa-sort\"></i></sup>"
                . "<?php echo suUnstrip(\$row['" . $_POST['frmShow'][$i] . "']);?></li>\n";
//        $fieldsArray .= "'" . $_POST['frmShow'][$i] . "',";
//        $csvHeaders .= "'" . makeFieldLabel($_POST['frmShow'][$i]) . "',";
//        $pdfHeaders .= "'" . $_POST['frmShow'][$i] . "',";
    }

    $fieldsToShowRemote .= $_POST['frmShow'][$i] . ",";
}
$csvHeaders = substr($csvHeaders, 0, -1);
$pdfHeaders = substr($pdfHeaders, 0, -1);


$fieldsToShowRemote = substr($fieldsToShowRemote, 0, -1);
$fieldsArray = substr($fieldsArray, 0, -1);


$sortPath = $appPath . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '-sort.php';

$sortCode = "";
$colData='';
$sortCode .= "
<!-- TABLE -->
<div class=\"container\"><a href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo \$_GET['overlay'];?>\" class=\"btn btn-black pull-right\"><i class=\"fa fa-table\"></i></a></div>
<div class=\"clearfix\"></div>
                    
<form class=\"form-horizontal\" action=\"<?php echo ADMIN_SUBMIT_URL; ?>" . $_POST['frmFormsetvalue'] . "-remote<?php echo PHP_EXTENSION; ?>/sort/\" accept-charset=\"utf-8\" name=\"suForm\" id=\"suForm\" method=\"post\" target=\"remote\" >
   <ul id=\"sortable\">
        $fieldsToShow
<?php


if (!\$_GET['start']) {
    \$_GET['start'] = 0;
}
if (!\$_GET['sr']) {
    \$sr = 0;
} else {
    \$sr = \$_GET['sr'];
}
\$sort = \" ORDER BY " . $fieldPrefix . "__Sort_Order DESC \";
//Get records from database

    \$sql = \"\$sql \$where \$sort LIMIT \" . \$_GET['start'] . \",\" . \$getSettings['page_size'];

    \$result = suQuery(\$sql);
    \$numRows = \$result['num_rows'];
    foreach (\$result['result'] as \$row) {

?>
                                            <li class=\"ui-state-default\">
                                                <sup><i class=\"fa fa-sort\"></i></sup>
                                                <?php echo \$sr = \$sr + 1; ?>.
                                                <?php echo suUnstrip(\$row['".$_POST['uniqueField']."']); ?>
                                                <input type=\"hidden\" name=\"".$_POST['primary']."[]\" value=\"<?php echo \$row['".$_POST['primary']."']; ?>\"/>
                                            </li>
                                            $colData
    <?php } ?>

                                </ul>
                                <p>
                                        <?php
                                        \$arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                        echo suInput('input', \$arg);
                                        ?>                              
                                    </p>
                                    <p>&nbsp;</p>
                                </form>
<!-- /TABLE -->
                    <?php
                                \$sqlP = \"SELECT COUNT(" . $_POST['primary'] . ") AS totalRecs \$sqlFrom \$where\";
                                suPaginate(\$sqlP);
                                ?>

";

$pageTitle = 'Sort ' . ucwords(str_replace('-', ' ', $_POST['frmFormsetvalue']));
$pageTitle = "\$pageName='" . $pageTitle . "';\$pageTitle='" . $pageTitle . "';";
$csvDownloadCode = "
\$sortable = TRUE;
\$getSettings['page_size']=\$getSettings['sorting_page_size'];
//Make select statement. The \$SqlFrom is also used in \$sqlP below.
\$sqlSelect = \"SELECT {$fieldPrefix}__ID," . $_POST['uniqueField'] . " \";
\$sqlFrom = \" FROM " . $_POST['table'] . " WHERE " . $fieldPrefix . "__dbState='Live'\";
\$sql = \$sqlSelect . \$sqlFrom;

";
$switchToCardView = "<div class=\"pull-right\"></div>

";
//Write view code
$sortCode = str_replace('[RAPID-CODE]', $sortCode, $template);
$sortCode = str_replace("/* rapidSql */", $pageTitle . "\n" . $csvDownloadCode, $sortCode);
$sortCode = str_replace("<!-- SWITCH-VIEW-CODE -->", $switchToCardView, $sortCode);

suWrite($sortPath, $sortCode);
//View code ends
?>
