<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Manage Users';
$pageTitle = 'Manage Users';

//Make select statement. The $SqlFrom is also used in $sqlP below.
$sqlSelect = "SELECT user__ID,user__Name,user__Email,user__Status ";
$sqlFrom = " FROM sulata_users WHERE user__dbState='Live' AND user__Type = 'Public' ";
$sql = $sqlSelect . $sqlFrom;

//Download CSV
if (suSegment(1) == 'stream-csv' && $downloadAccessCSV == TRUE) {
    $outputFileName = 'users.csv';
    $headerArray = array('Name', 'Email', 'Status');
    suSqlToCSV($sql, $headerArray, $outputFileName);
    exit;
}
//Download PDF
if (suSegment(1) == 'stream-pdf' && $downloadAccessPDF == TRUE) {
    $outputFileName = 'users.pdf';
    $fieldsArray = array('user__Name', 'user__Email', 'user__Status');
    $headerArray = array('Name', 'Email', 'Status');
    suSqlToPDF($sql, $headerArray, $fieldsArray, $outputFileName);
    exit;
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
                                <div class="pull-right"></div>



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
                                <?php if ($searchAccess == TRUE) { ?><div id="search-collection" class="su-hide">
                                        <form class="form-horizontal" name="searchForm0" id="searchForm0" method="get" action="">
                                            <?php
                                            //Fill search field
                                            if ($_GET['search_field'] == 'user__Name') {
                                                $faq__Search = $_GET['q'];
                                            } else {
                                                $faq__Search = '';
                                            }
                                            ?>
                                            <fieldset>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <input id="q" type="search" value="<?php echo $faq__Search; ?>" name="q" class="form-control" autocomplete="off" autofocus="autofocus" placeholder="Search by Name">
                                                    <input type="hidden" name="overlay" value="<?php echo $_GET['overlay']; ?>]"/>
                                                    <input type="hidden" name="search_field" value="user__Name"/>
                                                </div>
                                                <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                </div>

                                            </fieldset>
                                        </form>
                                        <form class="form-horizontal" name="searchForm1" id="searchForm1" method="get" action="">
                                            <?php
                                            //Fill search field
                                            if ($_GET['search_field'] == 'user__Email') {
                                                $faq__Search = $_GET['q'];
                                            } else {
                                                $faq__Search = '';
                                            }
                                            ?>
                                            <fieldset>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <input id="q" type="search" value="<?php echo $faq__Search; ?>" name="q" class="form-control" autocomplete="off" autofocus="autofocus" placeholder="Search by Email">
                                                    <input type="hidden" name="search_field" value="user__Email"/>
                                                    <input type="hidden" name="overlay" value="<?php echo $_GET['overlay']; ?>]"/>
                                                </div>
                                                <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                </div>

                                            </fieldset>
                                        </form>
                                    </div>
                                    <?php if ($_GET['q']) { ?>
                                        <div class="lineSpacer clear"></div>
                                        <div class="pull-right"><a style="text-decoration:underline !important;" href="<?php echo ADMIN_URL; ?>users<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>">Clear search.</a></div>
                                    <?php } ?>

                                    <div id="search-expand" class="row su-hide">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <input type="search" name="search" id="search" autocomplete="off" class="form-control" placeholder="Search.." onclick="$('#search-expand').hide('slow'); $('#search-collection').show('slow');doFocusField('q');"/>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="lineSpacer clear"></div>
                                <div id="table-area">
                                    <?php if ($addAccess == TRUE) { ?>
                                        <a href="<?php echo ADMIN_URL; ?>users-add<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>" class="btn btn-black"><i class="fa fa-plus"></i></a>
                                    <?php } ?>
                                    <?php if ($sortable == TRUE) { ?>
                                        <a href="<?php echo ADMIN_URL; ?>users-sort<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>" class="btn btn-black"><i class="fa fa-sort-alpha-down-alt"></i></a>
                                    <?php } ?>
                                </div>
                                <div class="lineSpacer clear"></div>
                                <?php
                                $fieldsArray = array('user__Name', 'user__Email', 'user__Status');

//user__Name
                                if (in_array('user__Name', $fieldsArray)) {
                                    $user__Name_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Name&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Name</a>';
                                    if ($_GET['f'] == 'user__Name' && $_GET['sort'] == 'desc') {
                                        $user__Name_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Name&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Name <i class="fa fa-caret-down"></i></a>';
                                    } else if ($_GET['f'] == 'user__Name' && $_GET['sort'] == 'asc') {
                                        $user__Name_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Name&sort=desc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Name <i class="fa fa-caret-up"></i></a>';
                                    }
                                } else {
                                    $user__Name_th = 'Name';
                                }

//user__Email
                                if (in_array('user__Email', $fieldsArray)) {
                                    $user__Email_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Email&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Email</a>';
                                    if ($_GET['f'] == 'user__Email' && $_GET['sort'] == 'desc') {
                                        $user__Email_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Email&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Email <i class="fa fa-caret-down"></i></a>';
                                    } else if ($_GET['f'] == 'user__Email' && $_GET['sort'] == 'asc') {
                                        $user__Email_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Email&sort=desc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Email <i class="fa fa-caret-up"></i></a>';
                                    }
                                } else {
                                    $user__Email_th = 'Email';
                                }

//user__Status
                                if (in_array('user__Status', $fieldsArray)) {
                                    $user__Status_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Status&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Status</a>';
                                    if ($_GET['f'] == 'user__Status' && $_GET['sort'] == 'desc') {
                                        $user__Status_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Status&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Status <i class="fa fa-caret-down"></i></a>';
                                    } else if ($_GET['f'] == 'user__Status' && $_GET['sort'] == 'asc') {
                                        $user__Status_th = '<a href="' . ADMIN_URL . 'users' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=user__Status&sort=desc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Status <i class="fa fa-caret-up"></i></a>';
                                    }
                                } else {
                                    $user__Status_th = 'Status';
                                }
                                ?>
                                <!-- TABLE -->

                                <table width="100%" class="table table-hover table-bordered tbl">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">
                                                <?php echo SERIAL; ?>
                                            </th>

                                            <th style="width:28%"><?php echo $user__Name_th; ?></th>
                                            <th style="width:28%"><?php echo $user__Email_th; ?></th>
                                            <th style="width:28%"><?php echo $user__Status_th; ?></th>
                                            <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE) || ($duplicateAccess == TRUE) || ($restoreAccess == TRUE) || ($previewAccess == TRUE)) { ?>
                                                <th style="width:10%">&nbsp;</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($_GET['q'] != '') {
                                            $where .= " AND " . $_GET['search_field'] . " LIKE '%" . suStrip($_GET['q']) . "%' ";
                                        }

                                        if (!$_GET['start']) {
                                            $_GET['start'] = 0;
                                        }
                                        if (!$_GET['sr']) {
                                            $sr = 0;
                                        } else {
                                            $sr = $_GET['sr'];
                                        }
                                        if (!$_GET['sort']) {
                                            $sort = " ORDER BY user__Email";
                                        } else {
                                            $sort = " ORDER BY " . $_GET['f'] . " " . $_GET['sort'];
                                        }
//Get records from database

                                        $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                        $result = suQuery($sql);
                                        $numRows = $result['num_rows'];
                                        foreach ($result['result'] as $row) {
                                            //Make inline edit false
                                            if ($inlineEditAccess == TRUE) {
                                                $inlineCssClass = 'inline-field';
                                            } else {
                                                $inlineCssClass = '';
                                            }
                                            ?>
                                            <tr id="card_<?php echo $row['user__ID']; ?>">
                                                <td>
                                                    <?php echo $sr = $sr + 1; ?>.
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($inlineEditAccess == TRUE) {
                                                        $onDblClick = "ondblclick=\"doToggleInlineFields('inlineForm_user__Name_" . $row['user__ID'] . "', 'user__Name_" . $row['user__ID'] . "', 'show_form')\"";
                                                    } else {
                                                        $onDblClick = '';
                                                    }
                                                    ?><span class="<?php echo $inlineCssClass; ?>" id="_____wrapper_____user__Name_<?php echo $row['user__ID']; ?>" <?php echo $onDblClick; ?>><?php echo suUnstrip($row['user__Name']); ?></span><?php suMakeInlineEdit('user__Name', 'users', suUnstrip($row['user__Name']), 'user__ID', $row['user__ID']); ?>


                                                <td><?php echo suUnstrip($row['user__Email']); ?></td>
                                                <td><?php echo suUnstrip($row['user__Status']); ?></td>

                                                <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE) || ($duplicateAccess == TRUE) || ($restoreAccess == TRUE) || ($previewAccess == TRUE)) { ?>
                                                    <td style="text-align: center;">
                                                        <?php if ($editAccess == TRUE) { ?>
                                                            <a title="<?php echo EDIT; ?>" id="card_<?php echo $row['user__ID']; ?>_edit" href="<?php echo ADMIN_URL; ?>users-update<?php echo PHP_EXTENSION; ?>/<?php echo $row['user__ID']; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-edit"></i></a>

                                                        <?php } ?>

                                                        <?php if ($duplicateAccess == TRUE) { ?>
                                                            <a title="<?php echo DUPLICATE; ?>" id="card_<?php echo $row['user__ID']; ?>_duplicate" href="<?php echo ADMIN_URL; ?>users-update<?php echo PHP_EXTENSION; ?>/<?php echo $row['user__ID']; ?>/duplicate/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-copy"></i></a>
                                                        <?php } ?>
                                                        <?php if ($deleteAccess == TRUE && $row['user__ID'] != $_SESSION[SESSION_PREFIX . 'user__ID']) { ?>
                                                            <a title="<?php echo DELETE; ?>" id="card_<?php echo $row['user__ID']; ?>_del" onclick="return delById('card_<?php echo $row['user__ID']; ?>', '<?php echo CONFIRM_DELETE_RESTORE; ?>')" href="<?php echo ADMIN_URL; ?>users-remote<?php echo PHP_EXTENSION; ?>/delete/<?php echo $row['user__ID']; ?>/" target="remote"><i class="fa fa-times color-Crimson"></i></a>
                                                        <?php } ?>
                                                        <?php if ($restoreAccess == TRUE) { ?>
                                                            <a title="<?php echo RESTORE; ?>" id="card_<?php echo $row['user__ID']; ?>_restore" href="<?php echo ADMIN_URL; ?>users-remote<?php echo PHP_EXTENSION; ?>/restore/<?php echo $row['user__ID']; ?>/" target="remote" style="display:none"><i class="fa fa-undo"></i></a>
                                                        <?php } ?>


                                                    </td>
                                                <?php } ?>



                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <!-- /TABLE -->
                                <?php
                                $sqlP = "SELECT COUNT(user__ID) AS totalRecs $sqlFrom $where";
                                suPaginate($sqlP);
                                ?>
                                <?php if ($downloadAccessCSV == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>users<?php echo PHP_EXTENSION; ?>/stream-csv/" class="btn btn-black pull-right"><i class="fa fa-download"></i> <?php echo DOWNLOAD_CSV; ?></a></p>
                                    <p>&nbsp;</p>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <?php if ($downloadAccessPDF == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>users<?php echo PHP_EXTENSION; ?>/stream-pdf/" class="btn btn-black pull-right"><i class="fa fa-download"></i> <?php echo DOWNLOAD_PDF; ?></a></p>
                                    <p>&nbsp;</p>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <?php if ($searchAccess == TRUE) { ?>                                
                                    <script>
                                        $(document).ready(function () {
                                            doFocusField('search');
    <?php if ($_GET['q']) { ?>
                                                doSearchExpand('more');
    <?php } else { ?>
                                                doSearchExpand('less');
    <?php } ?>
                                            //If only 1 search form, just show more option
                                            c = doSearchForm('searchForm');
                                            if (c == 1) {
                                                doSearchExpand('more');
                                            }
                                        });
                                    </script>
                                <?php } ?>

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