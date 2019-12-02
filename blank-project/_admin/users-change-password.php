<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

checkLogin(TRUE);

$id = suSegment(1);
if (!is_numeric($id)) {
    $id = $_SESSION[SESSION_PREFIX . 'user__ID'];
}
$sql = "SELECT user__ID,user__Name,user__Email,user__Password FROM sulata_users WHERE user__dbState='Live' AND user__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}

$pageName = 'Change Password';
$pageTitle = 'Change Password';
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
                                <?php
                                if ($_SESSION[SESSION_PREFIX . 'user__Password_Reset'] == 'Yes') {
                                    echo suInfo(FIRST_LOGIN_MESSAGE);
                                }
                                ?>
                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>users-remote<?php echo PHP_EXTENSION; ?>/update-password/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Name_req']; ?><?php echo $dbs_sulata_users['user__Name_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Name_html5_type'], 'name' => 'user__Name', 'id' => 'user__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Name_max'], 'value' => suUnstrip($row['user__Name']), $dbs_sulata_users['user__Name_html5_req'] => $dbs_sulata_users['user__Name_html5_req'], 'class' => 'form-control', 'readonly' => 'readonly');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Email_req']; ?><?php echo $dbs_sulata_users['user__Email_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Email_html5_type'], 'name' => 'user__Email', 'id' => 'user__Email', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Email_max'], 'value' => suUnstrip($row['user__Email']), $dbs_sulata_users['user__Email_html5_req'] => $dbs_sulata_users['user__Email_html5_req'], 'class' => 'form-control', 'readonly' => 'readonly');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">            
                                                <label><?php echo $dbs_sulata_users['user__Password_req']; ?><?php echo $dbs_sulata_users['user__Password_title']; ?>: 
                                                    <?php if ($getSettings['show_password'] == 'Yes') { ?>
                                                        <a href="javascript:;" onclick="doShowPassword();"><i class="fa fa-eye"></i></a>
                                                    <?php } ?>

                                                </label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password', 'id' => 'user__Password', 'maxlength' => $dbs_sulata_users['user__Password_max'], $dbs_sulata_users['user__Password_html5_req'] => $dbs_sulata_users['user__Password_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                                            
                                                <label><?php echo $dbs_sulata_users['user__Password_req']; ?><?php echo CONFIRM; ?> <?php echo $dbs_sulata_users['user__Password_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password2', 'id' => 'user__Password2', 'maxlength' => $dbs_sulata_users['user__Password_max'], $dbs_sulata_users['user__Password_html5_req'] => $dbs_sulata_users['user__Password_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>                                

                                        </div>

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
                                    $arg = array('type' => 'hidden', 'name' => 'user__ID', 'id' => 'user__ID', 'value' => $id);
                                    echo suInput('input', $arg);
                                    //If Duplicate
                                    if ($do == 'add') {
                                        $arg = array('type' => 'hidden', 'name' => 'duplicate', 'id' => 'duplicate', 'value' => '1');
                                    }
                                    echo suInput('input', $arg);
                                    ?>
                                    <p>&nbsp;</p>

                                </form>

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