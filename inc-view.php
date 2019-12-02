<?php
$varchar = $_POST['varchars'];
$varchar = urldecode($varchar);
$varchar = json_decode($varchar,1);
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
    //Check field types for inline edit
    if ($_POST['frmType'][$i] == 'Textbox') {
        $inlineEdit = TRUE;
    } else {
        $inlineEdit = FALSE;
    }
    $x = json_encode($_POST);
    $x='';
//echo "<script>alert('".$x.$_POST['frmType'][$i].': '.$_POST['frmShow'][$i].': '.$inlineEdit."');</script>";
    if ($_POST['frmShow'][$i] != $_POST['primary']) {
        if ($_POST['frmType'][$i] == 'HTML Area') {
            $suStripUnstrip = 'urldecode';
        } else {
            $suStripUnstrip = 'suUnstrip';
        }
        
        if (strstr($_POST['frmShow'][$i], '_Date')) {
            $fieldsToShow .= "<th style=\"width:" . $colSize . "%\"><?php echo \$" . $_POST['frmShow'][$i] . "_th" . ";?></th>\n";
            $colData .= "<td><?php echo ".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "2']);?></td>\n";
        } elseif (strstr($_POST['frmShow'][$i], '_Picture')) {
            $fieldsToShow .= "<th style=\"width:" . $colSize . "%\"><?php echo \$" . $_POST['frmShow'][$i] . "_th" . ";?></th>\n";
            $colData .= "<td>
                            <?php
                                                \$ext = suGetExtension(".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']));
                                                    \$allowed_image_format = explode(',', \$getSettings['allowed_image_formats']);
                                                    if (in_array(\$ext, \$allowed_image_format)) {
                                                        \$thumbnail = suMakeThumbnailName(".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']));

                                                        if (suCheckFileAtURL(BASE_URL . 'files/' . \$thumbnail) && ".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']) != '') {
                                                            \$defaultImage = BASE_URL . 'files/' . \$thumbnail;
                                                            echo '<img src=\"' . \$defaultImage . '\" class=\"imgThumb\"/>';
                                                        }
                                                    }
                                                    
                                                
                                                ?>
                                            
                                            </td>\n";
        } else {
            if ($_POST['frmType'][$i] == 'Currency') {
                $fieldsToShow .= "<th class=\"right\" style=\"width:" . $colSize . "%\"><?php echo \$" . $_POST['frmShow'][$i] . "_th" . ";?> <sup><?php echo \$getSettings['site_currency'];?></sup></th>\n";
            } elseif ($_POST['frmType'][$i] == 'Float' || $_POST['frmType'][$i] == 'Integer' || $_POST['frmType'][$i] == 'Double') {
                $fieldsToShow .= "<th class=\"right\" style=\"width:" . $colSize . "%\"><?php echo \$" . $_POST['frmShow'][$i] . "_th" . ";?></th>\n";
            } else {
                $fieldsToShow .= "<th style=\"width:" . $colSize . "%\"><?php echo \$" . $_POST['frmShow'][$i] . "_th" . ";?></th>\n";
            }

            if ($_POST['frmType'][$i] == 'Integer') {
                $colData .= "<td class=\"right\"><?php echo number_format(".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']));?></td>\n";
            } elseif ($_POST['frmType'][$i] == 'Double' || $_POST['frmType'][$i] == 'Float' || $_POST['frmType'][$i] == 'Currency') {

                $colData .= "<td class=\"right\"><?php echo number_format(".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']),2);?></td>\n";
            } else {

                if (in_array($_POST['frmShow'][$i], $varchar)) {
                    $colData .= "<td>"
                            . "<?php
                                if (\$inlineEditAccess == TRUE) {
                                    \$onDblClick = \"ondblclick=\\\"doToggleInlineFields('inlineForm_".$_POST['frmShow'][$i]."_\" . \$row['".$_POST['primary']."'] . \"', '".$_POST['frmShow'][$i]."_\" . \$row['".$_POST['primary']."'] . \"', 'show_form')\\\"\";
                                } else {
                                    \$onDblClick = '';
                                }
                                ?>"
                            . "<span class=\"<?php echo \$inlineCssClass; ?>\" id=\"_____wrapper_____".$_POST['frmShow'][$i]."_<?php echo \$row['".$_POST['primary']."']; ?>\" <?php echo \$onDblClick; ?>><?php echo ".$suStripUnstrip."(\$row['".$_POST['frmShow'][$i]."']); ?></span>"
                            . "<?php suMakeInlineEdit('" . $_POST['frmShow'][$i] . "', '" . $_POST['frmFormsetvalue'] . "', ".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']), '" . $_POST['primary'] . "', \$row['" . $_POST['primary'] . "']) ;?>"
                            . "</td>\n";
                } else {
                    $colData .= "<td><?php echo ".$suStripUnstrip."(\$row['" . $_POST['frmShow'][$i] . "']);?></td>\n";
                }
            }
        }
        $fieldsArray .= "'" . $_POST['frmShow'][$i] . "',";
        $csvHeaders .= "'" . makeFieldLabel($_POST['frmShow'][$i]) . "',";
        $pdfHeaders .= "'" . $_POST['frmShow'][$i] . "',";
    }


    if (strstr($_POST['frmShow'][$i], '_Date')) {
        $fieldsToShowRemote .= $_POST['frmShow'][$i] . ",";
        $fieldsToShowRemote .= " DATE_FORMAT(" . $_POST['frmShow'][$i] . ", '%b %d, %y') AS " . $_POST['frmShow'][$i] . "2,";
    } else {
        $fieldsToShowRemote .= $_POST['frmShow'][$i] . ",";
    }
    //Reset field type
}
$csvHeaders = substr($csvHeaders, 0, -1);
$pdfHeaders = substr($pdfHeaders, 0, -1);

$colData .= "
    
    <?php if ((\$editAccess == TRUE) || (\$deleteAccess == TRUE)|| (\$duplicateAccess == TRUE)|| (\$restoreAccess == TRUE)|| (\$previewAccess == TRUE)) { ?>
    
    <td style=\"text-align: center;\">
    
<!-- PREVIEW -->
<?php if (\$previewAccess == TRUE) { ?>
                                                <a title=\"<?php echo PREVIEW; ?>\" id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>_preview\" href=\"<?php echo ADMIN_URL;?>" . $_POST['frmFormsetvalue'] . "-update<?php echo PHP_EXTENSION;?>/<?php echo \$row['" . $_POST['primary'] . "'];?>/preview/?overlay=<?php echo \$_GET['overlay'];?>\"><i class=\"fa fa-eye\"></i></a>

<?php } ?>


<!-- EDIT -->
    <?php if (\$editAccess == TRUE) { ?>
                                                <a title=\"<?php echo EDIT; ?>\" id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>_edit\" href=\"<?php echo ADMIN_URL;?>" . $_POST['frmFormsetvalue'] . "-update<?php echo PHP_EXTENSION;?>/<?php echo \$row['" . $_POST['primary'] . "'];?>/?overlay=<?php echo \$_GET['overlay'];?>\"><i class=\"fa fa-edit\"></i></a>

<?php } ?>
<!-- DUPLICATE -->
<?php if (\$duplicateAccess == TRUE) { ?>
                                                <a title=\"<?php echo DUPLICATE; ?>\" id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>_duplicate\" href=\"<?php echo ADMIN_URL;?>" . $_POST['frmFormsetvalue'] . "-update<?php echo PHP_EXTENSION;?>/<?php echo \$row['" . $_POST['primary'] . "'];?>/duplicate/?overlay=<?php echo \$_GET['overlay'];?>\"><i class=\"fa fa-copy\"></i></a>
                  <?php } ?>
<!-- DELETE -->
<?php if (\$deleteAccess == TRUE) { ?>
                                                <a title=\"<?php echo DELETE; ?>\" id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>_del\" onclick=\"return delById('card_<?php echo \$row['" . $_POST['primary'] . "']; ?>', '<?php echo CONFIRM_DELETE_RESTORE; ?>')\" href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-remote<?php echo PHP_EXTENSION;?>/delete/<?php echo \$row['" . $_POST['primary'] . "']; ?>/\" target=\"remote\"><i class=\"fa fa-times color-Crimson\"></i></a>
                                                    <?php } ?>

<!-- RESTORE -->
<?php if (\$restoreAccess == TRUE) { ?>
                                                <a title=\"<?php echo RESTORE; ?>\" id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>_restore\" href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-remote<?php echo PHP_EXTENSION;?>/restore/<?php echo \$row['" . $_POST['primary'] . "']; ?>/\" target=\"remote\" style=\"display:none\"><i class=\"fa fa-undo\"></i></a>
                                                    <?php } ?>


                                            </td>
                                            <?php } ?>

";
/* $fieldsToShow .= "
  edit: {title: '',width: '2%',sorting:false,list:<?php echo \$editAccess; ?>},"; */

$fieldsToShow .= "<?php if ((\$editAccess == TRUE) || (\$deleteAccess == TRUE)|| (\$duplicateAccess == TRUE)|| (\$restoreAccess == TRUE)|| (\$previewAccess == TRUE)) { ?>"
        . "\n<th style=\"width:10%\">&nbsp;</th>\n"
        . "<?php } ?>";

//$fieldsToShow = substr($fieldsToShow, 0, -1);


$fieldsToShowRemote = substr($fieldsToShowRemote, 0, -1);
$fieldsArray = substr($fieldsArray, 0, -1);


$viewPath = $appPath . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '.php';
$viewCode = '<?php if ($searchAccess == TRUE) { ?>'
        . ''
        . '<div id="search-collection" class="su-hide">';
for ($i_search = 0; $i_search <= sizeof($_POST['frmSearchby']) - 1; $i_search++) {
    $viewCode .= "
                                <form class=\"form-horizontal\" name=\"searchForm" . $i_search . "\" id=\"searchForm" . $i_search . "\" method=\"get\" action=\"\">
                                    <?php
                                        //Fill search field
                                        if (\$_GET['search_field'] == '" . $_POST['frmSearchby'][$i_search] . "') {
                                            \$" . str_replace('-','_',$_POST['frmFormsetvalue']) . "__Search = \$_GET['q'];
                                        } else {
                                            \$" . str_replace('-','_',$_POST['frmFormsetvalue']) . "__Search = '';
                                        }
                                        ?>
                                    <fieldset>
                                        <div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6\">
                                        <input id=\"q\" type=\"search\" value=\"<?php echo \$" . str_replace('-','_',$_POST['frmFormsetvalue']) . "__Search;?>\" name=\"q\" class=\"form-control\" autocomplete=\"off\" autofocus=\"autofocus\" placeholder=\"Search by " . makeFieldLabel($_POST['frmSearchby'][$i_search]) . "\">
                                            <input type=\"hidden\" name=\"search_field\" value=\"" . $_POST['frmSearchby'][$i_search] . "\"/>
                                                <input type=\"hidden\" name=\"overlay\" value=\"<?php echo \$_GET['overlay'];?>\"/>
                                        </div>
                                        <div class=\"col-xs-6 col-sm-2 col-md-2 col-lg-2\">
                                                <button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-search\"></i></button>
                                            </div>

                                    </fieldset>
                                </form>
";
}

$viewCode .= "</div>
                   <?php if(\$_GET['q']){?>
                                        <div class=\"lineSpacer clear\"></div>
                                         <div class=\"pull-right\"><a style=\"text-decoration:underline !important;\" href=\"<?php echo ADMIN_URL;?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION;?>/?overlay=<?php echo \$_GET['overlay'];?>\">Clear search.</a></div>
                                        <?php } ?>

<div id=\"search-expand\" class=\"row su-hide\">
                                    <div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-6\">
                                        <input type=\"search\" name=\"search\" id=\"search\" autocomplete=\"off\" class=\"form-control\" placeholder=\"Search..\" onclick=\"$('#search-expand').hide('slow'); $('#search-collection').show('slow');doFocusField('q');\"/>
                                    </div>
                                </div>
                    <?php } ?>
                    <div class=\"lineSpacer clear\"></div>
                    <div id=\"table-area\">
                                    <?php if (\$addAccess == TRUE) { ?>
                                        <a href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-add<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo \$_GET['overlay'];?>\" class=\"btn btn-black\"><i class=\"fa fa-plus\"></i></a>
                                    <?php } ?>
                                    <?php if (\$sortable == TRUE) { ?>
                                        <a href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-sort<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo \$_GET['overlay'];?>\" class=\"btn btn-black\"><i class=\"fa fa-sort-alpha-down-alt\"></i></a>
                                    <?php } ?>
                    </div>
                        <div class=\"lineSpacer clear\"></div>
                        <?php
                                    \$fieldsArray = array(" . $fieldsArray . ");
                                    ";


