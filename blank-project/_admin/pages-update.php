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
$sql = "SELECT page__ID,page__Name,page__Permalink,page__Title,page__Keyword,page__Description,page__Header,page__Short_Text,page__Long_Text FROM sulata_pages WHERE page__dbState='Live' AND page__ID='" . $id . "'";
$result = suQuery($sql);
$row = $result['result'][0];
if ($result['num_rows'] == 0) {
    suExit(INVALID_RECORD);
}



//Check if action is duplicate
if (suSegment(2) == 'duplicate') {
    $do = 'add';
    $pageName = 'Duplicate Pages';
    $pageTitle = 'Duplicate Pages';
    $mode = 'edit';
} elseif (suSegment(2) == 'preview') {
    $do = 'update';
    $pageName = 'Preview Pages';
    $pageTitle = '<span id="page-title">Preview</span> Pages';
    $mode = 'preview';
} else {
    $do = 'update';
    $pageName = 'Update Pages';
    $pageTitle = '<span id="page-title">Update</span> Pages';
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>pages-remote<?php echo PHP_EXTENSION; ?>/<?php echo $do; ?>/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_pages['page__Name_req']; ?><?php echo $dbs_sulata_pages['page__Name_title']; ?>:</label>
                                                <?php
                                                $js = "return $('#page__Permalink').val(doSlugify(this.value,'-'));";
                                                $arg = array('type' => $dbs_sulata_pages['page__Name_html5_type'], 'name' => 'page__Name', 'id' => 'page__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Name_max'], 'value' => suUnstrip($row['page__Name']), $dbs_sulata_pages['page__Name_html5_req'] => $dbs_sulata_pages['page__Name_html5_req'], 'class' => 'form-control', 'onkeyup' => $js);
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_pages['page__Permalink_req']; ?><?php echo $dbs_sulata_pages['page__Permalink_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Permalink_html5_type'], 'name' => 'page__Permalink', 'id' => 'page__Permalink', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Permalink_max'], 'value' => suUnstrip($row['page__Permalink']), $dbs_sulata_pages['page__Permalink_html5_req'] => $dbs_sulata_pages['page__Permalink_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Title_req']; ?><?php echo $dbs_sulata_pages['page__Title_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Title_html5_type'], 'name' => 'page__Title', 'id' => 'page__Title', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Title_max'], 'value' => suUnstrip($row['page__Title']), $dbs_sulata_pages['page__Title_html5_req'] => $dbs_sulata_pages['page__Title_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Keyword_req']; ?><?php echo $dbs_sulata_pages['page__Keyword_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Keyword_html5_type'], 'name' => 'page__Keyword', 'id' => 'page__Keyword', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Keyword_max'], 'value' => suUnstrip($row['page__Keyword']), $dbs_sulata_pages['page__Keyword_html5_req'] => $dbs_sulata_pages['page__Keyword_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">                
                                                <label><?php echo $dbs_sulata_pages['page__Description_req']; ?><?php echo $dbs_sulata_pages['page__Description_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Description_html5_type'], 'name' => 'page__Description', 'id' => 'page__Description', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_pages['page__Description_max'], 'value' => suUnstrip($row['page__Description']), $dbs_sulata_pages['page__Description_html5_req'] => $dbs_sulata_pages['page__Description_html5_req'], 'class' => 'form-control');
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
                                                echo suDropdown('page__Header', $options, suUnstrip($row['page__Header']), $js)
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                
                                                <label><?php echo $dbs_sulata_pages['page__Short_Text_req']; ?><?php echo $dbs_sulata_pages['page__Short_Text_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Short_Text_html5_type'], 'name' => 'page__Short_Text', 'id' => 'page__Short_Text', $dbs_sulata_pages['page__Short_Text_html5_req'] => $dbs_sulata_pages['page__Short_Text_html5_req'], 'class' => 'form-control');
                                                echo suInput('textarea', $arg, suUnstrip($row['page__Short_Text']), TRUE);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                                                <label><?php echo $dbs_sulata_pages['page__Long_Text_req']; ?><?php echo $dbs_sulata_pages['page__Long_Text_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_pages['page__Long_Text_html5_type'], 'name' => 'page__Long_Text', 'id' => 'page__Long_Text');
                                                echo suInput('textarea', $arg, urldecode($row['page__Long_Text']), TRUE);
                                                suCKEditor('page__Long_Text');
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
                                    $arg = array('type' => 'hidden', 'name' => 'page__ID', 'id' => 'page__ID', 'value' => $id);
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
                                            $referrer = ADMIN_URL . 'pages' . PHP_EXTENSION . '/';
                                            $duplicate_url = ADMIN_URL . 'pages-update' . PHP_EXTENSION . '/' . $id . '/duplicate/?referrer=' . $referrer;

                                            $js = "parent.window.location.href='" . $duplicate_url . "'";
                                            $arg = array('type' => 'button', 'name' => 'btn-duplicate', 'id' => 'btn-duplicate', 'class' => 'btn btn-primary', 'onclick' => $js);
                                            echo suInput('button', $arg, '<i class="fa fa-copy"></i> Duplicate', TRUE) . ' ';
                                        }

                                        //Delete
                                        if ($deleteAccess == TRUE) {
                                            $url = ADMIN_URL . "pages-remote" . PHP_EXTENSION . "/delete/" . $id . "/pages/";
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