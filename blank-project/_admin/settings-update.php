<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

$id = suSegment(1);
if (!is_numeric($id)) {
    suExit(INVALID_RECORD);
}
$sql = "SELECT setting__ID,setting__Scope,setting__Type,setting__Options,setting__Setting,setting__Key,setting__Value FROM sulata_settings WHERE setting__dbState='Live' AND setting__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}



//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    $do = 'add';
    $pageName = 'Duplicate settings';
    $pageTitle = 'Duplicate settings';
} else {
    $do = 'update';
    $pageName = 'Update settings';
    $pageTitle = 'Update settings';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                //Keep session alive
                $(function () {
                    window.setInterval("suStayAlive('<?php echo PING_URL; ?>')", 300000);
                });
                //Disable submit button
                suToggleButton(1);

            });
        </script> 
    </head>

    <body>

        <div class="outer">

            <!-- Sidebar starts -->

            <?php include('inc-sidebar.php'); ?>
            <!-- Sidebar ends -->

            <!-- Mainbar starts -->
            <div class="mainbar">
                <?php include('inc-heading.php'); ?>
                <!-- Mainbar head starts -->
                <div class="main-head">
                    <div class="container">
                        <?php include('inc-top-menu.php'); ?>
                    </div>
                </div>
                <!-- Mainbar head ends -->

                <div class="main-content">
                    <div class="container">

                        <div class="page-content">

                            <!-- Heading -->
                            <div class="single-head">
                                <!-- Heading -->
                                <h3 class="pull-left"><i class="fa fa-desktop purple"></i> <?php echo $pageTitle; ?></h3>
                                <div class="pull-right">

                                    <a href="<?php echo ADMIN_URL; ?>settings<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                            <div id="content-area">

                                <div id="error-area">
                                    <ul></ul>
                                </div>    
                                <div id="message-area">
                                    <p></p>
                                </div>
                                <!--SU STARTS-->

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>settings-remote<?php echo PHP_EXTENSION; ?>/<?php echo $do; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >
                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 su-hide">        
                                                <label><?php echo $dbs_sulata_settings['setting__Scope_req']; ?><?php echo $dbs_sulata_settings['setting__Scope_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_settings['setting__Scope_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('setting__Scope', $options, suUnstrip($row['setting__Scope']), $js)
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 su-hide">        
                                                <label><?php echo $dbs_sulata_settings['setting__Type_req']; ?><?php echo $dbs_sulata_settings['setting__Type_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_settings['setting__Type_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('setting__Type', $options, suUnstrip($row['setting__Type']), $js)
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 su-hide">                
                                                <label><?php echo $dbs_sulata_settings['setting__Options_req']; ?><?php echo $dbs_sulata_settings['setting__Options_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_settings['setting__Options_html5_type'], 'name' => 'setting__Options', 'id' => 'setting__Options', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Options_max'], 'value' => suUnstrip($row['setting__Options']), $dbs_sulata_settings['setting__Options_html5_req'] => $dbs_sulata_settings['setting__Options_html5_req'], 'class' => 'form-control', 'onblur' => 'doSettings();');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_settings['setting__Setting_req']; ?><?php echo $dbs_sulata_settings['setting__Setting_title']; ?>:</label>
                                                <?php
                                                $js = "return $('#setting__Key').val(doSlugify(this.value,'_'));";
                                                $arg = array('type' => $dbs_sulata_settings['setting__Setting_html5_type'], 'name' => 'setting__Setting', 'id' => 'setting__Setting', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Setting_max'], 'value' => suUnstrip($row['setting__Setting']), $dbs_sulata_settings['setting__Setting_html5_req'] => $dbs_sulata_settings['setting__Setting_html5_req'], 'class' => 'form-control', 'onkeyup' => $js, 'readonly' => 'readonly');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 su-hide">                
                                                <label><?php echo $dbs_sulata_settings['setting__Key_req']; ?><?php echo $dbs_sulata_settings['setting__Key_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_settings['setting__Key_html5_type'], 'name' => 'setting__Key', 'id' => 'setting__Key', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Key_max'], 'value' => suUnstrip($row['setting__Key']), $dbs_sulata_settings['setting__Key_html5_req'] => $dbs_sulata_settings['setting__Key_html5_req'], 'class' => 'form-control', 'readonly' => 'readonly');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_settings['setting__Value_req']; ?><?php echo $dbs_sulata_settings['setting__Value_title']; ?>:</label>
                                                <div id="option-wrapper">
                                                    <?php
                                                    $arg = array('type' => $dbs_sulata_settings['setting__Value_html5_type'], 'name' => 'setting__Value', 'id' => 'setting__Value', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Value_max'], 'value' => suUnstrip($row['setting__Value']), $dbs_sulata_settings['setting__Value_html5_req'] => $dbs_sulata_settings['setting__Value_html5_req'], 'class' => 'form-control');
                                                    echo suInput('input', $arg);
                                                    ?>
                                                </div>
                                            </div>

                                        </div>

                                        <p>
                                            <?php
                                            $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                            echo suInput('input', $arg);
                                            ?>                              
                                        </p>
                                    </div>
                                    <?php
                                    //Referrer field
                                    $arg = array('type' => 'hidden', 'name' => 'referrer', 'id' => 'referrer', 'value' => $_SERVER['HTTP_REFERER']);
                                    echo suInput('input', $arg);
                                    //Id field
                                    $arg = array('type' => 'hidden', 'name' => 'setting__ID', 'id' => 'setting__ID', 'value' => $id);
                                    echo suInput('input', $arg);
                                    //If Duplicate
                                    if ($do == 'add') {
                                        $arg = array('type' => 'hidden', 'name' => 'duplicate', 'id' => 'duplicate', 'value' => '1');
                                    }
                                    echo suInput('input', $arg);
                                    ?>
                                    <p>&nbsp;</p>

                                </form>
                                <script>
                                    var optTextbox = $('#option-wrapper').html();
                                    var optSelect = '<select required="required" name="setting__Value" id="setting__Value" class="form-control"></select>';
                                    $(document).ready(function () {
                                        //Load settings
                                        doSettings('<?php echo suUnstrip($row['setting__Value']); ?>');
                                    });


                                </script>
                                <!--SU ENDS-->
                            </div>
                        </div>
                        <?php include('inc-site-footer.php'); ?>
                    </div>
                </div>

            </div>

            <!-- Mainbar ends -->

            <div class="clearfix"></div>
        </div>
        <?php include('inc-footer.php'); ?>
        <?php suIframe(); ?>  
    </body>
    <!--PRETTY PHOTO-->
    <?php include('inc-pretty-photo.php'); ?>    
</html>