//Make sort links
for ($i_search = 0; $i_search <= sizeof($_POST['frmShow']) - 1; $i_search++) {
    if ($_POST['frmShow'][$i_search] != $_POST['primary']) {
        $viewCode .= "
                                //" . $_POST['frmShow'][$i_search] . "
                                if (in_array('" . $_POST['frmShow'][$i_search] . "', \$fieldsArray)) {
                                    \$" . $_POST['frmShow'][$i_search] . "_th = '<a href=\"' . ADMIN_URL . '" . $_POST['frmFormsetvalue'] . "' . PHP_EXTENSION . '/?overlay='.\$_GET['overlay'].'&f=" . $_POST['frmShow'][$i_search] . "&sort=asc&q=' . \$_GET['q'] . '&search_field=' . \$_GET['search_field'] . '\">" . makeFieldLabel($_POST['frmShow'][$i_search]) . "</a>';
                                    if (\$_GET['f'] == '" . $_POST['frmShow'][$i_search] . "' && \$_GET['sort'] == 'desc') {
                                        \$" . $_POST['frmShow'][$i_search] . "_th = '<a href=\"' . ADMIN_URL . '" . $_POST['frmFormsetvalue'] . "' . PHP_EXTENSION . '/?overlay='.\$_GET['overlay'].'&f=" . $_POST['frmShow'][$i_search] . "&sort=asc&q=' . \$_GET['q'] . '&search_field=' . \$_GET['search_field'] . '\">" . makeFieldLabel($_POST['frmShow'][$i_search]) . " <i class=\"fa fa-caret-down\"></i></a>';
                                    } else if (\$_GET['f'] == '" . $_POST['frmShow'][$i_search] . "' && \$_GET['sort'] == 'asc') {
                                        \$" . $_POST['frmShow'][$i_search] . "_th = '<a href=\"' . ADMIN_URL . '" . $_POST['frmFormsetvalue'] . "' . PHP_EXTENSION . '/?overlay='.\$_GET['overlay'].'&f=" . $_POST['frmShow'][$i_search] . "&sort=desc&q=' . \$_GET['q'] . '&search_field=' . \$_GET['search_field'] . '\">" . makeFieldLabel($_POST['frmShow'][$i_search]) . " <i class=\"fa fa-caret-up\"></i></a>';
                                    }
                                } else {
                                    \$" . $_POST['frmShow'][$i_search] . "_th = '" . makeFieldLabel($_POST['frmShow'][$i_search]) . "';
                                }
                                ";
    }
}
$viewCode .= "
                                    ?>
