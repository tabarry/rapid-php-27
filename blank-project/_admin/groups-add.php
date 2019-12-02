<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

checkLogin();
$pageName = 'Add Groups';
$pageTitle = 'Add Groups';
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

                                    <a href="<?php echo ADMIN_URL; ?>groups<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-table"></i></a>
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

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>groups-remote<?php echo PHP_EXTENSION; ?>/add/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" onsubmit="return doCheckboxCheck();" >
                                    <input type="hidden" name="is_checked" id="is_checked" value="0"/>
                                    <div class="gallery clearfix">
                                        <div class="form-group">

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
                                                <label><?php echo $dbs_sulata_groups['group__Name_req']; ?><?php echo $dbs_sulata_groups['group__Name_title']; ?>:</label>
                                                <?php
                                                $arg = array('type' => $dbs_sulata_groups['group__Name_html5_type'], 'name' => 'group__Name', 'id' => 'group__Name', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_groups['group__Name_max'], 'value' => '', $dbs_sulata_groups['group__Name_html5_req'] => $dbs_sulata_groups['group__Name_html5_req'], 'class' => 'form-control');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                                                <label><?php echo $dbs_sulata_groups['group__Status_req']; ?><?php echo $dbs_sulata_groups['group__Status_title']; ?>:</label>
                                                <?php
                                                $options = $dbs_sulata_groups['group__Status_array'];
                                                $js = "class='form-control'";
                                                echo suDropdown('group__Status', $options, 'Active', $js)
                                                ?>
                                            </div>


                                        </div>
                                        <div>&nbsp;</div>
                                        <div><label><input type="checkbox" name="check_all" id="check_all" onclick="doCheckUncheck(this, 'module_', 'check_all');"/> Toggle select.</label></div>

                                        <table width="100%" class="table table-hover table-bordered tbl">
                                            <tbody>
                                                <?php
                                                $dir = './';
                                                $dir = scandir($dir);
                                                sort($dir);
                                                //$sidebarExclude comes from config.php
                                                $sr = 0;
                                                foreach ($dir as $file) {
                                                    if ((!in_array($file, $sidebarExclude)) && ($file[0] != '.')) {
                                                        if ((!stristr($file, '-add')) && (!stristr($file, '-remote')) && (!stristr($file, '-update')) && (!stristr($file, '-sort')) && (!stristr($file, 'inc-'))) {
                                                            if ($file == 'settings.php' || $file == 'links.php') {
                                                                $settingsClass = 'class="su-hide"';
                                                            } else {
                                                                $settingsClass = '';
                                                            }
                                                            $fileNameActual = str_replace('.php', '', $file);
                                                            $fileName = str_replace('-', ' ', $fileNameActual);

                                                            $fileNameShow = str_replace('_', ' ', $fileName);
                                                            if (stristr($fileNameShow, 'faqs')) {
                                                                $fileNameShow = 'FAQs';
                                                            }
                                                            $fileLink = str_replace('.php', PHP_EXTENSION . '/', $file);
                                                            $fileNameShow1 = $fileNameShow;
                                                            $fileNameShow = $fileNameShow . '_x';
                                                            ?>
                                                            <tr>
                                                                <td style="width:5%"><?php echo $sr = $sr + 1; ?>. </td>
                                                                <td><?php echo ucwords($fileNameShow1); ?></td>
                                                                <!-- Check the row -->
                                                                <td><label><input type="checkbox" name="module_all_<?php echo suSlugifyName($fileNameShow); ?>_row" id="module_all_<?php echo suSlugifyName($fileNameShow); ?>_row" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>', 'check_all')"/> <i class="far fa-hand-point-right"></i></label></td>
                                                                <!-- View/Manage -->
                                                                <td><label><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_view" id="module_<?php echo suSlugifyName($fileNameShow); ?>_view" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-view<?php echo $module_postfix; ?>" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> View</label></td>

                                                                <!-- Preview -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_preview" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-preview<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_preview" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Preview</label></td>

                                                                <!-- Search -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_search" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-search<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_preview" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Search</label></td>


                                                                <!-- Add -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_add" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-add<?php echo $module_post; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_add" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Add</label></td>

                                                                <!-- Update/Edit -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_update" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-update<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_update" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Update</label></td>

                                                                <!-- Inline Edit -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_inlineedit" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-inlineedit<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_update" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Inline Edit</label></td>


                                                                <!-- Delete -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_delete" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-delete<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_delete" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Delete</label></td>

                                                                <!-- Restore -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_restore" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-restore<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_restore" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Restore</label></td>

                                                                <!-- Duplicate -->
                                                                <td><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_duplicate" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-duplicate<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_duplicate" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Duplicate</label></td>

                                                                <!-- Sort -->
                                                                <td class="bgColor-lightGray"><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_sort" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-sort<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_sort" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Sort</label></td>

                                                                <!-- Download CSV -->
                                                                <td class="bgColor-lightGray"><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_downloadcsv" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-downloadcsv<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_downloadcsv" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Download CSV</label></td>

                                                                <!-- Download PDF -->
                                                                <td class="bgColor-lightGray"><label <?php echo $settingsClass; ?>><input type="checkbox" name="module_<?php echo suSlugifyName($fileNameShow); ?>_downloadpdf" value="<?php echo $module_prefix; ?><?php echo suSlugifyName($fileNameShow1); ?>-downloadpdf<?php echo $module_postfix; ?>" id="module_<?php echo suSlugifyName($fileNameShow); ?>_downloadpdf" onclick="doCheckUncheck(this, 'module_<?php echo suSlugifyName($fileNameShow); ?>_row', 'module_all_<?php echo suSlugifyName($fileNameShow); ?>_row')"/> Download PDF</label></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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