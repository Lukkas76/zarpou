<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo assets_url('js/plugins/summernote/summernote.min.css'); ?>" />
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Administração de conteúdo na Home do site <small>Cadastro ou alteração dos dados.</small>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <div class="block block-themed" id="bloco-form">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title"><?= $breadcrumb; ?></h3>
        </div>
        <div class="block-content">
            <?php
			echo form_open($action, array('class'=>'form-horizontal push-10-t','id'=>'form_sobre','method'=>'post'));
				echo form_hidden(array('id' => $sobre[0]->id));
			?>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Título</label>
                    <div class="col-sm-8 col-xs-12">
                    	<?php echo form_input(array('name'=> 'txtTitulo', 'class'=>'js-maxlength form-control', 'type'=>'text', 'autocomplete' => 'off', 'maxlength'=>"45", 'data-always-show'=>"true", 'required'=>'required', 'data-placement'=>"right",'data-warning-class'=>"label label-primary", 'value'=>$sobre[0]->txtTitulo)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Descrição</label>
                    <div class="col-sm-8">
                    	<?php echo form_textarea(array('name'=>'txtDescricao', 'class'=>'form-control js-summernote', 'type'=>'textarea', 'rows'=>"6", 'autocomplete' => 'off', 'required'=>"required", 'data-placement'=>"right", 'value'=>$sobre[0]->txtDescricao)); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 text-center">
                    	<a href="<?= base_url('sobre/list-sobre'); ?>" class="btn btn-danger" alt="Cancelar" title="Cancelar">Cancelar</a>
                        <button class="btn btn-primary" type="submit">Gravar</button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/template_footer_start'); 
?>

<!-- Page JS Code -->
<script src="<?php echo assets_url('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js');?>"></script>
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>

<script type="text/javascript" src="<?php echo assets_url('js/plugins/summernote/summernote.js'); ?>"></script>

<script type="text/javascript">

	$(document).ready(function(){
        App.initHelpers(['maxlength', 'summernote']);
		var $form_sobre = $('#form_sobre');
		$form_sobre.data('validator').settings.submitHandler = function() {
            App.blocks('#bloco-form', 'state_loading');
			$form_sobre.ajaxSubmit({
				dataType : "json",
				type : 'post',
				url : $form_sobre.action,
				success: function(json){
					if(json.validate){
						window.location.href = "/admin/sobre/list-sobre";
					}
					else{
                        $(this).notify_notie(json);
                        App.blocks('#bloco-form', 'state_normal');
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







