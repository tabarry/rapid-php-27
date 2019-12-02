<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Sort FAQs';
$pageTitle = 'Sort FAQs';

$sortable = TRUE;
$getSettings['page_size'] = $getSettings['sorting_page_size'];
//Make select statement. The $SqlFrom is also used in $sqlP below.
$sqlSelect = "SELECT faq__ID,faq__Question ";
$sqlFrom = " FROM sulata_faqs WHERE faq__dbState='Live'";
$sql = $sqlSelect . $sqlFrom;
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

                                <!-- TABLE -->
                                <div class="container"><a href="<?php echo ADMIN_URL; ?>faqs<?php echo PHP_EXTENSION; ?>/?overlay=<?php echo $_GET['overlay']; ?>" class="btn btn-black pull-right"><i class="fa fa-table"></i></a></div>
                                <div class="clearfix"></div>

                                <form class="form-horizontal" action="<?php echo ADMIN_SUBMIT_URL; ?>faqs-remote<?php echo PHP_EXTENSION; ?>/sort/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >
                                    <ul id="sortable">

                                        <?php
                                        if (!$_GET['start']) {
                                            $_GET['start'] = 0;
                                        }
                                        if (!$_GET['sr']) {
                                            $sr = 0;
                                        } else {
                                            $sr = $_GET['sr'];
                                        }
                                        $sort = " ORDER BY faq__Sort_Order DESC ";
//Get records from database

                                        $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                        $result = suQuery($sql);
                                        $numRows = $result['num_rows'];
                                        foreach ($result['result'] as $row) {
                                            ?>
                                            <li class="ui-state-default">
                                                <sup><i class="fa fa-sort"></i></sup>
                                                <?php echo $sr = $sr + 1; ?>.
                                                <?php echo suUnstrip($row['faq__Question']); ?>
                                                <input type="hidden" name="faq__ID[]" value="<?php echo $row['faq__ID']; ?>"/>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                    <p>
                                        <?php
                                        $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                        echo suInput('input', $arg);
                                        ?>                              
                                    </p>
                                    <p>&nbsp;</p>
                                </form>
                                <!-- /TABLE -->
                                <?php
                                $sqlP = "SELECT COUNT(faq__ID) AS totalRecs $sqlFrom $where";
                                suPaginate($sqlP);
                                ?>


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