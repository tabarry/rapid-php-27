<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$do = suSegment(1);
checkLogin(TRUE);


//Validation array
$validateAsArray = array('user__Name_validateas' => 'required', 'user__Email_validateas' => 'email', 'user__Password_validateas' => 'password', 'user__Picture_validateas' => 'image', 'user__Status_validateas' => 'enum',);
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
//To skip validation set '*' to '' like: $dbs_sulata_users['user__ID_req']=''   
    suProcessForm($dbs_sulata_users, $validateAsArray);

//Check if at least one checkbox is selected
    if (sizeof($_POST['group__Name']) == 0) {
        $vError[] = VALIDATE_EMPTY_CHECKBOX;
    }


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //for picture
    if ($_FILES['user__Picture']['name'] != '') {
        $uid = uniqid();
        $user__Picture = suSlugify($_FILES['user__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql .= " ,user__Picture='" . $uploadPath . $user__Picture . "' ";
    }

    //build query for file  uploads
    $sql = "INSERT INTO sulata_users SET user__Name='" . suStrip($_POST['user__Name']) . "',user__Email='" . suStrip($_POST['user__Email']) . "',user__Password='" . crypt(suStrip($_POST['user__Password']), suStrip($_POST['user__Email'])) . "',user__Status='" . suStrip($_POST['user__Status']) . "',user__IP='" . suGetRealIpAddr() . "', user__Last_Action_On ='" . date('Y-m-d H:i:s') . "',user__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', user__dbState='Live' " . $extraSql;
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Email');
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
        // picture
        if ($_FILES['user__Picture']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_user__Picture']);
            }
            //Thumbnails
            $user__Picture_thumbnail = 'th-' . $user__Picture;
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture_thumbnail);
            $previous_thumbnail = suMakeThumbnailName($_POST['previous_user__Picture']);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $previous_thumbnail);
            }
            //==
            //Image
            suResize($defaultWidth, $defaultHeight, $_FILES['user__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture);
            //Thumbnail
            $defaultWidth = $getSettings['thumbnail_width'];
            $defaultHeight = $getSettings['thumbnail_height'];
            suResize($defaultWidth, $defaultHeight, $_FILES['user__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture_thumbnail);
        }


        /* POST INSERT PLACE */
        //Send login details to user
        if ($_POST['send_to_user'] == 'Yes') {
            $email = file_get_contents('../sulata/mails/new-user.html');
            $email = str_replace('#NAME#', $_POST['user__Name'], $email);
            $email = str_replace('#SITE_NAME#', $getSettings['site_name'], $email);
            $email = str_replace('#EMAIL#', $_POST['user__Email'], $email);
            $email = str_replace('#USER#', $_SESSION[SESSION_PREFIX . 'user__Name'], $email);
            $email = str_replace('#PASSWORD#', $_POST['user__Password'], $email);
            $email = str_replace('#URL#', BASE_URL, $email);
            $subject = sprintf(LOST_PASSWORD_SUBJECT, $getSettings['site_name']);
            //Send mails

            suMail($_POST['user__Email'], $subject, $email, $getSettings['site_name'], $getSettings['site_email'], TRUE);
        }

//Add details data
        for ($i = 0; $i <= sizeof($_POST['group__Name']) - 1; $i++) {
            $sql = "INSERT INTO sulata_user_groups SET usergroup__User='" . $max_id . "', usergroup__Group='" . $_POST['group__Name'][$i] . "', usergroup__Last_Action_On='" . date('Y-m-d H:i:s') . "', usergroup__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "'";
            suQuery($sql);
        }


        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'users' . PHP_EXTENSION . '/';
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
//To skip validation set '*' to '' like: $dbs_sulata_users['user__ID_req']=''   
    //Reset optional

    $dbs_sulata_users['user__Picture_req'] = '';
    $dbs_sulata_users['user__Password_req'] = '';

    suProcessForm($dbs_sulata_users, $validateAsArray);

//Check if at least one checkbox is selected
    if ($_POST['update_profile'] != 1) {
        if (sizeof($_POST['group__Name']) == 0) {
            $vError[] = VALIDATE_EMPTY_CHECKBOX;
        }
    }
//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    if ($_POST['user__Password'] != '') {
        $extraSql = ", user__Password='" . crypt(suStrip($_POST['user__Password']), suStrip($_POST['user__Email'])) . "'";
    }


    //for picture
    if ($_FILES['user__Picture']['name'] != '') {
        $uid = uniqid();
        $user__Picture = suSlugify($_FILES['user__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql .= " ,user__Picture='" . $uploadPath . $user__Picture . "' ";
    }

    //For self
    if ($_POST['user__ID'] == $_SESSION[SESSION_PREFIX . 'user__ID']) {
        $_POST['user__Status'] = 'Active';
    }
    $sql = "UPDATE sulata_users SET user__Name='" . suStrip($_POST['user__Name']) . "',user__Email='" . suStrip($_POST['user__Email']) . "',user__Status='" . suStrip($_POST['user__Status']) . "', user__Last_Action_On ='" . date('Y-m-d H:i:s') . "',user__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', user__dbState='Live' " . $extraSql . " WHERE user__ID='" . $_POST['user__ID'] . "'";
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Email');
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
        $max_id = $_POST['user__ID'];
        //Upload files
        // picture
        if ($_FILES['user__Picture']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_user__Picture']);
            }
            //Thumbnails
            $user__Picture_thumbnail = 'th-' . $user__Picture;
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture_thumbnail);
            $previous_thumbnail = suMakeThumbnailName($_POST['previous_user__Picture']);
            if ($_POST['duplicate'] != 1) {
                @unlink(ADMIN_UPLOAD_PATH . $previous_thumbnail);
            }
            //==
            //Image
            suResize($defaultWidth, $defaultHeight, $_FILES['user__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture);
            //Thumbnail
            $defaultWidth = $getSettings['thumbnail_width'];
            $defaultHeight = $getSettings['thumbnail_height'];
            suResize($defaultWidth, $defaultHeight, $_FILES['user__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $user__Picture_thumbnail);
        }

        /* POST UPDATE PLACE */
        if ($_POST['update_profile'] != 1) {

//update details data
            //Delete privious data
            $sql = "DELETE FROM sulata_user_groups WHERE usergroup__User='" . $max_id . "'";
            suQuery($sql);

            for ($i = 0; $i <= sizeof($_POST['group__Name']) - 1; $i++) {
                $sql = "INSERT INTO sulata_user_groups SET usergroup__User='" . $max_id . "', usergroup__Group='" . $_POST['group__Name'][$i] . "', usergroup__Last_Action_On='" . date('Y-m-d H:i:s') . "', usergroup__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "'";
                suQuery($sql);
            }
        }
        if ($_POST['update_profile'] == 1) {
            $url = ADMIN_URL;
            //Update sessions
            $sql = "SELECT user__ID, user__Name, user__Email, user__Picture,user__Status,user__Theme,user__Type FROM sulata_users WHERE user__ID='" . $max_id . "'";
            $result = suQuery($sql);

            if ($result['num_rows'] == 1) {
                //Set sessions
                $_SESSION[SESSION_PREFIX . 'user__ID'] = $result['result'][0]['user__ID'];
                $_SESSION[SESSION_PREFIX . 'user__Name'] = suUnstrip($result['result'][0]['user__Name']);
                $_SESSION[SESSION_PREFIX . 'user__Email'] = suUnstrip($result['result'][0]['user__Email']);
                $_SESSION[SESSION_PREFIX . 'user__Picture'] = $result['result'][0]['user__Picture'];
                $_SESSION[SESSION_PREFIX . 'user__Status'] = $result['result'][0]['user__Status'];
                $_SESSION[SESSION_PREFIX . 'user__Type'] = $result['result'][0]['user__Type'];
                $_SESSION[SESSION_PREFIX . 'user__Theme'] = $result['result'][0]['user__Theme'];
            }
        } else {
            $url = ADMIN_URL . 'users' . PHP_EXTENSION . '/';
        }
        suPrintJs("
            parent.window.location.href='" . $url . "';
        ");
    }
}
//Update password
if ($do == "update-password") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_users['user__ID_req']=''   
    //Reset optional

    suProcessForm($dbs_sulata_users, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_users SET user__Password='" . crypt(suStrip($_POST['user__Password']), suStrip($_POST['user__Email'])) . "',user__Password_Reset='No', user__Last_Action_On ='" . date('Y-m-d H:i:s') . "',user__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', user__dbState='Live' " . $extraSql . " WHERE user__ID='" . $_SESSION[SESSION_PREFIX . 'user__ID'] . "'";
    $result = suQuery($sql);

    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Email');
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
        $max_id = $_POST['user__ID'];
        $_SESSION[SESSION_PREFIX . 'user__Password_Reset'] = 'No';

        /* POST UPDATE PLACE */
        suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "';
        ");
    }
}

//Delete record
if ($do == "delete") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);
//Delete from database by updating just the state
    //make a unique id attach to previous unique field
    $uid = uniqid() . '-';

    $sql = "UPDATE sulata_users SET user__Email=CONCAT('" . $uid . "',user__Email), user__Last_Action_On ='" . date('Y-m-d H:i:s') . "',user__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', user__dbState='Deleted' WHERE user__ID = '" . $id . "'";
    $result = suQuery($sql);

//Delete from child checkboxes table
    $sql = "UPDATE sulata_user_groups SET usergroup__Last_Action_On='" . date('Y-m-d H:i:s') . "', usergroup__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . " WHERE usergroup__User='" . $_POST["user__ID"] . "'";
    suQuery($sql);
}


//Restore record
if ($do == "restore") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);


    $sql = "UPDATE sulata_users SET user__Email=SUBSTR(user__Email," . (UID_LENGTH + 1) . "), user__Last_Action_On ='" . date('Y-m-d H:i:s') . "',user__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', user__dbState='Live' WHERE user__ID = '" . $id . "'";
    $result = suQuery($sql);
    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR_ON_UPDATE, 'Email');
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
    $max = sizeof($_POST['user__ID']) - 1;
    for ($i = 0; $i <= $max; $i++) {
        $j = (($max * 10) - ($i * 10)) + 10;
        $sql = "UPDATE sulata_users SET user__Sort_Order='" . $j . "' WHERE user__ID='" . $_POST['user__ID'][$i] . "'";
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
//To skip validation set '*' to '' like: $dbs_sulata_people['people__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_people, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);
    $fld = $_POST['_____field_____name'];

    $sql = "UPDATE sulata_users SET " . $_POST['_____field_____name'] . "='" . suStrip($_POST['_____xx_____' . $fld]) . "' WHERE user__ID='" . $_POST['_____xx_____user__ID'] . "'";
    $result = suQuery($sql);


    if ($result['errno'] > 0) {
        if ($result['errno'] == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Email');
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
        $max_id = $_POST['_____xx_____user__ID'];
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

