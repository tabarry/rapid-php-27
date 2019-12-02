<?php if ($_GET['overlay'] != 'yes') { ?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 heading">
        <h1>
            <a href="<?php echo ADMIN_URL; ?>">
                <?php
                if ((isset($_SESSION[SESSION_PREFIX . 'user__Picture']) && $_SESSION[SESSION_PREFIX . 'user__Picture'] != '') && (file_exists(ADMIN_UPLOAD_PATH . $_SESSION[SESSION_PREFIX . 'user__Picture']))) {
                    $userImage = BASE_URL . 'files/' . $_SESSION[SESSION_PREFIX . 'user__Picture'];
                } else {
                    $userImage = BASE_URL . 'files/default-user.png';
                }
                ?>
                <?php if ($getSettings['module_position'] != 'Sidebar') { ?>
                    <img src="<?php echo $userImage; ?>" alt="" class="img-responsive img-circle profile-image"/>
                <?php } ?>
                <?php echo $getSettings['site_name']; ?></a>
            <small><?php echo $getSettings['site_tagline']; ?></small>
        </h1>
    </div>

<?php } ?>
<!-- Top Navbar Ends -->