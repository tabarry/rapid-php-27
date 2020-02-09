<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

checkLogin();

$id = suSegment(1);
if (!is_numeric($id)) {
    $id = $_SESSION[SESSION_PREFIX . 'user__ID'];
}
$sql = "SELECT user__ID,user__Name,user__Email,user__Password,user__Picture,user__Status,user__Notes,user__Theme,user__Type,user__IP FROM sulata_users WHERE user__dbState='Live' AND user__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}

//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    $do = 'add';
    $pageName = 'Duplicate Users';
    $pageTitle = 'Duplicate Users';
} else {
    $do = 'update';
    $pageName = 'Update Users';
    $pageTitle = 'Update Users';
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

                                    <a href="<?php echo ADMIN_URL; ?>users<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>users-remote<?php echo PHP_EXTENSION; ?>/<?php echo $do; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Name_req']; ?><?php echo $dbs_sulata_users['user__Name_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Name_html5_type'], 'name' => 'user__Name', 'id' => 'user__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Name_max'], 'value' => suUnstrip($row['user__Name']), $dbs_sulata_users['user__Name_html5_req'] => $dbs_sulata_users['user__Name_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Email_req']; ?><?php echo $dbs_sulata_users['user__Email_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Email_html5_type'], 'name' => 'user__Email', 'id' => 'user__Email', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Email_max'], 'value' => suUnstrip($row['user__Email']), $dbs_sulata_users['user__Email_html5_req'] => $dbs_sulata_users['user__Email_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                            <!-- PASSWORD FIELDS -->
                                            <div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 su-hide" id="user__Password-1">            
                                                    <label><?php echo $dbs_sulata_users['user__Password_title']; ?>:
                                                        <?php if ($getSettings['show_password'] == 'Yes') { ?>
                                                            <a href="javascript:;" onclick="doShowPassword();"><i class="fa fa-eye"></i></a>
                                                        <?php } ?>
                                                    </label>
                                                    <?php
                                                    $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password', 'id' => 'user__Password', 'maxlength' => $dbs_sulata_users['user__Password_max'], 'value' => '', 'class' => 'form-control');
                                                    echo suInput('input', $arg);
                                                    ?>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 su-hide" id="user__Password-2">                                           
                                                    <label><?php echo CONFIRM; ?> <?php echo $dbs_sulata_users['user__Password_title']; ?>:</label>
                                                    <?php
                                                    $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password2', 'id' => 'user__Password2', 'maxlength' => $dbs_sulata_users['user__Password_max'], 'value' => '', 'class' => 'form-control');
                                                    echo suInput('input', $arg);
                                                    ?>
                                                </div> 
                                                <div class="container su-hide" id="user__Password-note"><?php echo suInfo(CHANGE_PASSWORD_MESSAGE); ?></div>
                                                <p id="user__Password-change-password" class="container"><a href="javascript:;" onclick="doChangePassword('user__Password')" class="underline"><i class="fa fa-key"></i> <?php echo CHANGE_PASSWORD; ?></a></p>
                                            </div>

                                            <!--//-->
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">  

                                                <label><?php echo $dbs_sulata_users['user__Picture_req']; ?><?php echo $dbs_sulata_users['user__Picture_title']; ?>:</label>
                                                <?php
                                                if ((isset($row['user__Picture']) && $row['user__Picture'] != '') && (file_exists(ADMIN_UPLOAD_PATH . $row['user__Picture']))) {
                                                    $defaultImage = BASE_URL . 'files/' . $row['user__Picture'];
                                                } else {
                                                    $defaultImage = BASE_URL . 'files/default-image.png';
                                                }
                                                ?>

                                                <div class="imgThumb" style="background-image:url(<?php echo $defaultImage; ?>);"></div>    
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Picture_html5_type'], 'name' => 'user__Picture', 'id' => 'user__Picture', 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                                <?php if ((file_exists(ADMIN_UPLOAD_PATH . $row['user__Picture'])) && ($row['user__Picture'] != '')) { ?>
                                                    <div class="container"><a class="underline" href="<?php echo BASE_URL . 'files/' . $row['user__Picture']; ?>" target="_blank"><?php echo VIEW_FILE; ?></a></div>
                                                <?php } ?>    

                                                <div class="container"><?php echo $getSettings['allowed_image_formats']; ?></div>
                                                <?php
                                                $arg = array('type' => 'hidden', 'name' => 'previous_user__Picture', 'id' => 'previous_user__Picture', 'value' => $row['user__Picture']);
                                                echo suInput('input', $arg);
                                                ?> 
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php if (suSegment(1) != '') { ?>


                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                                                    <label><?php echo $dbs_sulata_users['user__Status_req']; ?><?php echo $dbs_sulata_users['user__Status_title']; ?>:</label>
                                                    <?php
                                                    $options = $dbs_sulata_users['user__Status_array'];
                                                    $js = "class='form-control'";
                                                    echo suDropdown('user__Status', $options, suUnstrip($row['user__Status']), $js)
                                                    ?>
                                                </div>
                                            </div>


                                            <p class="clearfix">&nbsp;</p>
                                            <?php
                                            $chkArr = array();
//Get entered data
                                            $sql = "SELECT usergroup__Group FROM sulata_user_groups WHERE usergroup__dbState ='Live' AND usergroup__User='" . $id . "'";
                                            $result = suQuery($sql);
                                            foreach ($result['result'] as $row) {
                                                array_push($chkArr, $row['usergroup__Group']);
                                            }

                                           
                                            $sql = "SELECT group__ID, group__Name FROM sulata_groups WHERE group__dbState ='Live' AND group__Status='Active' AND group__Name != 'Super Admin' ORDER BY group__Name";
                                            $result = suQuery($sql);
                                            ?>
                                            <table width="100%" class="table table-hover table-bordered tbl">
                                                <thead>
                                                    <tr>
                                                        <th width="90%">GROUPS</th>
                                                        <th width="10%" class="right">
                                                            &nbsp;
                                                            <?php if ($addAccess == TRUE) { ?>
                                                                <a title="Add new record.." rel="prettyPhoto[iframes]" href="<?php echo ADMIN_URL; ?>groups-add<?php echo PHP_EXTENSION; ?>/?overlay=yes&iframe=true&width=100%&height=100%"><i class="fa fa-plus"></i></a> <a onclick="suReload2('checkboxLinkArea', '<?php echo ADMIN_URL; ?>', '<?php echo suCrypt('sulata_groups'); ?>', '<?php echo suCrypt('group__ID'); ?>', '<?php echo suCrypt('group__Name'); ?>', '<?php echo suCrypt('sulata_user_groups'); ?>', '<?php echo suCrypt('usergroup__Group'); ?>', '<?php echo suCrypt('usergroup__User'); ?>', '<?php echo suCrypt($id); ?>');" href="javascript:;"><i class="fa fa-undo"></i></a>
                                                            <?php } ?> 
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <td colspan="2">
                                                    <div id="checkboxLinkArea">
                                                        <?php
                                                        foreach ($result['result'] as $row) {
                                                            $chkUid = $row['group__ID'];
                                                            if (in_array($row['group__ID'], $chkArr)) {
                                                                $checked = "checked='checked'";
                                                            } else {
                                                                $checked = '';
                                                            }
                                                            ?>
                                                            <label class="btn btn-default"><input type="checkbox" name="group__Name[]" id="group__Name" value="<?php echo $chkUid; ?>" <?php echo $checked; ?>/> <?php echo suUnstrip($row['group__Name']); ?></label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                </tbody>
                                            </table>
                                        <?php } ?>

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
                                    $arg = array('type' => 'hidden', 'name' => 'user__ID', 'id' => 'user__ID', 'value' => $id);
                                    echo suInput('input', $arg);
                                    //If Duplicate
                                    if ($do == 'add') {
                                        $arg = array('type' => 'hidden', 'name' => 'duplicate', 'id' => 'duplicate', 'value' => '1');
                                    }
                                    echo suInput('input', $arg);
                                    //Check if self update profile
                                    if (suSegment(1) == '') {
                                        $arg = array('type' => 'hidden', 'name' => 'update_profile', 'id' => 'update_profile', 'value' => '1');
                                        echo suInput('input', $arg);
                                    }
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