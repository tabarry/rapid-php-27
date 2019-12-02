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
$sql = "SELECT header__ID,header__Title,header__Picture FROM sulata_headers WHERE header__dbState='Live' AND header__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}



//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    $do = 'add';
    $pageName = 'Duplicate Headers';
    $pageTitle = 'Duplicate Headers';
    $mode = 'edit';
} elseif (suSegment(2) == 'preview') {
    $do = 'update';
    $pageName = 'Preview Headers';
    $pageTitle = '<span id="page-title">Preview</span> Headers';
    $mode = 'preview';
} else {
    $do = 'update';
    $pageName = 'Update Headers';
    $pageTitle = '<span id="page-title">Update</span> Headers';
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

                                    <a href="<?php echo ADMIN_URL; ?>headers<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>headers-remote<?php echo PHP_EXTENSION; ?>/<?php echo $do; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" enctype="multipart/form-data">
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_headers['header__Title_req']; ?><?php echo $dbs_sulata_headers['header__Title_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_headers['header__Title_html5_type'], 'name' => 'header__Title', 'id' => 'header__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_headers['header__Title_max'], 'value' => suUnstrip($row['header__Title']), $dbs_sulata_headers['header__Title_html5_req'] => $dbs_sulata_headers['header__Title_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">  

                                                <label><?php echo $dbs_sulata_headers['header__Picture_req']; ?><?php echo $dbs_sulata_headers['header__Picture_title']; ?>:</label>
                                                <?php
                                                $ext = suGetExtension(suUnstrip($row['header__Picture']));
                                                $allowed_image_format = explode(',', $getSettings['allowed_image_formats']);
                                                if (in_array($ext, $allowed_image_format)) {
                                                    $thumbnail = suMakeThumbnailName(suUnstrip($row['header__Picture']));

                                                    if (suCheckFileAtURL(BASE_URL . 'files/' . $thumbnail) && suUnstrip($row['header__Picture']) != '') {
                                                        $defaultImage = BASE_URL . 'files/' . $thumbnail;
                                                        echo '<img src="' . $defaultImage . '" class="imgThumb"/>';
                                                    }
                                                }
                                                ?>


                                                <?php
                                                $arg = array('type' => $dbs_sulata_headers['header__Picture_html5_type'], 'name' => 'header__Picture', 'id' => 'header__Picture', 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>

                                                <?php if ((file_exists(ADMIN_UPLOAD_PATH . $row['header__Picture'])) && ($row['header__Picture'] != '')) { ?>
                                                    <div class="container"><a class="underline" href="<?php echo BASE_URL . 'files/' . $row['header__Picture']; ?>" target="_blank"><?php echo VIEW_FILE; ?></a></div>
                                                    <div class="container"><?php echo $getSettings['allowed_image_formats']; ?></div>
                                                <?php } ?>  
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
                                    $arg = array('type' => 'hidden', 'name' => 'header__ID', 'id' => 'header__ID', 'value' => $id);
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
                                            $referrer = ADMIN_URL . 'headers' . PHP_EXTENSION . '/';
                                            $duplicate_url = ADMIN_URL . 'headers-update' . PHP_EXTENSION . '/' . $id . '/duplicate/?referrer=' . $referrer;

                                            $js = "parent.window.location.href='" . $duplicate_url . "'";
                                            $arg = array('type' => 'button', 'name' => 'btn-duplicate', 'id' => 'btn-duplicate', 'class' => 'btn btn-primary', 'onclick' => $js);
                                            echo suInput('button', $arg, '<i class="fa fa-copy"></i> Duplicate', TRUE) . ' ';
                                        }

                                        //Delete
                                        if ($deleteAccess == TRUE) {
                                            $url = ADMIN_URL . "headers-remote" . PHP_EXTENSION . "/delete/" . $id . "/headers/";
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