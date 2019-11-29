<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading">
                Administração dos Grupos de Acesso <small>Alteração dos direitos de acesso a cada grupo.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Grid Row -->
    <div class="row">
    	<?php
		$arrayGroup = '';
		foreach ($grupos as $key => $grupo):
		?>
	        <div class="col-sm-4 col-lg-4">
	            <!-- Group Access Menu -->
	            <div class="block block-themed" id="bloco_<?= $grupo->id; ?>">
	                <div class="block-header bg-primary-dark">
	                	<ul class="block-options">
							<li><button type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button></li>
							<li><button type="button" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button></li>
						</ul>
	                    <h3 class="block-title"><?= $grupo->txtTituloGroupAccess; ?></h3>
	                </div>
	                <div class="block-content">
	                    <?php
                		echo form_open('user/alter-group-access', array('class'=>'form-horizontal','name'=>'formAlteracao','method'=>'post', 'data-grupo'=>'bloco_' . $grupo->id));
    			 			echo form_hidden(array('id' => $grupo->id));
    			 			echo form_hidden(array('txtRandonNumber' => $grupo->txtRandonNumber));
                			echo $this->template->layout_admin_group_access(0, $sub_menu, 0, $grupo->id, $grupo->txtMenuAccess, $grupo->txtPermissaoGroupAccess[0]);
                		?>
                		<div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-primary" name="btnSalvar" data-grupo='bloco_'<?= $grupo->id; ?> type="submit">Salvar</button>
                            </div>
                        </div>
						<?php
						echo form_close();
						?>
	                </div>
	            </div>
	            <!-- END Group Access Menu -->
	        </div>
		<?php
		endforeach;
		?>
    </div>
    <!-- END Grid Row -->
</div>
<!-- END Page Content -->

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/template_footer_start'); 
?>

<script type="text/javascript" src="<?php echo assets_url('js/plugins/jquerychecktree/jquery.checktree.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		var arrayGroup = '<?= $idGrupoConcatenado; ?>';
		arrayGroup = arrayGroup.split('||');
		for (var i = 0; i <= arrayGroup.length; i++) {
			$('#menuItem_'+arrayGroup[i]).checktree();
		};

		$('[name="formAlteracao"]').submit(function(){
			App.blocks('#'+$(this).data('grupo'), 'state_loading');
			var obj = $(this).serialize();
			$(this).ajaxSubmit({
				type: 'post',
				async : true,
				data: obj,
				success: function(retorno){
					window.location.href = '/admin/user/list-group';
				},
				error: function(e){
					$(this).notify_user({msg: e, type: 'danger'});
				}
			});
			return false;
		});
	});
</script>
	
</body>
</html>







