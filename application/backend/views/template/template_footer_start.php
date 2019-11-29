<?php
/**
 * template_footer_start.php
 *
 * Author: Zarpou JRJ
 *
 * All vital JS scripts are included here
 *
 */
?>

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie, Notify, Custom Zarpou and App.js -->
<script src="<?php echo assets_url('js/core/jquery.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/plugins/jquery-ui-1.11.4/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/bootstrap.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.form.mim.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.scrollLock.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.appear.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.countTo.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/jquery.placeholder.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/core/js.cookie.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/plugins/notie/notie.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/custom-Zarpou.js'); ?>"></script>
<script src="<?php echo assets_url('js/app.js'); ?>"></script>

<script type="text/javascript">
	$("#txtSearch").autocomplete({
		change: function (event, ui) {
			$(this).val('');
            $('#txtSearch').val('');
        },
		minLength: 3,
    	source: "/admin/client/get-search/",
    	select: function(event, ui){
    		window.location.href = '/admin/client/perfil/'+ui.item.idCriptografado;
    	}
  	});
</script>