<!-- TABLE -->

   <table width=\"100%\" class=\"table table-hover table-bordered tbl\">
                                    <thead>
                                        <tr>
                                            <th style=\"width:5%\">
                                               <?php echo SERIAL;?>
                                            </th>

                                           $fieldsToShow
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
if (\$_GET['q'] != '') {
            \$where .= \" AND \" . \$_GET['search_field'] . \" LIKE '%\" . suStrip(\$_GET['q']) . \"%' \";
    }

if (!\$_GET['start']) {
    \$_GET['start'] = 0;
}
if (!\$_GET['sr']) {
    \$sr = 0;
} else {
    \$sr = \$_GET['sr'];
}
if (!\$_GET['sort']) {
    \$sort = \" ORDER BY " . $_POST['frmOrderby'] . "\";
} else {
    \$sort = \" ORDER BY \" . \$_GET['f'] . \" \" . \$_GET['sort'];
}
//Get records from database

    \$sql = \"\$sql \$where \$sort LIMIT \" . \$_GET['start'] . \",\" . \$getSettings['page_size'];

    \$result = suQuery(\$sql);
    \$numRows = \$result['num_rows'];
    foreach (\$result['result'] as \$row) {
        //Make inline edit false
        if (\$inlineEditAccess == TRUE) {
            \$inlineCssClass = 'inline-field';
                } else {
            \$inlineCssClass = '';
        }

?>
                                        <tr id=\"card_<?php echo \$row['" . $_POST['primary'] . "']; ?>\">
                                            <td>
                                                <?php echo \$sr = \$sr + 1; ?>.
                                            </td>
                                            $colData

                                        </tr>
    <?php } ?>

                                    </tbody>
                                </table>
