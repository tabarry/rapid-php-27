<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Add Media';
$pageTitle = 'Add Media';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <script>
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

                                    <a href="<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>media-remote<?php echo PHP_EXTENSION; ?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">

                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_media['media__Title_req']; ?><?php echo $dbs_sulata_media['media__Title_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_media['media__Title_html5_type'], 'name' => 'media__Title', 'id' => 'media__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_media['media__Title_max'], 'value' => '', $dbs_sulata_media['media__Title_html5_req'] => $dbs_sulata_media['media__Title_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">    
                                                <label><?php echo $dbs_sulata_media['media__File_req']; ?><?php echo $dbs_sulata_media['media__File_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_media['media__File_html5_type'], 'name' => 'media__File', 'id' => 'media__File', $dbs_sulata_media['media__File_html5_req'] => $dbs_sulata_media['media__File_html5_req']);
                                                echo suInput('input', $arg);
                                                ?>
                                                <div><?php echo $getSettings['allowed_file_formats']; ?></div>
                                            </div>

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