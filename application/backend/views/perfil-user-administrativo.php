<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/fileupload/fileupload.css'); ?>">

<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="push-10-t push-15 clearfix">
        <div class="push-15-r pull-left animated fadeIn">
        	<img id="img-avatar-user" class="img-avatar img-avatar-thumb" src="<?= assets_url($this->session->userdata['user-adm']['txtPathAvatar']); ?>" alt="Avatar">
        </div>
        <h1 class="h2 text-white push-5-t animated zoomIn"><?= $this->session->userdata['user-adm']['txtNome']; ?></h1>
        <h2 class="h5 text-white-op animated zoomIn"><?= $this->session->userdata['user-adm']['txtTituloGroupAccess']; ?></h2>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
    <p>Nesta área você pode configurar seu administrativo da maneira que desejar, clique em cada um dos itens para poder ver um exemplo e habilitar ou desabilitar o que deseja.</p>
    <div class="row">
		<div class="col-lg-4 col-sm-4">
            <!-- Material Login -->
            <div class="block block-themed" id="bloco-password">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Alterar a senha</h3>
                </div>
                <div class="block-content">
                    <?php
		                echo form_open('user/alter-password-user/json', array('class'=>'js-alter-password form-horizontal push-10-t','id'=>'formPassword','method'=>'post'));
		                    echo form_hidden(array('idUser' => $this->session->userdata['user-adm']['id']));
		            ?>
                        <div class="form-group">
                            <label class="col-xs-12">Senha</label>
                            <div class="col-xs-12">
                                <?php echo form_input(array('name'=> 'txtSenha', 'id'=>'txtSenha', 'class'=>'form-control', 'type'=>'password', 'autocomplete' => 'off', 'placeholder'=>'Digite a sua senha ..')); ?>
                           	</div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12">Confirme a senha</label>
                            <div class="col-xs-12">
                            	<input type="password" name="txtConfirmaSenha" id="txtConfirmaSenha" class="form-control" required="required" maxlength="14" autocomplete="off" data-rules='{"equalTo":"#txtSenha"}' placeholder=".. Confirme a senha">
                           	</div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-primary" type="submit" name="btnAlterarPass"><i class="fa fa-arrow-right push-5-r"></i> Salvar</button>
                            </div>
                        </div>
                    <?= form_close(); ?>
                </div>
            </div>
            <!-- END Material Login -->
        </div>
        <div class="col-sm-4 col-lg-4">
        	<div class="block block-themed">
        		<div class="block-header bg-primary-dark">
                    <h3 class="block-title">Alterar Avatar</h3>
                </div>
				<?php
				echo form_open('files/upload-foto-user-admin', array('class'=>'','id'=>'formFoto','method'=>'post'));
					echo form_hidden('txtAvatarAnterior', $this->session->userdata['user-adm']['txtPathAvatar']);
				?>
		            <a class="block block-themed block-bordered" href="javascript:void(0)" data-provides="fileupload" id="bloco-avatar">
		                <div class="block-content block-content-full text-center" style="border: none">
		                    <img id="img-upload" class="img-avatar img-avatar96 img-avatar-thumb" src="<?= assets_url($this->session->userdata['user-adm']['txtPathAvatar']); ?>" alt="">
		                </div>
		                <div class="block-content block-content-full text-center" style="padding-bottom: 0;">
		                	<div class="form-group" style="padding-bottom: 0;">
								<span class="btn btn-file font-w600"> 
									<!-- <span>Escolher nova imagem</span> -->
									<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Escolher nova imagem</button>
									<input type="file" name="userfile" id="userFileFoto">
								</span>
							</div>
		                </div>
		            </a>
		        <?php
				echo form_close();
				?>
        	</div>
        </div>
	</div>
</div>
<!-- END Page Content -->

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/template_footer_start'); 
?>

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>

<!-- Page JS Code -->
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>


<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/fileupload/fileupload.js'); ?>"></script>

<script type="text/javascript">
	$('#userFileFoto').change(function(){
		App.blocks('#bloco-avatar', 'state_loading');
		var $formFoto = $('#formFoto');
		$formFoto.ajaxSubmit({
			dataType : "json",
			type : 'post',
			success : function(json) {
				$('#img-upload').attr('src', json.retorno[0]['path']);
				$('#img-avatar-user').attr('src', json.retorno[0]['path']);
				$('.btn-image img').attr('src', json.retorno[0]['path']);
				$('input[name="txtAvatarAnterior"]').val('img/avatars/'+json.retorno[0]['name']);
				setTimeout(function(){
					App.blocks('#bloco-avatar', 'state_normal');
				}, 1000);
			},
			error : function(e) {
				$('#mensagens').alert({msg: e});
			}
		});
		setTimeout(function(){
			$('#mensagemHabilidade').hide(500);
		}, 2000)
		return false;
	})

	$(document).ready(function(){
		$('[name="btnAlterarPass"]').click(function(){
			var $formPassword = $('#formPassword');
			$formPassword.data('validator').settings.submitHandler = function() {
				App.blocks('#bloco-password', 'state_loading');
				$formPassword.ajaxSubmit({
					dataType : "json",
					type : 'post',
					url : $formPassword.action,
					success: function(json){
						$(this).notify_notie(json);
						App.blocks('#bloco-password', 'state_normal');
						$("#formPassword")[0].reset()
					},
					erro: function(e){
						$(this).notify_notie({msg: e, type: 'danger'});
					}
				});
				return false;
			}
		});
	})
</script>
</body>
</html>