<!-- /TABLE -->
                    <?php
                                \$sqlP = \"SELECT COUNT(" . $_POST['primary'] . ") AS totalRecs \$sqlFrom \$where\";
                                suPaginate(\$sqlP);
                                ?>
                                <!-- DOWNLOAD CSV -->
                                <?php if (\$downloadAccessCSV == TRUE && \$numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target=\"remote\" href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION;?>/stream-csv/\" class=\"btn btn-black pull-right\"><i class=\"fa fa-download\"></i> <?php echo DOWNLOAD_CSV;?></a></p>
                                    <p>&nbsp;</p>
                                    <div class=\"clearfix\"></div>
                                <?php } ?>
                                <!-- DOWNLOAD PDF -->
                                <?php if (\$downloadAccessPDF == TRUE && \$numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target=\"remote\" href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "<?php echo PHP_EXTENSION;?>/stream-pdf/\" class=\"btn btn-black pull-right\"><i class=\"fa fa-download\"></i> <?php echo DOWNLOAD_PDF;?></a></p>
                                    <p>&nbsp;</p>
                                    <div class=\"clearfix\"></div>
                                <?php } ?>
<?php if (\$searchAccess == TRUE) { ?>                                
<script>
    \$(document).ready(function () {
       doFocusField('search');
       <?php if (\$_GET['q']) { ?>
        doSearchExpand('more');
    <?php } else { ?>
        doSearchExpand('less');
    <?php } ?>
        //If only 1 search form, just show more option
        c = doSearchForm('searchForm');
        if (c == 1) {
            doSearchExpand('more');
        }
    });
    </script>
<?php } ?>
";

