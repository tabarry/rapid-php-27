<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Modules';
$pageTitle = 'Modules';
$module_access = suGetModuleAccess();
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
                                <div class="clearfix">
                                    <?php
                                    $module_access = suGetModuleAccess();
                                    $dir = suGetLinks();
                                    //$sidebarExclude comes from config.php
                                    //If Public User
                                    if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Public') {
                                        foreach ($dir as $file) {
                                            if (((!in_array($file, $sidebarExclude)) ) && (in_array($file, $module_access))) {

                                                $fileNameActual = str_replace('.php', '', $file);
                                                $fileName = str_replace('-', ' ', $fileNameActual);

                                                $file = $file . '/';
                                                $fileNameShow = str_replace('_', ' ', $fileName);

                                                if (stristr($fileNameShow, 'faqs')) {
                                                    $fileNameShow = 'FAQs';
                                                }
                                                ?>
                                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"> 
                                                    <div class="module">
                                                        <a href="<?php echo ADMIN_URL . $file; ?>" class="btn sideLinkReverse"><i class="fa fa-caret-right"></i> <?php echo ucwords($fileNameShow); ?></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    //==
                                    //If Private User
                                    if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Private') {
                                        foreach ($dir as $file) {
                                            if (!in_array($file, $sidebarExclude)) {

                                                $fileNameActual = str_replace('.php', '', $file);
                                                $fileName = str_replace('-', ' ', $fileNameActual);

                                                $file = $file . '/';
                                                $fileNameShow = str_replace('_', ' ', $fileName);

                                                if (stristr($fileNameShow, 'faqs')) {
                                                    $fileNameShow = 'FAQs';
                                                }
                                                ?>
                                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"> 
                                                    <div class="module">
                                                        <a href="<?php echo ADMIN_URL . $file; ?>" class="btn sideLinkReverse"><i class="fa fa-caret-right"></i> <?php echo ucwords($fileNameShow); ?></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    //==
                                    ?>     
                                </div>
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