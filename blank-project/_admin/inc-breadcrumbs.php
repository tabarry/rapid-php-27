<?php if ($_GET['overlay'] != 'yes') { ?>
    <div class="breads">
        <?php if (($pageName == 'Home') || ($pageTitle == 'Dashboard')) { ?>
            <a href="<?php echo ADMIN_URL; ?>"><i class="fa fa-home color-Crimson"></i> Home</a>
            <?php
        } else {
            if (PHP_EXTENSION == '') {
                $selfLink = current(explode('.', $_SERVER['PHP_SELF'])) . '/';
            } else {
                $selfLink = $_SERVER['PHP_SELF'] . '/';
            }
            $selfLink = str_replace('//', '/', $selfLink);
            ?>
            <a href="<?php echo ADMIN_URL; ?>"><i class="fa fa-home color-Crimson"></i> Home</a> / <a href="<?php echo $selfLink; ?>"><?php echo $pageName; ?></a>
        <?php } ?>
    </div>
<?php } ?>