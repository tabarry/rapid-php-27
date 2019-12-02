<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Add Pages';
$pageTitle = 'Add Pages';
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

                                    <a href="<?php echo ADMIN_URL; ?>pages<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>pages-remote<?php echo PHP_EXTENSION; ?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >

                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_pages['page__Name_req']; ?><?php echo $dbs_sulata_pages['page__Name_title']; ?>:</label>
                                                <?php
                                                $js = "return $('#page__Permalink').val(doSlugify(this.value,'-'));";
                                                $arg = array('type' => $dbs_sulata_pages['page__Name_html5_type'], 'name' => 'page__Name', 'id' => 'page__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Name_max'], 'value' => '', $dbs_sulata_pages['page__Name_html5_req'] => $dbs_sulata_pages['page__Name_html5_req'], 'class' => 'form-control', 'onkeyup' => $js);
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_pages['page__Permalink_req']; ?><?php echo $dbs_sulata_pages['page__Permalink_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Permalink_html5_type'], 'name' => 'page__Permalink', 'id' => 'page__Permalink', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Permalink_max'], 'value' => '', $dbs_sulata_pages['page__Permalink_html5_req'] => $dbs_sulata_pages['page__Permalink_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Title_req']; ?><?php echo $dbs_sulata_pages['page__Title_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Title_html5_type'], 'name' => 'page__Title', 'id' => 'page__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Title_max'], 'value' => $getSettings['default_meta_title'], $dbs_sulata_pages['page__Title_html5_req'] => $dbs_sulata_pages['page__Title_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Keyword_req']; ?><?php echo $dbs_sulata_pages['page__Keyword_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Keyword_html5_type'], 'name' => 'page__Keyword', 'id' => 'page__Keyword', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Keyword_max'], 'value' => $getSettings['default_meta_keywords'], $dbs_sulata_pages['page__Keyword_html5_req'] => $dbs_sulata_pages['page__Keyword_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Description_req']; ?><?php echo $dbs_sulata_pages['page__Description_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Description_html5_type'], 'name' => 'page__Description', 'id' => 'page__Description', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Description_max'], 'value' => $getSettings['default_meta_description'], $dbs_sulata_pages['page__Description_html5_req'] => $dbs_sulata_pages['page__Description_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_pages['page__Header_req']; ?><?php echo $dbs_sulata_pages['page__Header_title']; ?>:
                                                    <?php if ($addAccess == 'true') { ?>    
                                                        <a title="Add new record.." rel="prettyPhoto[iframes]" href="<?php echo ADMIN_URL; ?>headers-add<?php echo PHP_EXTENSION; ?>/?overlay=yes&iframe=true&width=80%&height=100%"><i class="fa fa-plus"></i></a>

                                                        <a onclick="suReload('page__Header', '<?php echo ADMIN_URL; ?>', '<?php echo suCrypt('sulata_headers'); ?>', '<?php echo suCrypt('header__ID'); ?>', '<?php echo suCrypt('header__Title'); ?>');" href="javascript:;"><i class="fa fa-undo"></i></a>    
                                                    <?php } ?>    
                                                </label>
                                                <?php
                                                $sql = "SELECT header__ID AS f1, header__Title AS f2 FROM sulata_headers where header__dbState='Live' ORDER BY f2";
                                                $options = suFillDropdown($sql);
                                                $js = "class='form-control'";
                                                echo suDropdown('page__Header', $options, '', $js)
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_pages['page__Short_Text_req']; ?><?php echo $dbs_sulata_pages['page__Short_Text_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Short_Text_html5_type'], 'name' => 'page__Short_Text', 'id' => 'page__Short_Text', $dbs_sulata_pages['page__Short_Text_html5_req'] => $dbs_sulata_pages['page__Short_Text_html5_req'], 'class' => 'form-control');
                                                echo suInput('textarea', $arg, '', TRUE);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_pages['page__Long_Text_req']; ?><?php echo $dbs_sulata_pages['page__Long_Text_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Long_Text_html5_type'], 'name' => 'page__Long_Text', 'id' => 'page__Long_Text');
                                                echo suInput('textarea', $arg, '', TRUE);
                                                suCKEditor('page__Long_Text');
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