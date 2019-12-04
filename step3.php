<?php
include('includes/include.php');
set_time_limit(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include('inc-head.php'); ?>

    </head>
    <body>
        <div id="wrapper">
            <!--HEADER-->
            <?php include('inc-header.php'); ?>
            <!--CONTENT-->
            <div id="content">
                <h2>Step 3/3: Confirm Field Types</h2>
                <div id="table-area">
                    <?php for ($i = 0; $i <= sizeof($_POST["table"]) - 1; $i++) { ?>
                        <p>&nbsp;</p>
                        <!--main form-->
                        <fieldset name="frmSet_<?php echo $i; ?>">
                            <legend><a href="javascript:;" onClick="$('#suForm_<?php echo $i; ?>').toggle()"><?php echo $_POST["table"][$i]; ?></a></legend>
                            <form style="display:none" name="suForm_<?php echo $i; ?>" action="step4.php" method="post" id="suForm_<?php echo $i; ?>" target="remote_<?php echo $i; ?>" onsubmit="return validate3('suForm_<?php echo $i; ?>');">

                                <input type="hidden" name="frmSequence" value="<?php echo $i; ?>"/>
                                <input type="hidden" name="db" value="<?php echo $_POST["db"]; ?>"/>
                                <input type="hidden" name="table" value="<?php echo $_POST["table"][$i]; ?>"/>
                                <input type="hidden" name="folder" id="folder"/>

                                <div id="paste_<?php echo $i; ?>"> </div>
                                <table width="100%" border="0" cellspacing="0" cellpading="0">
                                    <tr>
                                        <td class="rowHeader" width="5%">&nbsp;Sr.</td>
                                        <td class="rowHeader" width="10%">Field</td>
                                        <td class="rowHeader" width="5%">Show</td>
                                        <td class="rowHeader" width="5%">OrderBy</td>
                                        <td class="rowHeader" width="5%">SearchBy</td>
                                        <td class="rowHeader" width="15%">DisplayAs</td>
                                        <td class="rowHeader" width="10%">Resize</td>
                                        <td class="rowHeader" width="10%">Default Value</td>
                                        <td class="rowHeader" width="10%">CssColumns</td>
                                        <td class="rowHeader" width="30%">Field Type</td>
                                    </tr>
                                    <?php
                                    $sql = "USE " . $_POST["db"];
                                    mysqli_query($cn, $sql) or die(mysqli_error($cn));


                                    $sql = "SHOW FULL FIELDS FROM " . $_POST["table"][$i];
                                    $rs = mysqli_query($cn, $sql) or die(mysqli_error($cn));
                                    $cnt = 0;
                                    $varchar = array();
                                    while ($row = mysqli_fetch_array($rs)) {

                                        $f_id = "";
                                        $f_name = "";

                                        //collect varchar fields for inline edit
                                        if (stristr($row[1], 'char')) {
                                            array_push($varchar, $row[0]);
                                        }

                                        if ($row[4] == 'UNI') {
                                            $uniqueField = $row[0];
                                            $unique = makeFieldLabel($row[0]);
                                        }

                                        if ($row[4] == 'PRI') {
                                            $primary = $row[0];
                                        }

                                        if ($row[6] == "auto_increment") {
                                            $disable_show_checkbox = "readonly=\"readonly\"";
                                            $hide = "style='display:none;'";
                                        } else {
                                            $disable_show_checkbox = "";
                                            $hide = "";
                                            $cnt = $cnt + 1;
                                        }
                                        if ($cnt == 1) {
                                            $chkRadio = "checked='checked'";
                                        } else {
                                            $chkRadio = '';
                                        }
                                        if ($row[8] != "") {
                                            //Check if needs to be show
                                            if (stristr($row[8], '|s')) {
                                                $showChk = "checked='checked'";
                                            } else {
                                                $showChk = '';
                                            }
                                            //Check if needs to be ordered by
                                            if (stristr($row[8], '|o')) {
                                                $orderChk = "checked='checked'";
                                            } else {
                                                $orderChk = '';
                                            }
                                            $show1 = explode("|", $row[8]);

                                            $size = sizeof($show1) - 1;

                                            $s = explode(",", $show1[$size]);
                                            $f_id = $s[0];
                                            $f_name = $s[1];
                                        } else {
                                            $showChk = '';
                                            $orderChk = "checked='checked'";
                                        }
                                        if ($row[6] == "auto_increment") {
                                            $showChk = "checked='checked'";
                                        }
                                        ?>
                                        <?php if ((!stristr($row[0], '__Last_Action_On')) && (!stristr($row[0], '__Last_Action_By')) && (!stristr($row[0], '__Sort_Order')) && (!stristr($row[0], '__dbState'))) { ?>
                                            <tr <?php echo $hide; ?>>
                                                <td class="rowData">&nbsp;<?php echo $cnt; ?>.</td>
                                                <td class="rowData">
                                                    <?php echo makeFieldLabel($row[0]); ?>
                                                    <input type="hidden" name="frmLabel[]" id="frmLabel" value="<?php echo makeFieldLabel($row[0]); ?>"/>
                                                    <input type="hidden" name="frmField[]" id="frmField" value="<?php echo $row[0]; ?>"/>
                                                </td>
                                                <td class="rowData">
                                                    <input type="checkbox" name="frmShow[]" id="frmShow" value="<?php echo $row[0]; ?>" <?php echo $disable_show_checkbox; ?> <?php echo $showChk; ?> title="Show" />
                                                </td>
                                                <td class="rowData">
                                                    <?php
                                                    if ($row[0] == $uniqueField) {
                                                        $checkOrder = " checked='checked' ";
                                                    } else {
                                                        $checkOrder = "";
                                                    }
                                                    ?>

                                                    <input name="frmOrderby" id="frmOrderby" type="radio" <?php echo $checkOrder; ?> value="<?php echo $row[0]; ?>" title="Order By" />
                                                </td>
                                                <td class="rowData">
                                                    <?php
                                                    if ($row[0] == $uniqueField) {
                                                        $checkSearch = " checked='checked' ";
                                                    } else {
                                                        $checkSearch = "";
                                                    }
                                                    ?>
                                                    <input type="checkbox" name="frmSearchby[]" id="frmSearchby" value="<?php echo $row[0]; ?>" <?php echo $checkSearch; ?> title="Search By" />
                                                </td>
                                                <td class="rowData">




                                                    <select name="frmType[]" id="frmType" class="select">
                                                        <option>Select..</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Textbox"); ?>>Textbox</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Hidden"); ?>>Hidden</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Email"); ?>>Email</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Password"); ?>>Password</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Textarea"); ?>>Textarea</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "HTML Area"); ?>>HTML Area</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Integer"); ?>>Integer</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Float"); ?>>Float</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Double"); ?>>Double</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Currency"); ?>>Currency</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Date"); ?>>Date</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Enum"); ?>>Enum</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Dropdown from DB"); ?>>Dropdown from DB</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Radio from DB"); ?>>Radio from DB</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Autocomplete"); ?>>Autocomplete</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Searchable Dropdown"); ?>>Searchable Dropdown</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Quick Pick Textarea"); ?>>Quick Pick</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "File field"); ?>>File field</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Picture field"); ?>>Picture field</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Attachment field"); ?>>Attachment field</option>


                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "URL"); ?>>URL</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "IP"); ?>>IP</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Credit Card"); ?>>Credit Card</option>
                                                        <option <?php makeFieldType($row[8], $row[0], $row[1], "Skip"); ?>>Skip</option>
                                                    </select>



                                                </td>
                                                <td class="rowData">
                                                    <select name="frmResize[]" id="frmResize" class="selectOpen">
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </td>
                                                <td class="rowData"><input name="frmDefaultvalue[]" id="frmDefaultvalue" type="text" value="<?php echo $row[5]; ?>"/></td>
                                                <td class="rowData">
                                                    <select name="frmColumnCount[]" id="frmColumnCount"class="select">
                                                        <?php
                                                        foreach ($columnCount as $key => $value) {

                                                            if ($key == '6/12') {
                                                                $selCol = "selected='selected'";
                                                            } else {
                                                                $selCol = '';
                                                            }
                                                            echo "<option value='{$value}' {$selCol}>" . $key . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td class="rowData">
                                                    <select name="frmForeignkeytext[]" id="frmForeignkeytext" disabled1="true" class="select">
                                                        <option>Option Text..</option>
                                                        <?php echo tableDd($_POST["db"], $f_name); ?>
                                                    </select>
                                                    <select name="frmForeignkeyvalue[]" id="frmForeignkeyvalue" disabled1="true" class="select">
                                                        <option>Option Value..</option>
                                                        <?php echo tableDd($_POST["db"], $f_id); ?>
                                                    </select>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    <?php }mysqli_free_result($rs); ?>
                                </table>
                                <p>


                                    <label>*Pageset Name:</label>
                                    <input type="text" name="frmFormsetvalue" id="frmFormsetvalue" value="<?php
                                    $frmFormsetvalue = explodeExtract($_POST["table"][$i], "_", 0);
                                    echo $frmFormsetvalue = str_replace('_', '-', $frmFormsetvalue);
                                    ?>"/>
                                    <label>*Sub Folder Name:</label>
                                    <input type="text" name="frmSubFolder" id="frmSubFolder" value="_admin"/>          
                                    <input type="hidden" name="unique" value="<?php echo $unique; ?>"/>
                                    <input type="hidden" name="uniqueField" value="<?php echo $uniqueField; ?>"/>

                                    <input type="hidden" name="primary" value="<?php echo $primary; ?>"/>
                                    <input type="hidden" name="varchars" value="<?php echo urlencode(json_encode($varchar)); ?>"/>
                                    <label>Detail Table Source:</label>

                                    <select name="frmDetailsSourceText" id="frmDetailsSourceText" disabled1="true" class="select">
                                        <option>Checkbox Text..</option>
                                        <?php echo tableDd($_POST["db"], ''); ?>
                                    </select>
                                    <select name="frmDetailsSourceValue" id="frmDetailsSourceValue" disabled1="true" class="select">
                                        <option>Checkbox Value..</option>
                                        <?php echo tableDd($_POST["db"], ''); ?>
                                    </select> 
                                    <label>Detail Table Destination:</label>

                                    <select name="frmDetailsDestText" id="frmDetailsDestText" disabled1="true" class="select">
                                        <option>Reference of Master Table..</option>
                                        <?php echo tableDd($_POST["db"], ''); ?>
                                    </select>
                                    <select name="frmDetailsDestValue" id="frmDetailsDestValue" disabled1="true" class="select">
                                        <option>Checked field goes in..</option>
                                        <?php echo tableDd($_POST["db"], ''); ?>
                                    </select> 













                                    <?php suIframe('remote_' . $i); ?>
                            </form>
                        </fieldset>
                    <?php } ?>
                    <!--upload form-->
                    <form name="uploadForm" id="uploadForm" action="template/upload.php" method="post" enctype="multipart/form-data" target="remote">

                        <label>*Folder:</label>
                        <select name="folderName" id="folderName" onChange="copyFolderName(this.value)">
                            <option value="">Select..</option>
                            <?php echo buildWww("../"); ?>
                        </select>
                        <p id="copy">
                            <label>*Template:</label>
                            <input type="file" name="template" id="template" onChange="document.uploadForm.submit();"/>
                            <div>Template must have the tag [RAPID-CODE].</div>
                        </p>
                        <?php suIframe(); ?>
                    </form>
                    <!--db structure form-->
                    <form name="dbs" id="dbs" method="post" action="step-generate-structure.php" target="remote_dbs">
                        <input type="hidden" name="db" value="<?php echo $_POST['db']; ?>"/>
                        <input type="hidden" name="folder" id="folder" value=""/>
                    </form>
                    <?php suIframe('remote_dbs'); ?> 

                    <p>
                        <input type="button" name="Submit" value="Generate" id="generate" onclick="submitAll();"/>
                        <img src="images/blue-loading.gif" id="loading" style="display:none;" />
                    </p>
                    <p id="result"></p>

                </div>
            </div>
            <!--FOOTER-->
            <?php include('inc-footer.php'); ?>
        </div>
    </body>
</html>
