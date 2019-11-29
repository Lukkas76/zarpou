<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Usuários registrados <small>Usuários com acesso a área administrativa do site.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Partial Table -->
    <div class="block block-themed">
        <div class="block-header bg-primary-dark">
			<ul class="block-options">
				<li><button type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button></li>
				<li><button type="button" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button></li>
			</ul>
            <h3 class="block-title">Usuários</h3>
        </div>
        <div class="block-content">
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th width="120px" class="text-center font-s12"><i class="si si-user"></i></th>
                        <th>Nome</th>
                        <th width="25%" class="hidden-xs font-s12">Email</th>
                        <th width= "15%" class="hidden-xs font-s12">Grupo</th>
                        <th width= "15%" class="hidden-xs hidden-sm font-s12">Status</th>
                        <th width= "100px" class="text-center font-s12">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($users as $key => $user):
                	?>
                    <tr data-obj="listaUsuarios#<?= $user->id ?>">
                        <td class="text-center">
                        	<img class="img-avatar img-avatar32" src="<?= assets_url($user->txtPathAvatar); ?>" alt="">
                        </td>
                        <td class="font-w600"><?= $user->txtNome; ?> <small>(<?= $user->txtLogin; ?>)</small></td>
                        <td class="hidden-xs"><?= $user->txtEmail; ?></td>
                        <td class="hidden-xs"><?= $user->txtTituloGroupAccess; ?></td>
                        <td class="hidden-xs hidden-sm">
                            <?php $this->template->get_label($user->bitAtivo); ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
	                            <?php
	                            if((int)$user->bitVisivel == 1 || (int)$user->id == (int)$this->session->userdata['user-adm']['id'] || (int)$this->session->userdata['user-adm']['idGroupAccess'] == 5):
	                            ?>
	                        		<?php
	                        		if(isset($permissao['editar'])):
                        			?>
		                            	<a href="<?= base_url('user/action/'. encode($user->id))?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Editar Usuário">
		                            		<i class="fa fa-pencil"></i>
		                            	</a>
									<?php
									endif;
									if(isset($permissao['excluir'])):
									?>
		                            	<a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Usuário" data-remove="obj"><i class="fa fa-times"></i></a>
									<?php
									endif;
									if(isset($permissao['alterar_senha'])):
									?>
		                                <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Alterar a senha" data-password="obj"><i class="fa fa-key"></i></a>
									<?php
		                            endif;
		                            ?>
								<?php
								endif;
								?>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->

<div id="dataSource" style="display: none !important;">
	<img alt="listaUsuarios" src="data:image/png;base64,<?= base64_encode(json_encode($users)); ?>" />
</div>

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/alert_modal');
    $this->template->showTemplate('template/modal_alter_password_administrativo');
	$this->template->showTemplate('template/template_footer_start'); 
?>

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>

<!-- Page JS Code -->
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>

<!-- END Pop In Modal -->
	<script type="text/javascript">
	$(document).ready(function(){
        $('[data-password]').click(function(ev){
        	ev.preventDefault();
            var obj = $(this).closest(':obj').data('obj');
            $('input[name="idUser"]').val(obj.id);
	        $("#modal-alter-password-administrativo").modal("show"); 
        })

		$('[name="btnAlterarPass"]').click(function(){
			var $formPassword = $('#formPassword');
			$formPassword.data('validator').settings.submitHandler = function() {
				App.blocks('#bloco-password', 'state_loading');
				$formPassword.ajaxSubmit({
					dataType : "json",
					type : 'post',
					url : $formPassword.action,
					success: function(json){
						$("#formPassword")[0].reset()
						App.blocks('#bloco-password', 'state_normal');
						jQuery('#modal-alter-password-administrativo').modal('hide');
						$(this).notify_notie(json);
					},
					erro: function(e){
						$(this).notify_notie({msg: e, type: 'danger'});
					}
				});
				return false;
			}
		});








        
		$('[data-remove]').click(function(){
			$('.modal-title').text('Excluir o usuário');
			$('.excplication').text('Ao realizar a exclusão do usuário o mesmo não terá mais acesso ao sistema.');
			$('#alert-modal').data('url', '/admin/user/remove-user');
			$('#alert-modal').data('el', $(this));
			$('.btn-action').attr('onclick' , 'excluir_user()');
			jQuery('#alert-modal').modal('show');
		})


        $('[name="btnGravar"]').click(function(){
            App.blocks('#bloco_alterar_senha', 'state_loading');
        })

	})
	// Função para poder excluir um registro do sistema
		function excluir_user(){
			var $el = $('#alert-modal').data('el').closest(':obj');
			var $btn = $('#alert-modal').data('el');
			var obj = $el.data('obj');
			$('#alert-modal').ajaxSubmit({
				type: 'post',
				url: $('#alert-modal').data('url'),
				async : true,
				data: obj,
				success: function(json){
					$el.slideUp(500, function(){
						$el.remove();
					});
					$(this).notify_notie(json);
				},
				error: function(e){
					$(this).notify_notie({msg: e, type: 'danger'});
				}
			});
		}
	</script>	
</body>
</html>













