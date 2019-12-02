<?php

$thisVal = "\$today";
if ($doUpdate == TRUE) {
    $thisVal = "suDateFromDb(\$row['" . $_POST['frmField'][$i] . "'])";
}
$addCode .="
<div class=\"col-xs-12 col-sm-12 col-md-" . $_POST['frmColumnCount'][$i] . " col-lg-" . $_POST['frmColumnCount'][$i] . "\">    
<label><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_req']; ?><?php echo \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_title']; ?>:</label>
                                <?php
                                \$arg = array('type' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_type'], 'name' => '" . $_POST['frmField'][$i] . "', 'id' => '" . $_POST['frmField'][$i] . "', 'autocomplete' => 'off', 'class' => 'form-control dateBox', 'maxlength' => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_max'],\$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req'] => \$dbs_" . $_POST['table'] . "['" . $_POST['frmField'][$i] . "_html5_req']);
                                echo suInput('input', \$arg);
                                ?>
                                <script>
                                    \$(function() {
                                        \$( '#" . $_POST['frmField'][$i] . "' ).datepicker({
                                            changeMonth: true,
                                            changeYear: true
                                        });
                                        \$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'yearRange', 'c-100:c+10' );
                                        \$( '#" . $_POST['frmField'][$i] . "' ).datepicker( 'option', 'dateFormat', '<?php echo DATE_FORMAT; ?>' );
                                        \$('#" . $_POST['frmField'][$i] . "').datepicker('setDate', '<?php echo  " . $thisVal . " ?>' );                
                                    });
		
                                </script>     
</div>
                               
    
";
?>