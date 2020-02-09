<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Add Users';
$pageTitle = 'Add Users';
$password = suGeneratePassword();
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
                                <?php echo suInfo(PASSWORD_AUTO_GENERATED); ?>
                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>users-remote<?php echo PHP_EXTENSION; ?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">

                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Name_req']; ?><?php echo $dbs_sulata_users['user__Name_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Name_html5_type'], 'name' => 'user__Name', 'id' => 'user__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Name_max'], 'value' => '', $dbs_sulata_users['user__Name_html5_req'] => $dbs_sulata_users['user__Name_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_users['user__Email_req']; ?><?php echo $dbs_sulata_users['user__Email_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Email_html5_type'], 'name' => 'user__Email', 'id' => 'user__Email', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_users['user__Email_max'], 'value' => '', $dbs_sulata_users['user__Email_html5_req'] => $dbs_sulata_users['user__Email_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">            
                                                <label><?php echo $dbs_sulata_users['user__Password_req']; ?><?php echo $dbs_sulata_users['user__Password_title']; ?>: <a href="javascript:;" onclick="doShowPassword();"><i class="fa fa-eye"></i></a></label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password', 'id' => 'user__Password', 'maxlength' => $dbs_sulata_users['user__Password_max'], 'value' => $password, $dbs_sulata_users['user__Password_html5_req'] => $dbs_sulata_users['user__Password_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                                            
                                                <label><?php echo $dbs_sulata_users['user__Password_req']; ?><?php echo CONFIRM; ?> <?php echo $dbs_sulata_users['user__Password_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Password_html5_type'], 'name' => 'user__Password2', 'id' => 'user__Password2', 'maxlength' => $dbs_sulata_users['user__Password_max'], 'value' => $password, $dbs_sulata_users['user__Password_html5_req'] => $dbs_sulata_users['user__Password_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>   

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <label><?php echo $dbs_sulata_users['user__Picture_req']; ?><?php echo $dbs_sulata_users['user__Picture_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_users['user__Picture_html5_type'], 'name' => 'user__Picture', 'id' => 'user__Picture', $dbs_sulata_users['user__Picture_html5_req'] => $dbs_sulata_users['user__Picture_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                                <div class="container"><?php echo $getSettings['allowed_image_formats']; ?></div>
                                            </div>




                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                                                <label><?php echo $dbs_sulata_users['user__Status_req']; ?><?php echo $dbs_sulata_users['user__Status_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_users['user__Status_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('user__Status', $options, 'Active', $js)
                                                ?>
                                            </div>

                                        </div>
                                        <p class="clearfix">&nbsp;</p>                                
                                        <?php
//Build checkboxes
                                        
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
                                                        ?>
                                                        <label class="btn btn-default"><input type="checkbox" name="group__Name[]" id="group__Name" value="<?php echo $chkUid; ?>"/> <?php echo suUnstrip($row['group__Name']); ?></label>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            </tbody>
                                        </table>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                                            <label><?php
                                                $arg = array('type' => 'checkbox', 'name' => 'send_to_user', 'id' => 'send_to_user', 'value' => 'Yes', 'checked' => 'checked');
                                                echo suInput('input', $arg);
                                                ?> Email login details to user.</label>
                                        </div>

                                    </div>
                                    <p>
                                        <?php
                                        $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                        echo suInput('input', $arg);
                                        ?>                              
                                    </p>
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