<!-- Top modules menus -->
<?php if ($_GET['overlay'] != 'yes' && ($getSettings['module_position'] == 'Sidebar' || $getSettings['module_position'] == 'Both')) { ?>
    <div>
        <nav class="navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="visible-xs navbar-brand" href="#">&nbsp;</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') {
                            ?>
                            <h4>&nbsp;</h4>
                            <li>
                                <a href="<?php echo ADMIN_URL; ?>"><i class="fa fa-home"></i></a>
                            </li>
                            <li>
                                <a href="#" data-toggle="dropdown" id="sys-user"><i class="fa fa-user"></i> 
                                    <?php echo suGetIndex($_SESSION[SESSION_PREFIX . 'user__Name']); ?>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                                <!-- Dropdown -->
                                <ul class="dropdown-menu" aria-labelledby="sys-user">
                                    <li><a href="<?php echo ADMIN_URL; ?>notes<?php echo PHP_EXTENSION; ?>/"><i class="fa fa-edit"></i>  Free Notes</a></li>
                                    <li><a href="<?php echo ADMIN_URL; ?>themes<?php echo PHP_EXTENSION; ?>/"><i class="fa fa-images"></i>  Change Theme</a></li>
                                    <li><a href="<?php echo ADMIN_URL; ?>users-update<?php echo PHP_EXTENSION; ?>/"><i class="fa fa-user"></i>  Update Profile</a></li>
                                    <li><a href="<?php echo ADMIN_URL; ?>settings<?php echo PHP_EXTENSION; ?>/"><i class="fa fa-cogs"></i>  Change Settings</a></li>
                                    <li><a href="<?php echo ADMIN_URL; ?>login<?php echo PHP_EXTENSION; ?>/?do=logout" target="remote"><i class="fa fa-power-off"></i>  Log Out</a></li>

                                </ul>
                            </li>
                            <?php
                            $module_access = suGetModuleAccess();
                            $dir = suGetLinks();

                            $max_top_menu_links_count = 1;
                            $menu_count = 0;
                            $getSettings['maximum_top_menu_links'];
                            //$sidebarExclude comes from config.php
                            //get menu count
                            //If Public User
                            if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Public') {
                                foreach ($dir as $file) {
                                    if (((!in_array($file, $sidebarExclude))) && (in_array($file, $module_access))) {
                                        $menu_count = $menu_count + 1;
                                    }
                                }
                                //Build menus
                                foreach ($dir as $file) {
                                    if (((!in_array($file, $sidebarExclude)) ) && (in_array($file, $module_access))) {
                                        $dropdown_id = suSlugifyName($file);
                                        $fileNameActual = str_replace('.php', '', $file);
                                        $fileNameAdd = $fileNameActual . '-add';
                                        $fileName = str_replace('-', ' ', $fileNameActual);

                                        $fileNameShow = str_replace('_', ' ', $fileName);
                                        if (stristr($fileNameShow, 'faqs')) {
                                            $fileNameShow = 'FAQs';
                                        }
                                        $fileLink = str_replace('.php', PHP_EXTENSION . '/', $file);
                                        $addFileLink = $fileNameAdd . PHP_EXTENSION;
                                        ?>

                                        <li>
                                            <a href="<?php echo ADMIN_URL . $fileLink; ?>" data-toggle="dropdown" id="<?php echo $dropdown_id; ?>"><?php echo ucwords($fileNameShow); ?>
                                                <i class="fa fa-caret-down"></i>
                                            </a>
                                            <!-- Dropdown -->
                                            <ul class="dropdown-menu" aria-labelledby="<?php echo $dropdown_id; ?>">
                                                <li><a href="<?php echo ADMIN_URL . $addFileLink; ?>"><i class="fa fa-plus"></i>  Add <?php echo ucwords($fileNameShow); ?></a></li>
                                                <li><a href="<?php echo ADMIN_URL . $fileLink; ?>"><i class="fa fa-table"></i>  Manage <?php echo ucwords($fileNameShow); ?></a></li>
                                            </ul>

                                        </li>
                                        <?php
                                        $max_top_menu_links_count = $max_top_menu_links_count + 1;
                                        if (($max_top_menu_links_count - 1) == $getSettings['maximum_top_menu_links']) {
                                            break;
                                        }
                                    }
                                }
                            }
                            //==
                            //If Private User
                            if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Private') {
                                foreach ($dir as $file) {
                                    if (!in_array($file, $sidebarExclude)) {
                                        $menu_count = $menu_count + 1;
                                    }
                                }
                                //Build menus
                                foreach ($dir as $file) {
                                    if (!in_array($file, $sidebarExclude)) {
                                        $dropdown_id = suSlugifyName($file);
                                        $fileNameActual = str_replace('.php', '', $file);
                                        $fileNameAdd = $fileNameActual . '-add';
                                        $fileName = str_replace('-', ' ', $fileNameActual);

                                        $fileNameShow = str_replace('_', ' ', $fileName);
                                        if (stristr($fileNameShow, 'faqs')) {
                                            $fileNameShow = 'FAQs';
                                        }
                                        $fileLink = str_replace('.php', PHP_EXTENSION . '/', $file);
                                        $addFileLink = $fileNameAdd . PHP_EXTENSION;
                                        ?>

                                        <li>
                                            <a href="<?php echo ADMIN_URL . $fileLink; ?>" data-toggle="dropdown" id="<?php echo $dropdown_id; ?>"><?php echo ucwords($fileNameShow); ?>
                                                <i class="fa fa-caret-down"></i>
                                            </a>
                                            <!-- Dropdown -->
                                            <ul class="dropdown-menu" aria-labelledby="<?php echo $dropdown_id; ?>">
                                                <li><a href="<?php echo ADMIN_URL . $addFileLink; ?>"><i class="fa fa-plus"></i>  Add <?php echo ucwords($fileNameShow); ?></a></li>
                                                <li><a href="<?php echo ADMIN_URL . $fileLink; ?>"><i class="fa fa-table"></i>  Manage <?php echo ucwords($fileNameShow); ?></a></li>
                                            </ul>

                                        </li>
                                        <?php
                                        $max_top_menu_links_count = $max_top_menu_links_count + 1;
                                        if (($max_top_menu_links_count - 1) == $getSettings['maximum_top_menu_links']) {
                                            break;
                                        }
                                    }
                                }
                            }
                            //==
                            ?>

                            <?php
                        }
                        ?>
                        <?php if ($menu_count >= $getSettings['maximum_top_menu_links']) { ?>
                            <li><a href="<?php echo ADMIN_URL; ?>modules<?php echo PHP_EXTENSION; ?>/">More..</a></li>
                        <?php } ?>
                    </ul>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
<?php } ?>
<?php if ($getSettings['module_position'] == 'Sidebar') { ?>
    <!--//-->
    <!-- Breadcrumbs section -->
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6">
            <!-- Bread crumbs -->
            <?php include('inc-breadcrumbs.php'); ?>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <!-- Search block -->

        </div>

        <div class="col-md-3 col-sm-4 hidden-xs">
            <!-- Notifications -->
            <div class="head-noty text-center">

            </div>
            <div class="clearfix"></div>
        </div>


        <div class="col-md-3 hidden-sm hidden-xs">
            <!-- Head user -->

            <?php include('inc-header.php'); ?>
            <div class="clearfix"></div>
        </div>
    </div>	
    <!--//-->
<?php } ?>