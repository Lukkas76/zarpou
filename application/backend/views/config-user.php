<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Administração de Usuários <small>Cadastro ou alteração dos dados do usuário.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Forms Row -->
    <!-- Material Forms Validation -->
    <div class="block block-themed" id="bloco-user">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title"><?= $breadcrumb; ?></h3>
        </div>
        <div class="block-content">
            <?php
				echo form_open($action, array('class'=>'form-horizontal push-10-t','id'=>'form_usuario','method'=>'post'));
					echo form_hidden(array('id' => encode($usuario[0]->id)));
			?>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Nome completo</label>
                    <div class="col-sm-7 col-xs-12">
                    	<?php echo form_input(array('name'=> 'txtNome', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'placeholder'=>'Informe seu nome completo ...', 'value'=>$usuario[0]->txtNome)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Login</label>
                    <div class="col-sm-5">
                    	<?php echo form_input(array('name'=> 'txtLogin', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required','placeholder'=>'Crie um login ...', 'value'=>$usuario[0]->txtLogin)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Email</label>
                    <div class="col-sm-7">
                    	<?php echo form_input(array('name'=> 'txtEmail', 'class'=>'form-control', 'type'=>'email', 'autocomplete' => 'off', 'required'=>'required','placeholder'=>'Informe um email válido ...', 'value'=>$usuario[0]->txtEmail)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Grupo de Acesso</label>
                    <div class="col-sm-5">
                    	<?php
                    		if($usuario[0]->bitVisivel == 1){
								$options = array(NULL => 'Grupo de acesso');
								foreach($group_access as $ga):
									$options[$ga->id] = $ga->txtTituloGroupAccess;
								endforeach;
								echo form_dropdown('idGroupAccess', $options, $usuario[0]->idGroupAccess, 'class="form-control"');
                    		}
                    		else{
                    			echo form_input(array('name'=> 'idGroupAccess', 'class'=>'form-control', 'type'=>'text', 'required'=>'required', 'value'=>$usuario[0]->txtTituloGroupAccess));
                    		}
						?>
                    </div>
                </div>
                <?php
                if($action == 'user/new-user'):
                ?>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label">Senha</label>
                        <div class="col-sm-4">
                        	<?php echo form_input(array('name'=> 'txtSenha', 'id'=>'txtSenha', 'class'=>'form-control', 'type'=>'password', 'required'=>'required', 'autocomplete' => 'off', 'placeholder'=>'Digite a sua senha ..')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-12 control-label">Confirme a senha</label>
                    	<div class="col-sm-4">
                    		<input type="password" name="txtConfirmaSenha" id="txtConfirmaSenha" class="form-control" required="required" maxlength="14" autocomplete="off" data-rules='{"equalTo":"#txtSenha"}' placeholder=".. Confirme a senha">
                        </div>
                    </div>
				<?php
				endif;
				?>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-primary" type="submit">Gravar</button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
    <!-- END Material Forms Validation -->
    <!-- END Forms Row -->
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

<script type="text/javascript">
	$(document).ready(function(){
		var $form_usuario = $('#form_usuario');
		$form_usuario.data('validator').settings.submitHandler = function() {
            App.blocks('#bloco-user', 'state_loading');
			$form_usuario.ajaxSubmit({
				dataType : "json",
				type : 'post',
				url : $form_usuario.action,
				success: function(json){
					if(json.validate){
						window.location.href = "/admin/user/list-all-users";
					}
					else{
                        $(this).notify_notie(json);
                        App.blocks('#bloco-user', 'state_normal');
					}
				},
				erro: function(e){
					$(this).notify_user({msg: e, type: 'danger'});
				}
			})
		};
		return false;
  	})
</script>
	
	</body>
</html>







