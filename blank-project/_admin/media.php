<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Manage Media';
$pageTitle = 'Manage Media';

//Make select statement. The $SqlFrom is also used in $sqlP below.
$sqlSelect = "SELECT media__ID,media__Title,media__File ";
$sqlFrom = " FROM sulata_media WHERE media__dbState='Live'";
$sql = $sqlSelect . $sqlFrom;

//Download CSV
if (suSegment(1) == 'stream-csv' && $downloadAccessCSV == TRUE) {
    $outputFileName = 'media.csv';
    $headerArray = array('Title', 'File');
    suSqlToCSV($sql, $headerArray, $outputFileName);
    exit;
}
//Download PDF
if (suSegment(1) == 'stream-pdf' && $downloadAccessPDF == TRUE) {
    $outputFileName = 'media.pdf';
    $fieldsArray = array('media__Title', 'media__File');
    $headerArray = array('Title', 'File');
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
                                            if ($_GET['search_field'] == 'media__Title') {
                                                $faq__Search = $_GET['q'];
                                            } else {
                                                $faq__Search = '';
                                            }
                                            ?>
                                            <fieldset>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <input id="q" type="search" value="<?php echo $faq__Search; ?>" name="q" class="form-control" autocomplete="off" autofocus="autofocus" placeholder="Search by Title">
                                                    <input type="hidden" name="search_field" value="media__Title"/>
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
                                        <div class="pull-right"><a style="text-decoration:underline !important;" href="<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>">Clear search.</a></div>
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
                                        <a href="<?php echo ADMIN_URL; ?>media-add<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>" class="btn btn-black"><i class="fa fa-plus"></i></a>
                                    <?php } ?>
                                    <?php if ($sortable == TRUE) { ?>
                                        <a href="<?php echo ADMIN_URL; ?>media-sort<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>" class="btn btn-black"><i class="fa fa-sort-alpha-down-alt"></i></a>
                                    <?php } ?>
                                </div>
                                <div class="lineSpacer clear"></div>
                                <?php
                                $fieldsArray = array('media__Title', 'media__File');

                                //media__Title
                                if (in_array('media__Title', $fieldsArray)) {
                                    $media__Title_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__Title&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Title</a>';
                                    if ($_GET['f'] == 'media__Title' && $_GET['sort'] == 'desc') {
                                        $media__Title_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__Title&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Title <i class="fa fa-caret-down"></i></a>';
                                    } else if ($_GET['f'] == 'media__Title' && $_GET['sort'] == 'asc') {
                                        $media__Title_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__Title&sort=desc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">Title <i class="fa fa-caret-up"></i></a>';
                                    }
                                } else {
                                    $media__Title_th = 'Title';
                                }

                                //media__File
                                if (in_array('media__File', $fieldsArray)) {
                                    $media__File_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__File&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">File</a>';
                                    if ($_GET['f'] == 'media__File' && $_GET['sort'] == 'desc') {
                                        $media__File_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__File&sort=asc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">File <i class="fa fa-caret-down"></i></a>';
                                    } else if ($_GET['f'] == 'media__File' && $_GET['sort'] == 'asc') {
                                        $media__File_th = '<a href="' . ADMIN_URL . 'media' . PHP_EXTENSION . '/?overlay=' . $_GET['overlay'] . '&f=media__File&sort=desc&q=' . $_GET['q'] . '&search_field=' . $_GET['search_field'] . '">File <i class="fa fa-caret-up"></i></a>';
                                    }
                                } else {
                                    $media__File_th = 'File';
                                }
                                ?>
                                <!-- TABLE -->

                                <table width="100%" class="table table-hover table-bordered tbl">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">
                                                <?php echo SERIAL; ?>
                                            </th>

                                            <th style="width:33%"><?php echo $media__Title_th; ?></th>
                                            <th style="width:43%"><?php echo $media__File_th; ?></th>
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
                                            $sort = " ORDER BY media__Title";
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
                                            <tr id="card_<?php echo $row['media__ID']; ?>">
                                                <td>
                                                    <?php echo $sr = $sr + 1; ?>.
                                                </td>
                                                <td>
                                                    <?php
                                                    $ext = suGetExtension(suUnstrip($row['media__File']));
                                                    $allowed_image_format = explode(',', $getSettings['allowed_image_formats']);
                                                    if (in_array($ext, $allowed_image_format)) {
                                                        $thumbnail = suMakeThumbnailName(suUnstrip($row['media__File']));

                                                        if (suCheckFileAtURL(BASE_URL . 'files/' . $thumbnail) && suUnstrip($row['media__File']) != '') {
                                                            $filePath = BASE_URL . 'files/' . $thumbnail;
                                                            echo '<img src="' . $filePath . '" class="imgThumb"/>';
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($inlineEditAccess == TRUE) {
                                                        $onDblClick = "ondblclick=\"doToggleInlineFields('inlineForm_media__Title_" . $row['media__ID'] . "', 'media__Title_" . $row['media__ID'] . "', 'show_form')\"";
                                                    } else {
                                                        $onDblClick = '';
                                                    }
                                                    ?><span class="<?php echo $inlineCssClass; ?>" id="_____wrapper_____media__Title_<?php echo $row['media__ID']; ?>" <?php echo $onDblClick; ?>><?php echo suUnstrip($row['media__Title']); ?></span><?php suMakeInlineEdit('media__Title', 'media', suUnstrip($row['media__Title']), 'media__ID', $row['media__ID']); ?>   

                                                </td>
                                                <td>
                                                    <input type="text" autocomplete="off" class="form-control" value="<?php echo BASE_URL . 'files/' . suUnstrip($row['media__File']); ?>"/>
                                                </td>

                                                <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE) || ($duplicateAccess == TRUE) || ($restoreAccess == TRUE) || ($previewAccess == TRUE)) { ?>
                                                    <td style="text-align: center;">

                                                        <!-- PREVIEW -->
                                                        <?php if ($previewAccess == TRUE) { ?>
                                                            <a title="<?php echo PREVIEW; ?>" id="card_<?php echo $row['media__ID']; ?>_preview" href="<?php echo ADMIN_URL; ?>media-update<?php echo PHP_EXTENSION; ?>/<?php echo $row['media__ID']; ?>/preview/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-eye"></i></a>

                                                        <?php } ?>


                                                        <!-- EDIT -->
                                                        <?php if ($editAccess == TRUE) { ?>
                                                            <a title="<?php echo EDIT; ?>" id="card_<?php echo $row['media__ID']; ?>_edit" href="<?php echo ADMIN_URL; ?>media-update<?php echo PHP_EXTENSION; ?>/<?php echo $row['media__ID']; ?>/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-edit"></i></a>

                                                        <?php } ?>
                                                        <!-- DUPLICATE -->
                                                        <?php if ($duplicateAccess == TRUE) { ?>
                                                            <a title="<?php echo DUPLICATE; ?>" id="card_<?php echo $row['media__ID']; ?>_duplicate" href="<?php echo ADMIN_URL; ?>media-update<?php echo PHP_EXTENSION; ?>/<?php echo $row['media__ID']; ?>/duplicate/?overlay=<?php echo $_GET['overlay']; ?>"><i class="fa fa-copy"></i></a>
                                                        <?php } ?>
                                                        <!-- DELETE -->
                                                        <?php if ($deleteAccess == TRUE) { ?>
                                                            <a title="<?php echo DELETE; ?>" id="card_<?php echo $row['media__ID']; ?>_del" onclick="return delById('card_<?php echo $row['media__ID']; ?>', '<?php echo CONFIRM_DELETE_RESTORE; ?>')" href="<?php echo ADMIN_URL; ?>media-remote<?php echo PHP_EXTENSION; ?>/delete/<?php echo $row['media__ID']; ?>/" target="remote"><i class="fa fa-times color-Crimson"></i></a>
                                                        <?php } ?>

                                                        <!-- RESTORE -->
                                                        <?php if ($restoreAccess == TRUE) { ?>
                                                            <a title="<?php echo RESTORE; ?>" id="card_<?php echo $row['media__ID']; ?>_restore" href="<?php echo ADMIN_URL; ?>media-remote<?php echo PHP_EXTENSION; ?>/restore/<?php echo $row['media__ID']; ?>/" target="remote" style="display:none"><i class="fa fa-undo"></i></a>
                                                        <?php } ?>


                                                    </td>
                                                <?php } ?>



                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <!-- /TABLE -->
                                <?php
                                $sqlP = "SELECT COUNT(media__ID) AS totalRecs $sqlFrom $where";
                                suPaginate($sqlP);
                                ?>
                                <?php if ($downloadAccessCSV == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/stream-csv/" class="btn btn-black pull-right"><i class="fa fa-download"></i> <?php echo DOWNLOAD_CSV; ?></a></p>
                                    <p>&nbsp;</p>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <?php if ($downloadAccessPDF == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo ADMIN_URL; ?>media<?php echo PHP_EXTENSION; ?>/stream-pdf/" class="btn btn-black pull-right"><i class="fa fa-download"></i> <?php echo DOWNLOAD_PDF; ?></a></p>
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