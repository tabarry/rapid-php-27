<!-- Javascript files -->
<!-- Bootstrap JS -->
<script src="<?php echo ADMIN_URL; ?>js/bootstrap.min.js"></script>
<!-- jQuery UI -->
<script src="<?php echo ADMIN_URL; ?>js/jquery-ui.min.js"></script>
<!-- jQuery slim scroll -->
<script src="<?php echo ADMIN_URL; ?>js/jquery.slimscroll.min.js"></script>
<!-- Data Tables JS -->
<script src="<?php echo ADMIN_URL; ?>js/jquery.dataTables.min.js"></script>	
<!-- Respond JS for IE8 -->
<script src="<?php echo ADMIN_URL; ?>js/respond.min.js"></script>
<!-- HTML5 Support for IE -->
<script src="<?php echo ADMIN_URL; ?>js/html5shiv.js"></script>
<!-- Sulata JS -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>sulata/js/sulata.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>sulata/js/this-site.js"></script>
<!-- JQUI -->
<script src="<?php echo BASE_URL; ?>sulata/jquery-ui/js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
<!-- CK Editor -->
<script src="<?php echo BASE_URL; ?>sulata/ckeditor/ckeditor.js"></script>
<!-- Pretty Photo -->
<script src="<?php echo BASE_URL; ?>sulata/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<!-- Javascript for this page -->
<?php if ($sortable == TRUE) { ?>
    <script src="<?php echo BASE_URL; ?>sulata/jquery-ui/js/jquery-ui-1.12.1.js" type="text/javascript"></script>
    <script>
        $(function () {
            if ($("#sortable")) {
                $("#sortable").sortable();
                $("#sortable").disableSelection();
            }
        });
    </script>
<?php } ?>
