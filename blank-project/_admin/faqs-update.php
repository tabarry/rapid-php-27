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
$sql = "SELECT faq__ID,faq__Question,faq__Answer,faq__Status FROM sulata_faqs WHERE faq__dbState='Live' AND faq__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}



//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    $do = 'add';
    $pageName = 'Duplicate FAQs';
    $pageTitle = 'Duplicate FAQs';
    $mode = 'edit';
} elseif (suSegment(2) == 'preview') {
    $do = 'update';
    $pageName = 'Preview FAQs';
    $pageTitle = '<span id="page-title">Preview</span> Faqs';
    $mode = 'preview';
} else {
    $do = 'update';
    $pageName = 'Update FAQs';
    $pageTitle = '<span id="page-title">Update</span> Faqs';
    $mode = 'edit';
}
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>faqs-remote<?php echo PHP_EXTENSION; ?>/<?php echo $do; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_faqs['faq__Question_req']; ?><?php echo $dbs_sulata_faqs['faq__Question_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_faqs['faq__Question_html5_type'], 'name' => 'faq__Question', 'id' => 'faq__Question', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_faqs['faq__Question_max'], 'value' => suUnstrip($row['faq__Question']), $dbs_sulata_faqs['faq__Question_html5_req'] => $dbs_sulata_faqs['faq__Question_html5_req'], 'class' => 'form-control');
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
                                                echo suInput('textarea', $arg, urldecode($row['faq__Answer']), TRUE);
                                                suCKEditor('faq__Answer');
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">        
                                                <label><?php echo $dbs_sulata_faqs['faq__Status_req']; ?><?php echo $dbs_sulata_faqs['faq__Status_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_faqs['faq__Status_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('faq__Status', $options, suUnstrip($row['faq__Status']), $js)
                                                ?>
                                            </div>

                                        </div>

                                        <p>
                                        <div id="edit-mode">
                                            <?php
                                            $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                            echo suInput('input', $arg);
                                            ?>
                                        </div>
                                        </p>
                                    </div>
                                    <?php
                                    //Referrer field
                                    if (isset($_GET['referrer'])) {//This is the case when page comes from preview page
                                        $_SERVER['HTTP_REFERER'] = $_GET['referrer'];
                                    }
                                    $arg = array('type' => 'hidden', 'name' => 'referrer', 'id' => 'referrer', 'value' => $_SERVER['HTTP_REFERER']);
                                    echo suInput('input', $arg);
                                    //Id field
                                    $arg = array('type' => 'hidden', 'name' => 'faq__ID', 'id' => 'faq__ID', 'value' => $id);
                                    echo suInput('input', $arg);
                                    //If Duplicate
                                    if ($do == 'add') {
                                        $arg = array('type' => 'hidden', 'name' => 'duplicate', 'id' => 'duplicate', 'value' => '1');
                                    }
                                    echo suInput('input', $arg);
                                    ?>
                                    <div id="preview-mode">
                                        <?php
                                        //Back
                                        $arg = array('type' => 'button', 'name' => 'btn-back', 'id' => 'btn-back', 'class' => 'btn btn-primary', 'onclick' => 'history.back(1)');
                                        echo suInput('button', $arg, '<i class="fa fa-angle-double-left"></i> Back', TRUE) . ' ';

                                        //Print
                                        $arg = array('type' => 'button', 'name' => 'btn-print', 'id' => 'btn-print', 'class' => 'btn btn-primary', 'onclick' => 'doPrintEle(\'suForm\');');
                                        echo suInput('button', $arg, '<i class="fa fa-print"></i> Print', TRUE) . ' ';

//Edit
                                        if ($editAccess == TRUE) {

                                            $arg = array('type' => 'button', 'name' => 'btn-edit', 'id' => 'btn-edit', 'class' => 'btn btn-primary', 'onclick' => "doTogglePreviewButtons('edit');");
                                            echo suInput('button', $arg, '<i class="fa fa-edit"></i> Edit', TRUE) . ' ';
                                        }

                                        //Duplicate
                                        if ($duplicateAccess == TRUE) {
                                            $referrer = ADMIN_URL . 'faqs' . PHP_EXTENSION . '/';
                                            $duplicate_url = ADMIN_URL . 'faqs-update' . PHP_EXTENSION . '/' . $id . '/duplicate/?referrer=' . $referrer;

                                            $js = "parent.window.location.href='" . $duplicate_url . "'";
                                            $arg = array('type' => 'button', 'name' => 'btn-duplicate', 'id' => 'btn-duplicate', 'class' => 'btn btn-primary', 'onclick' => $js);
                                            echo suInput('button', $arg, '<i class="fa fa-copy"></i> Duplicate', TRUE) . ' ';
                                        }

                                        //Delete
                                        if ($deleteAccess == TRUE) {
                                            $url = ADMIN_URL . "faqs-remote" . PHP_EXTENSION . "/delete/" . $id . "/faqs/";
                                            $arg = array('type' => 'button', 'name' => 'btn-delete', 'id' => 'btn-delete', 'class' => 'btn btn-primary', 'onclick' => 'return doPreviewDelete(\'' . CONFIRM_DELETE . '\',\'' . $url . '\')');
                                            echo suInput('button', $arg, '<i class="fa fa-trash"></i> Delete', TRUE) . ' ';
                                        }
                                        ?>
                                    </div>

                                    <p>&nbsp;</p>

                                </form>
                                <script>
                                    $(document).ready(function () {
                                        doTogglePreviewButtons('<?php echo $mode; ?>');
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