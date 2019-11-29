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
                Administração de Imóveis <small>Cadastro ou alteração dos dados.</small>
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
			echo form_open($action, array('class'=>'form-horizontal push-10-t','id'=>'form_produto','method'=>'post'));
				echo form_hidden(array('id' => encode($produto[0]->id)));
			?>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Nome do imóvel</label>
                    <div class="col-sm-8 col-xs-12">
                    	<?php echo form_input(array('name'=> 'txtTituloImovel', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'value'=>$produto[0]->txtTituloImovel)); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-12 control-label">Tipo do Imóvel</label>
                    <div class="col-sm-3 col-xs-12">
                    	<?php
							$options = array(NULL => 'Tipo de imóvel');
							foreach($tipo_produtos as $tpp):
								$options[$tpp->id] = $tpp->txtTipoProduto;
							endforeach;
							echo form_dropdown('idTipoProduto', $options, $produto[0]->idTipoProduto, 'class="form-control" required="required"');
						?>
                    </div>
                </div>
				<div class="form-group">
                	<label class="col-sm-3 col-xs-6 control-label">Bairro</label>
                    <div class="col-sm-2 col-xs-6">
                    	<?php echo form_input(array('name'=> 'txtBairro', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'value'=>$produto[0]->txtBairro)); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-6 control-label">Estado</label>
                    <div class="col-sm-2 col-xs-6">
                    	<?php echo form_input(array('name'=> 'txtEstado', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'value'=>$produto[0]->txtEstado)); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-6 control-label">Metragem Privada</label>
                    <div class="col-sm-2 col-xs-6">
                    	<?php echo form_input(array('name'=> 'txtMetragemPrivada', 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'ex: 125 a 170M²', 'autocomplete' => 'off', 'required'=>'required', 'value'=>$produto[0]->txtMetragemPrivada)); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-6 control-label">Data de Lançamento</label>
                    <div class="col-sm-2 col-xs-6">
                    	<?php echo form_input(array('name'=> 'datLancamento', 'class'=>'form-control js-datepicker js-masked-date', 'data-date-format'=>'dd/mm/yyyy', 'type'=>'text', 'placeholder'=>'.. mes e ano', 'autocomplete' => 'off', 'value'=>formataData($produto[0]->datLancamento))); ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 col-xs-6 control-label">Data de Entrega</label>
                    <div class="col-sm-2 col-xs-6">
                    	<?php echo form_input(array('name'=> 'datEntrega', 'class'=>'form-control js-datepicker js-masked-date', 'data-date-format'=>'dd/mm/yyyy', 'type'=>'text', 'placeholder'=>'.. mes e ano', 'autocomplete' => 'off', 'value'=>formataData($produto[0]->datEntrega))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-6 control-label">Latitude</label>
                    <div class="col-sm-2 col-xs-6">
                        <?php echo form_input(array('name'=> 'txtLatitude', 'class'=>'js-maxlength form-control', 'maxlength'=>"10", 'type'=>'text', 'placeholder'=>'..ex: -23.549216', 'autocomplete' => 'off', 'data-placement'=>"right", 'data-warning-class'=>"label label-primary",'value'=>$produto[0]->txtLatitude)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-6 control-label">Longitude</label>
                    <div class="col-sm-2 col-xs-6">
                        <?php echo form_input(array('name'=> 'txtLongitude', 'class'=>'js-maxlength form-control', 'maxlength'=>"10", 'type'=>'text', 'placeholder'=>'..ex: -46.610388', 'autocomplete' => 'off',  'data-placement'=>"right",'data-warning-class'=>"label label-primary", 'value'=>$produto[0]->txtLongitude)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Descrição</label>
                    <div class="col-sm-8">
                    	<?php echo form_textarea(array('name'=>'txtDescricaoImovel', 'class'=>'form-control js-summernote', 'type'=>'textarea', 'rows'=>"6", 'autocomplete' => 'off', 'required'=>"required", 'data-placement'=>"right", 'value'=>$produto[0]->txtDescricaoImovel)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Campo de Livre Digitação</label>
                    <div class="col-sm-8">
                        <?php echo form_textarea(array('name'=>'txtCampoLivre', 'class'=>'form-control', 'type'=>'textarea', 'rows'=>"6", 'autocomplete' => 'off', 'data-placement'=>"right", 'value'=>$produto[0]->txtCampoLivre)); ?>
                    </div>
                </div>
                <div class="col-sm-offset-3 col-xs-9">
                	<h3 class="push">Configurações SEO</h3>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">URL do produto</label>
                    <div class="col-sm-8 col-xs-12">
                        <?php echo form_input(array('name'=> 'txtUrlAmigavel', 'class'=>'js-maxlength form-control', 'maxlength'=>"255",'data-always-show'=>"true", 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'data-placement'=>"right",'data-warning-class'=>"label label-primary", 'value'=>$produto[0]->txtUrlAmigavel)); ?>
                    </div>
                </div>
             	<div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label">Description SEO</label>
                    <div class="col-sm-8 col-xs-12">
                        <?php echo form_input(array('name'=> 'txtDescriptionSeo', 'class'=>'js-maxlength form-control','maxlength'=>"255", 'data-always-show'=>"true", 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required', 'data-placement'=>"right",'data-warning-class'=>"label label-primary", 'value'=>$produto[0]->txtDescriptionSeo)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 text-center">
                    	<a href="<?= base_url('produto/list-produtos'); ?>" class="btn btn-danger" alt="Cancelar" title="Cancelar">Cancelar</a>
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

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js');?>"></script>
<script src="<?php echo assets_url('js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js');?>"></script>

<script type="text/javascript" src="<?php echo assets_url('js/plugins/summernote/summernote.js'); ?>"></script>

<!-- Page JS Code -->
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>

<script type="text/javascript">

	$(document).ready(function(){

        App.initHelpers(['maxlength', 'datepicker','summernote']);
		//Função para não permitir caracteres especiais
        function er_replace( pattern, replacement, subject ){
			return subject.replace( pattern, replacement );
		}
        $('[name="txtUrlAmigavel"]').keyup(function(){
			var $this = $(this);
			$this.val( er_replace( /[^A-Za-z0-9-]/,'', $this.val() ) );
		});

		$("input[name='txtTituloProduto']").blur(function(){
            var url = tiracento( $(this).val());
            $("input[name='txtUrlAmigavel']").val(url.toLowerCase());
        });
		
		$(document).on('change', '[name="idTipoProduto"]', function(){
			if($(this).val() == 1){
				$('#produto_assinatura').show(100);
				$('[name="idTipoAssinatura"]').attr('required', 'requerid');
			}
			else{
				$('#produto_assinatura').hide(100);
				$('[name="idTipoAssinatura"]').removeAttr('required');
			}
		})

		var $form_produto = $('#form_produto');
		$form_produto.data('validator').settings.submitHandler = function() {
            App.blocks('#bloco-form', 'state_loading');
			$form_produto.ajaxSubmit({
				dataType : "json",
				type : 'post',
				url : $form_produto.action,
				success: function(json){
					if(json.validate){
						window.location.href = "/admin/produto/list-produtos";
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







