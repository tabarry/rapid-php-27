<?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') { ?>
    <div class="head-user dropdown pull-right">
        <!-- Icon
        <i class="fa fa-user"></i>  -->
        <?php
        if ($getSettings['module_position'] == 'Sidebar') {
            if ((isset($_SESSION[SESSION_PREFIX . 'user__Picture']) && $_SESSION[SESSION_PREFIX . 'user__Picture'] != '') && (file_exists(ADMIN_UPLOAD_PATH . $_SESSION[SESSION_PREFIX . 'user__Picture']))) {
                $userImage = BASE_URL . 'files/' . $_SESSION[SESSION_PREFIX . 'user__Picture'];
            } else {
                $userImage = BASE_URL . 'files/default-user.png';
            }
            ?>

            <img src="<?php echo $userImage; ?>" alt="" class="img-responsive img-circle"/>
        <?php } ?>
        <!-- User name -->
        <?php echo $_SESSION[SESSION_PREFIX . 'user__Name']; ?>        
    </div>
<?php } ?>
