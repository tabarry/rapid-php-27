<?php if ($_GET['overlay'] != 'yes' && ($getSettings['module_position'] == 'Sidebar' || $getSettings['module_position'] == 'Both')) { ?>
    <div class="sidebar" id="side-outer-nav">
        <div class="sidey">
            <!-- Logo -->
            <!-- Sidebar navigation starts -->

            <!-- Responsive dropdown -->
            <div class="sidebar-dropdown"><a href="#" class="br-red"><i class="fa fa-bars"></i></a></div>

            <div class="side-nav">

                <div class="side-nav-block">
                    <!-- Sidebar heading -->
                    <!-- Sidebar links -->
                    <ul class="list-unstyled">
                        <?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] == '') { ?>
                            <li><a href="<?php echo ADMIN_URL; ?>login.php" class="btn sideLink"><i class="fa fa-key"></i> Log In</a></li>
                        <?php } ?>
                        <?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') { ?>
                            <li><a href="<?php echo ADMIN_URL; ?>" class="btn sideLinkReverse"><i class="fa fa-home"></i> Home</a></li>

                            <li><a href="<?php echo ADMIN_URL; ?>notes<?php echo PHP_EXTENSION; ?>/" class="btn sideLink"><i class="fa fa-edit"></i> Free Notes</a></li>
                            <li><a href="<?php echo ADMIN_URL; ?>themes<?php echo PHP_EXTENSION; ?>/" class="btn sideLink"><i class="fa fa-images"></i> Themes</a></li>
                            <li><a href="<?php echo ADMIN_URL; ?>users-update<?php echo PHP_EXTENSION; ?>/" class="btn sideLink"><i class="fa fa-user"></i> Update Profile</a></li>
                            <li><a href="<?php echo ADMIN_URL; ?>settings<?php echo PHP_EXTENSION; ?>/" class="btn sideLink"><i class="fa fa-cogs"></i> Settings</a></li>
                            <li><a href="<?php echo ADMIN_URL; ?>login<?php echo PHP_EXTENSION; ?>/?do=logout" target="remote" class="btn sideLinkReverse"><i class="fa fa-power-off"></i> Log Out</a></li>
                            <li class="divider"></li>
                        <?php } ?>
                        <?php
                        if ($getSettings['module_position'] == 'Sidebar' || $getSettings['module_position'] == 'Both') {
                            if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') {
                                ?>

                                <h4>&nbsp;</h4>

                                <?php
                                $module_access = suGetModuleAccess();
                                $dir = suGetLinks();
                                $max_side_menu_links_count = 1;
                                $menu_count = 0;
                                $getSettings['maximum_side_menu_links'];
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
                                            $fileNameActual = str_replace('.php', '', $file);
                                            $fileName = str_replace('-', ' ', $fileNameActual);

                                            $fileNameShow = str_replace('_', ' ', $fileName);
                                            if (stristr($fileNameShow, 'faqs')) {
                                                $fileNameShow = 'FAQs';
                                            }
                                            $fileLink = str_replace('.php', PHP_EXTENSION . '/', $file);
                                            ?>
                                            <li><a href="<?php echo ADMIN_URL . $fileLink; ?>" class="btn sideLink"><i class="fa fa-minus"></i> <?php echo ucwords($fileNameShow); ?></a></li>

                                            <?php
                                            $max_top_menu_links_count = $max_top_menu_links_count + 1;
                                            if ($max_top_menu_links_count == $getSettings['maximum_top_menu_links']) {
                                                break;
                                            }
                                        }
                                    }
                                }
                                //==
                                //If Private User
                                if ($_SESSION[SESSION_PREFIX . 'user__Type'] == 'Private') {

                                    foreach ($dir as $file) {
                                        if (((!in_array($file, $sidebarExclude)))) {
                                            $menu_count = $menu_count + 1;
                                        }
                                    }
                                    //Build menus
                                    foreach ($dir as $file) {
                                        if (((!in_array($file, $sidebarExclude)))) {
                                            $fileNameActual = str_replace('.php', '', $file);
                                            $fileName = str_replace('-', ' ', $fileNameActual);

                                            $fileNameShow = str_replace('_', ' ', $fileName);
                                            if (stristr($fileNameShow, 'faqs')) {
                                                $fileNameShow = 'FAQs';
                                            }
                                            $fileLink = str_replace('.php', PHP_EXTENSION . '/', $file);
                                            ?>
                                            <li><a href="<?php echo ADMIN_URL . $fileLink; ?>" class="btn sideLink"><i class="fa fa-minus"></i> <?php echo ucwords($fileNameShow); ?></a></li>

                                            <?php
                                            $max_top_menu_links_count = $max_top_menu_links_count + 1;
                                            if ($max_top_menu_links_count == $getSettings['maximum_top_menu_links']) {
                                                break;
                                            }
                                        }
                                    }
                                }
                                //==
                                ?>

                                <?php
                            }
                        }
                        ?>
                        <?php if ($menu_count >= $getSettings['maximum_side_menu_links']) { ?>
                            <li>&nbsp;</li>
                            <li><a href="<?php echo ADMIN_URL; ?>modules<?php echo PHP_EXTENSION; ?>/" class="btn sideLinkReverse"><i class="fa fa-ellipsis-h pull-right"></i></a></li>

                        <?php } ?>
                    </ul>
                </div>

            </div>

            <!-- Sidebar navigation ends -->

        </div>
    </div>
<?php } else { ?>
    <style>
        .mainbar{
            margin-left:0px;
        }
    </style>
<?php } ?>
