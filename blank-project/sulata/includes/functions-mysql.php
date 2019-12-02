<?php

/*
 * MySQL Functions
 */
/* Query function */
if (!function_exists('suQuery')) {

    //Send SQL to API
    function suQuery($sql) {
        //Check if curl is enabled
        if (!function_exists('curl_init')) {
            suExit(CURL_ERROR);
        }
        ///===
        $url = API_URL;
        $fields = array(
            'sql' => urlencode($sql),
            'api_key' => API_KEY,
            'debug' => API_DEBUG,
        );

        //url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $response = curl_exec($ch);

        //close connection
        curl_close($ch);

        //Decode json response to php array
        $response = json_decode($response, true);
        //Return response
        return $response;
    }

}

/* Build dropdown pagination */
if (!function_exists('suPaginate')) {

    function suPaginate($sqlP, $cssClass = 'paginate') {
        //global $getSettings['page_size'];
        global $getSettings, $sr;
        if (PHP_EXTENSION == '') {
            $phpSelf = str_replace('.php', '/', $_SERVER['PHP_SELF']);
        } else {
            $phpSelf = str_replace('.php', PHP_EXTENSION , $_SERVER['PHP_SELF']);
        }

        $resultP = suQuery($sqlP);
        $rowP = $resultP['result'][0];
        $totalRecs = $rowP['totalRecs'];
        $opt = '';
        if ($totalRecs > 0) {
            if ($totalRecs > $getSettings['page_size']) {
                for ($i = 1; $i <= ceil($totalRecs / $getSettings['page_size']); $i++) {
                    $j = $i - 1;
                    $sr = $getSettings['page_size'] * $j;
                    if ($_GET['start'] / $getSettings['page_size'] == $j) {
                        $sel = " selected='selected'";
                    } else {
                        $sel = "";
                    }
                    $opt.= "<option {$sel} value='" . $phpSelf . "?f=".$_GET['f']."&sort=".$_GET['sort']."&search_field=".$_GET['search_field']."&overlay=".$_GET['overlay']."&sr=" . $sr . "&q=" . $_GET['q'] . "&start=" . ($getSettings['page_size'] * $j) . "'>$i</option>";
                }
                echo "<div style=\"height:30px\">Go to page: <select class='{$cssClass}' onchange=\"window.location.href = this.value\">{$opt}></select></div>";
            }
        } else {
            if ($_GET['q'] == '') {
                echo '<div class="blue">' . RECORD_NOT_FOUND . '</div>';
            } else {
                echo '<div class="blue">' . SEARCH_NOT_FOUND . '</div>';
            }
        }
    }

}

/* Make label from field name */
if (!function_exists('makeFieldLabel')) {

    function makeFieldLabel($fld) {
        if (strstr($fld, "__")) {
            $fld = explode("__", $fld);
            $fld = $fld[1];
        } else {
            $fld = $fld;
        }

        return str_replace('_', ' ', $fld);
    }

}
/* Build dropdown for sorting */
if (!function_exists('suSort')) {

    function suSort($fieldsArray, $cssClass = 'paginate') {
        if (PHP_EXTENSION == '') {
            $phpSelf = str_replace('.php', '/', $_SERVER['PHP_SELF']);
        } else {
          $phpSelf = str_replace('.php', PHP_EXTENSION , $_SERVER['PHP_SELF']);
        }
                
        $opt = "<option value='" . $phpSelf . "'>Sort by..</option>";
        for ($i = 0; $i <= sizeof($fieldsArray) - 1; $i++) {
            if ($_GET['f'] == $fieldsArray[$i] && $_GET['sort'] == 'asc') {
                $sel1 = " selected='selected' ";
            } else {
                $sel1 = '';
            }
            if ($_GET['f'] == $fieldsArray[$i] && $_GET['sort'] == 'desc') {
                $sel2 = " selected='selected' ";
            } else {
                $sel2 = '';
            }
            $opt.="<option $sel1 value=\"" . $phpSelf . "?f=" . $fieldsArray[$i] . "&sort=asc&q=" . $_GET['q'] . "\">" . makeFieldLabel($fieldsArray[$i]) . " Asc</option>";
            $opt.="<option $sel2 value=\"" . $phpSelf . "?f=" . $fieldsArray[$i] . "&sort=desc&q=" . $_GET['q'] . "\">" . makeFieldLabel($fieldsArray[$i]) . " Desc</option>";
        }

        echo "<div class='paginateWrapper'><select class=\"{$cssClass}\" onchange=\"window.location.href=this.value\">{$opt}</select></div>";
    }

}
