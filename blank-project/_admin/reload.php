<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

//Check if it is an AJAX request
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    suExit(INVALID_ACCESS);
}
//Check referrer
suCheckRef();

if ($_GET['type'] == 'chk') {
    $tbl = suDecrypt($_GET['tbl']);
    $f1 = suDecrypt($_GET['f1']);
    $f2 = suDecrypt($_GET['f2']);
    $tblb = suDecrypt($_GET['tblb']);
    $f1b = suDecrypt($_GET['f1b']);
    $f2b = suDecrypt($_GET['f2b']);
    $id = suDecrypt($_GET['id']);

    //Get entered data
    $sql = "SELECT " . $f1b . " FROM " . $tblb . " WHERE " . $f2b . "='" . $id . "'";
    //Check if the query is not destructive
    if (suGetDestructiveQuery(DB_NAME, $tblb, $sql) == FALSE) {
        suExit(INVALID_ACCESS);
    }
    $result = suQuery($sql);
    $chkArr = array();

    foreach ($result['result'] as $row) {
        array_push($chkArr, $row[$f1b]);
    }


//Build checkboxes
    //State field
    $stateField = explode('__', $f1);
    $stateField = $stateField[0] . '__dbState';

    $sql = "SELECT $f1 AS f1, $f2 AS f2 FROM $tbl WHERE $stateField='Live' ORDER BY $f2";
    //Check if the query is not destructive
    if (suGetDestructiveQuery(DB_NAME, $tbl, $sql) == FALSE) {
        suExit(INVALID_ACCESS);
    }
    $result = suQuery($sql);

    foreach ($result['result'] as $row) {
        $chkUid = $row['f1'];
        if (in_array($row['f1'], $chkArr)) {
            $checked = "checked='checked'";
        } else {
            $checked = '';
        }
        ?>
        <label class="btn btn-default"><input type="checkbox" name="group__Name[]" id="group__Name" value="<?php echo $chkUid; ?>" <?php echo $checked; ?>/> <?php echo suUnstrip($row['f2']); ?></label>

        <?php
    }
    echo '
        </ul>
        </div>';
} elseif ($_GET['type'] == 'radio') {
    $tbl = suDecrypt($_GET['tbl']);
    $f1 = suDecrypt($_GET['f1']);
    $f2 = suDecrypt($_GET['f2']);
    $stateField = explode('__', $f1);
    $stateField = $stateField[0] . '__dbState';
    $sql = "SELECT $f1 AS f1, $f2 AS f2 FROM $tbl WHERE $stateField='Live' ORDER BY $f2";
    //Check if the query is not destructive
    if (suGetDestructiveQuery(DB_NAME, $tbl, $sql) == FALSE) {
        suExit(INVALID_ACCESS);
    }
    echo suMakeRadio($sql, 'radio__Headers', $dbs_sulata_radio['radio__Headers_req'], '');
} else {
    $dd = "<option value='^'>Select..</option>";
    $tbl = suDecrypt($_GET['tbl']);
    $f1 = suDecrypt($_GET['f1']);
    $f2 = suDecrypt($_GET['f2']);
    $stateField = explode('__', $f1);
    $stateField = $stateField[0] . '__dbState';
    $sql = "SELECT $f1 AS f1, $f2 AS f2 FROM $tbl WHERE $stateField='Live' ORDER BY $f2";
    //Check if the query is not destructive
    if (suGetDestructiveQuery(DB_NAME, $tbl, $sql) == FALSE) {
        suExit(INVALID_ACCESS);
    }
    $result = suQuery($sql);
    foreach ($result['result'] as $row) {
        $dd .= "<option value='" . $row['f1'] . "'>" . suUnstrip($row['f2']) . "</option>";
    }
    echo $dd;
}
?>