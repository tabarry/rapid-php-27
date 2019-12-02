<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$do = suSegment(1);
checkLogin();
//Validation array
$validateAsArray = array('media__Title_validateas' => 'required', 'media__File_validateas' => 'file',);
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
//To skip validation set '*' to '' like: $dbs_sulata_media['media__ID_req']=''   
    suProcessForm($dbs_sulata_media, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //for file
    if ($_FILES['media__File']['name'] != '') {
        $uid = uniqid();
        $media__File = suSlugify($_FILES['media__File']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql .= " ,media__File='" . $uploadPath . $media__File . "' ";
    }

    //build query for file  uploads
    $sql = "INSERT INTO sulata_media SET media__Title='" . suStrip($_POST['media__Title']) . "', media__Last_Action_On ='" . date('Y-m-d H:i:s') . "',media__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', media__dbState='Live' " . $extraSql;
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Title');
        } else {
            $error = MYSQL_ERROR;
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
        // file
        if ($_FILES['media__File']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $media__File);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_media__File']);
            }
            //Copy file
            copy($_FILES['media__File']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $media__File);
            //Make a thumbnail if image
            $ext = suGetExtension($_FILES['media__File']['name']);
            $allowed_image_format = explode(',', $getSettings['allowed_image_formats']);
            if (in_array($ext, $allowed_image_format)) {
                $media__File_thumbnail = 'th-' . $media__File;
                $defaultWidth = $getSettings['thumbnail_width'];
                $defaultHeight = $getSettings['thumbnail_height'];
                suResize($defaultWidth, $defaultHeight, $_FILES['media__File']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $media__File_thumbnail);
            }
        }


        /* POST INSERT PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'media' . PHP_EXTENSION . '/';
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
//To skip validation set '*' to '' like: $dbs_sulata_media['media__ID_req']=''   
    //Reset optional

    $dbs_sulata_media['media__File_req'] = '';


    $dbs_sulata_media['media__File_req'] = '';



    suProcessForm($dbs_sulata_media, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    //for file
    if ($_FILES['media__File']['name'] != '') {
        $uid = uniqid();
        $media__File = suSlugify($_FILES['media__File']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql .= " ,media__File='" . $uploadPath . $media__File . "' ";
    }

    $sql = "UPDATE sulata_media SET media__Title='" . suStrip($_POST['media__Title']) . "', media__Last_Action_On ='" . date('Y-m-d H:i:s') . "',media__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', media__dbState='Live' " . $extraSql . " WHERE media__ID='" . $_POST['media__ID'] . "'";
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Title');
        } else {
            $error = MYSQL_ERROR;
        }

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
    } else {
        $max_id = $_POST['media__ID'];
        //Upload files
        // file
        if ($_FILES['media__File']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $media__File);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_media__File']);
            }
            //Thumbnails
            $media__File_thumbnail = 'th-' . $media__File;
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $media__File_thumbnail);
            $previous_thumbnail = suMakeThumbnailName($_POST['previous_media__File']);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $previous_thumbnail);
            }
            //==
            copy($_FILES['media__File']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $media__File);
            //Make a thumbnail if image
            $ext = suGetExtension($_FILES['media__File']['name']);
            $allowed_image_format = explode(',', $getSettings['allowed_image_formats']);
            if (in_array($ext, $allowed_image_format)) {
                $defaultWidth = $getSettings['thumbnail_width'];
                $defaultHeight = $getSettings['thumbnail_height'];
                suResize($defaultWidth, $defaultHeight, $_FILES['media__File']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $media__File_thumbnail);
            }
        }

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'media' . PHP_EXTENSION . '/';
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

    $sql = "UPDATE sulata_media SET media__Title=CONCAT('" . $uid . "',media__Title), media__Last_Action_On ='" . date('Y-m-d H:i:s') . "',media__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', media__dbState='Deleted' WHERE media__ID = '" . $id . "'";
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


    $sql = "UPDATE sulata_media SET media__Title=SUBSTR(media__Title," . (UID_LENGTH + 1) . "), media__Last_Action_On ='" . date('Y-m-d H:i:s') . "',media__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', media__dbState='Live' WHERE media__ID = '" . $id . "'";
    $result = suQuery($sql);
    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR_ON_UPDATE, 'Title');
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
    $max = sizeof($_POST['media__ID']) - 1;
    for ($i = 0; $i <= $max; $i++) {
        $j = (($max * 10) - ($i * 10)) + 10;
        $sql = "UPDATE sulata_media SET media__Sort_Order='" . $j . "' WHERE media__ID='" . $_POST['media__ID'][$i] . "'";
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
//To skip validation set '*' to '' like: $dbs_sulata_media['media__ID_req']=''   
    //Reset optional

    $dbs_sulata_media['media__File_req'] = '';


    $dbs_sulata_media['media__File_req'] = '';



    suProcessForm($dbs_sulata_media, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);
    $fld = $_POST['_____field_____name'];

    $sql = "UPDATE sulata_media SET " . $_POST['_____field_____name'] . "='" . suStrip($_POST['_____xx_____' . $fld]) . "' WHERE media__ID='" . $_POST['_____xx_____media__ID'] . "'";
    $result = suQuery($sql);


    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Title');
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
        $max_id = $_POST['_____xx_____media__ID'];
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
