<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Add FAQs';
$pageTitle = 'Add FAQs';
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

                                    <a href="<?php echo ADMIN_URL; ?>faqs<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>faqs-remote<?php echo PHP_EXTENSION; ?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >

                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_faqs['faq__Question_req']; ?><?php echo $dbs_sulata_faqs['faq__Question_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_faqs['faq__Question_html5_type'], 'name' => 'faq__Question', 'id' => 'faq__Question', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_faqs['faq__Question_max'], 'value' => '', $dbs_sulata_faqs['faq__Question_html5_req'] => $dbs_sulata_faqs['faq__Question_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <!-- //MEDIA MANAGER -->
                                                <div class="pull-right">
                                                    <a title="Media.." rel="prettyPhoto[iframes]" href="<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/?overlay=yes&iframe=true&width=80%&height=100%"><i class="fa fa-images"></i></a>
                                                </div>
                                                <!-- MEDIA MANAGER// -->
                                                <label><?php echo $dbs_sulata_faqs['faq__Answer_req']; ?><?php echo $dbs_sulata_faqs['faq__Answer_title']; ?>:</label>

                                                <?php
                                                $arg = array('type' => $dbs_sulata_faqs['faq__Answer_html5_type'], 'name' => 'faq__Answer', 'id' => 'faq__Answer');
                                                echo suInput('textarea', $arg, '', TRUE);
                                                suCKEditor('faq__Answer');
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">        
                                                <label><?php echo $dbs_sulata_faqs['faq__Status_req']; ?><?php echo $dbs_sulata_faqs['faq__Status_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_faqs['faq__Status_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('faq__Status', $options, 'Active', $js)
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