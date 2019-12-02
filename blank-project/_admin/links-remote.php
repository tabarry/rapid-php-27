<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$do = suSegment(1);
checkLogin();

//Validation array
$validateAsArray = array('link__Link_validateas' => 'required',);
//---------
//Check to stop page opening outside iframe
//Deliberately disabled for list and delete conditions
if (($_GET["do"] != "check") && ($_GET["do"] != "autocomplete")) {
    suFrameBuster();
}
//Sort records
if ($do == 'sort') {
    $max = sizeof($_POST['link__ID']) - 1;
    for ($i = 0; $i <= $max; $i++) {
        $j = (($max * 10) - ($i * 10)) + 10;
        $sql = "UPDATE sulata_links SET link__Sort_Order='" . $j . "' WHERE link__ID='" . $_POST['link__ID'][$i] . "'";
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