$pageTitle = 'Manage ' . ucwords(str_replace('-', ' ', $_POST['frmFormsetvalue']));
$pageTitle = "\$pageName='" . $pageTitle . "';\$pageTitle='" . $pageTitle . "';";

$csvDownloadCode = "
{$sortable}    
//Make select statement. The \$SqlFrom is also used in \$sqlP below.
\$sqlSelect = \"SELECT " . $fieldsToShowRemote . " \";
\$sqlFrom = \" FROM " . $_POST['table'] . " WHERE " . $fieldPrefix . "__dbState='Live'\";
\$sql = \$sqlSelect . \$sqlFrom;

//Download CSV
if (suSegment(1) == 'stream-csv' && \$downloadAccessCSV == TRUE) {
    \$outputFileName = '" . $_POST['frmFormsetvalue'] . ".csv';
    \$headerArray = array(" . $csvHeaders . ");
    suSqlToCSV(\$sql, \$headerArray, \$outputFileName);
    exit;
}
//Download PDF
if (suSegment(1) == 'stream-pdf' && \$downloadAccessPDF == TRUE) {
    \$outputFileName = '" . $_POST['frmFormsetvalue'] . ".pdf';
    \$fieldsArray = array(" . $pdfHeaders . ");
    \$headerArray = array(" . $csvHeaders . ");
    suSqlToPDF(\$sql, \$headerArray, \$fieldsArray, \$outputFileName);
    exit;
}
";
$switchToCardView = "<div class=\"pull-right\"></div>

";

//Write view code
$viewCode = str_replace('[RAPID-CODE]', $viewCode, $template);
$viewCode = str_replace("/* rapidSql */", $pageTitle . "\n" . $csvDownloadCode, $viewCode);
$viewCode = str_replace("<!-- SWITCH-VIEW-CODE -->", $switchToCardView, $viewCode);

suWrite($viewPath, $viewCode);
//View code ends
?>
