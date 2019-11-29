<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/fileupload/fileupload.css'); ?>">

<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Administração das Informações de Contato <small>Cadastro ou alteração dos dados.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Forms Row -->
    <!-- Material Forms Validation -->
    <div class="block block-themed" id="bloco-form">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title">Nova Informação de Contato</h3>
        </div>
        <div class="block-content">
            <?php
				echo form_open($action, array('class'=>'form-horizontal push-10-t','id'=>'form_tipo_contato','method'=>'post'));
					echo form_hidden(array('id' => encode($tipo_contato[0]->id)));
					echo form_hidden('txtIconeContato', $tipo_contato[0]->txtIconeContato);
			?>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Informações dos Blocos de Contato</label>
                    <div class="col-sm-8 col-xs-12">
                    	<?php echo form_input(array('name'=> 'txtTitulo', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'value'=>$tipo_contato[0]->txtTitulo)); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Ícone</label>
                	<div class="col-sm-3 col-xs-12">
                		<a class="block block-themed" href="javascript:void(0)" data-provides="fileupload" id="bloco-avatar">
	                		<span class="btn btn-file font-w600 remove-padding"> 
								<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Escolher nova imagem</button>
								<input type="file" name="userfile" id="userFileFoto">
							</span>
						</a>
                	</div>
                	<div class="col-sm-4">
                		<img id="img-upload" class="img-avatar img-avatar32 img-avatar-thumb" src="<?= ($tipo_contato[0]->txtIconeContato != '') ? assets_url($tipo_contato[0]->txtIconeContato) : ''; ?>" alt="">
                	</div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                    	<a href="<?= base_url('contato/list-tipo-contato'); ?>" class="btn btn-danger" alt="Cancelar" title="Cancelar">Cancelar</a>
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

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/fileupload/fileupload.js'); ?>"></script>

<script type="text/javascript">
	$('#userFileFoto').change(function(){
		App.blocks('#bloco-form', 'state_loading');
		var $form_tipo_contato = $('#form_tipo_contato');
		$form_tipo_contato.ajaxSubmit({
			dataType : "json",
			type : 'post',
			url: '/admin/files/simple-file-upload',
			success : function(json) {
				$('[name="txtIconeContato"]').val('img/site/'+json[0]['name']);
				$('#img-upload').attr('src', json[0]['path']);
				setTimeout(function(){
					App.blocks('#bloco-form', 'state_normal');
				}, 1000);
			},
			error : function(e) {
				// $('#mensagens').alert({msg: e});
			}
		});
		setTimeout(function(){
			$('#mensagemHabilidade').hide(500);
		}, 2000)
		return false;
	})
	$(document).ready(function(){
		var $form_tipo_contato = $('#form_tipo_contato');
		$form_tipo_contato.data('validator').settings.submitHandler = function() {
            App.blocks('#bloco-form', 'state_loading');
			$form_tipo_contato.ajaxSubmit({
				dataType : "json",
				type : 'post',
				url : $form_tipo_contato.action,
				success: function(json){
					if(json.validate){
						window.location.href = "/admin/contato/list-tipo-contato";
					}
					else{
                        $(this).notify_notie(json);
                        App.blocks('#bloco-form', 'state_normal');
					}
				},
				erro: function(e){
					$(this).notify_user({msg: e, type: 'danger'});
					App.blocks('#bloco-form', 'state_normal');
				}
			})
		};
		return false;
  	})
</script>
	
</body>
</html>