<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$do = suSegment(1);
checkLogin();

//Validation array
$validateAsArray = array('faq__Question_validateas' => 'required', 'faq__Answer_validateas' => 'required', 'faq__Status_validateas' => 'enum',);
//---------
//Check to stop page opening outside iframe
//Deliberately disabled for list and delete conditions
if (($_GET["do"] != "check") && ($_GET["do"] != "autocomplete")) {
    suFrameBuster();
}
?>
<?php

//Add record
if ($do == "add") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//
//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_faqs['faq__ID_req']=''   
    suProcessForm($dbs_sulata_faqs, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_faqs SET faq__Question='" . suStrip($_POST['faq__Question']) . "',faq__Answer='" . urlencode($_POST['faq__Answer']) . "',faq__Status='" . suStrip($_POST['faq__Status']) . "', faq__Last_Action_On ='" . date('Y-m-d H:i:s') . "',faq__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', faq__dbState='Live' " . $extraSql;
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Question');
        } else {
            if (DEBUG == TRUE) {
                $error = MYSQL_ERROR_DETAILS . $result['error'];
            } else {
                $error = MYSQL_ERROR;
            }
        }

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
    } else {
        $max_id = $result['insert_id'];
        //Upload files


        /* POST INSERT PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'faqs' . PHP_EXTENSION . '/';
        }
        if ($_POST['duplicate'] == 1) {
            $doJs = "parent.suReset(\"suForm\");parent.window.location.href='" . $_POST['referrer'] . "';";
        } else {
            $doJs = 'parent.suForm.reset();';
        }
        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#error-area").hide();
            parent.$("#message-area").show();
            parent.$("#message-area").html("' . SUCCESS_MESSAGE . '");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            ' . $doJs . '
            

        ');
    }
}
//Update record
if ($do == "update") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_faqs['faq__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_faqs, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_faqs SET faq__Question='" . suStrip($_POST['faq__Question']) . "',faq__Answer='" . urlencode($_POST['faq__Answer']) . "',faq__Status='" . suStrip($_POST['faq__Status']) . "', faq__Last_Action_On ='" . date('Y-m-d H:i:s') . "',faq__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', faq__dbState='Live' " . $extraSql . " WHERE faq__ID='" . $_POST['faq__ID'] . "'";
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Question');
        } else {
            if (DEBUG == TRUE) {
                $error = MYSQL_ERROR_DETAILS . $result['error'];
            } else {
                $error = MYSQL_ERROR;
            }
        }

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
    } else {
        $max_id = $_POST['faq__ID'];
        //Upload files

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'faqs' . PHP_EXTENSION . '/';
        }
        suPrintJs("
            parent.window.location.href='" . $_POST['referrer'] . "';
        ");
    }
}

//Delete record
if ($do == "delete") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);
    $origin = suSegment(3);
//Delete from database by updating just the state
    //make a unique id attach to previous unique field
    $uid = uniqid() . '-';

    $sql = "UPDATE sulata_faqs SET faq__Question=CONCAT('" . $uid . "',faq__Question), faq__Last_Action_On ='" . date('Y-m-d H:i:s') . "',faq__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', faq__dbState='Deleted' WHERE faq__ID = '" . $id . "'";
    $result = suQuery($sql);

    if ($origin) {
        $origin = ADMIN_URL . $origin . PHP_EXTENSION . '/';
        $js = "parent.window.location.href='" . $origin . "'";
        suPrintJS($js);
        exit;
    }
}


//Restore record
if ($do == "restore") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);


    $sql = "UPDATE sulata_faqs SET faq__Question=SUBSTR(faq__Question," . (UID_LENGTH + 1) . "), faq__Last_Action_On ='" . date('Y-m-d H:i:s') . "',faq__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', faq__dbState='Live' WHERE faq__ID = '" . $id . "'";
    $result = suQuery($sql);
    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR_ON_UPDATE, 'Question');
        } else {
            if (DEBUG == TRUE) {
                $error = MYSQL_ERROR_DETAILS . $result['error'];
            } else {
                $error = MYSQL_ERROR;
            }
        }

        suPrintJs('
                parent.$("#message-area").hide();
                parent.$("#error-area").show();
                parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
                parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            ');
    } else {
        suPrintJs('
                parent.restoreById("card_' . $id . '");
                parent.$("#error-area").hide();
                parent.$("#message-area").show();
                parent.$("#message-area").html("' . RECORD_RESTORED . '");
                parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            ');
    }
}

//Sort records
if ($do == 'sort') {
    $max = sizeof($_POST['faq__ID']) - 1;
    for ($i = 0; $i <= $max; $i++) {
        $j = (($max * 10) - ($i * 10)) + 10;
        $sql = "UPDATE sulata_faqs SET faq__Sort_Order='" . $j . "' WHERE faq__ID='" . $_POST['faq__ID'][$i] . "'";
        suQuery($sql);
    }
    suPrintJs('
            parent.suToggleButton(0);
            parent.$("#error-area").hide();
            parent.$("#message-area").show();
            parent.$("#message-area").html("' . RECORDS_SORTED . '");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
}


//Update single field
if ($do == "update-single") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_faqs['faq__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_faqs, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);
    $fld = $_POST['_____field_____name'];

    $sql = "UPDATE sulata_faqs SET " . $_POST['_____field_____name'] . "='" . suStrip($_POST['_____xx_____' . $fld]) . "' WHERE faq__ID='" . $_POST['_____xx_____faq__ID'] . "'";
    $result = suQuery($sql);


    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Question');
        } else {
            if (DEBUG == TRUE) {
                $error = MYSQL_ERROR_DETAILS . $result['error'];
            } else {
                $error = MYSQL_ERROR;
            }
        }

        suPrintJs('
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            //parent.$("#_____xx_____' . $_POST['_____field_____name'] . '").val(parent.$("#_____original_____' . $_POST['_____field_____name'] . '").val());
            //parent.$("#_____wrapper_____' . $_POST['_____field_____name'] . '").html(parent.$("#_____original_____' . $_POST['_____field_____name'] . '").val());
        ');
    } else {
        $max_id = $_POST['_____xx_____faq__ID'];
        /* POST UPDATE PLACE */
        suPrintJs('
            parent.$("#error-area").hide();
            parent.$("#message-area").show();
            parent.$("#message-area").html("' . SINGLE_UPDATE_MESSAGE . '");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            
            parent.$("#_____wrapper_____' . $_POST['_____field_____name'] . '_' . $max_id . '").html(parent.$("#_____xx_____' . $_POST['_____field_____name'] . '_' . $max_id . '").val());
            parent.$("#' . $_POST['_____form_____name'] . '").hide();
            parent.$("#_____wrapper_____' . $_POST['_____field_____name'] . '_' . $max_id . '").show();
        ');
    }
}
?>    
