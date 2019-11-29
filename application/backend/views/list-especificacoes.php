<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/datatables/jquery.dataTables.min.css'); ?>">

<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Lugares Próximos <?=$nome[0]->txtTituloImovel?>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Partial Table -->
    <div class="row">
    	<div class="col-lg-12">
    		<div class="block block-themed">
		        <div class="block-header bg-primary-dark">
                    <div class="block-options-simple">
                        <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-xs btn-success"><i class="si si-action-undo"></i> Voltar</a>
                        <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    </div>
		            <h3 class="block-title">Proximidades</h3>
		        </div>
		        <div class="block-content">
		            <?php
						echo form_open('produto/new-especificacao', array('class'=>'js-validation-material form-horizontal push-10-t','id'=>'formEspec','method'=>'post'));
                            echo form_hidden('id', '');
                            echo form_hidden('idImovel', $idImovel);
					?>
	                        <div class="form-group">
	                            <div class="col-xs-12 col-sm-4">
                                    <label for="txtNome">Lugar</label>
                                	<?php echo form_input(array('name'=> 'txtLugarProximo', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'required'=>'required')); ?>
	                            </div>
	                            <div class="col-xs-12 col-sm-5">
                                    <label for="txtDescricao">Tipo de Lugar</label>
                                	<?php 
										$options = array(NULL => 'Selecione');
										foreach($tipo_produto as $tp):
											$options[$tp->id] = $tp->txtTipoProduto;
										endforeach;
										echo form_dropdown('idProximidades', $options, '', 'class="form-control" required="required"');
									?>
	                            </div>
			                    <div class="col-xs-12 col-sm-3">
			                        <button class="btn btn-primary push-20-t" type="submit">Gravar</button>
			                        <button class="btn btn-danger hidden-print push-20-t" type="reset" id="cancelar">Cancelar</button>
			                    </div>
	                        </div>
		            <?= form_close(); ?>
		        </div>
		    </div>
    	</div>
    	<?php
    	foreach ($tipo_produto as $key => $tp):
    	?>
	    	<div class="col-lg-4">
			    <div class="block block-themed">
			        <div class="block-header bg-primary-dark">
						<ul class="block-options">
							<li><button type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button></li>
							<li><button type="button" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button></li>
						</ul>
			            <h3 class="block-title"><?= $tp->txtTipoProduto; ?></h3>
			        </div>
			        <div class="block-content remove-padding">
			            <table class="table-header-bg table table-striped table-vcenter table-bordered font-s12">
			                <thead>
			                    <tr>
			                        <th>Especificação</th>
			                        <th class="text-center" style="width: 10%;">Ações</th>
			                    </tr>
			                </thead>
			                <tbody>
			                    <?php 
			                    foreach ($especificacoes as $key => $espec):
			                    	if($espec->idProximidades == $tp->id):
			                	?>
				                    <tr data-obj="listaEspecificacoes#<?= $espec->id ?>">
				                        <td class="font-w600"><?= $espec->txtLugarProximo; ?></td>
				                        <td class="text-center">
				                            <div class="btn-group">
				                            	<a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Editar Especificação" data-edit="obj" data-form="#formEspec">
				                            		<i class="fa fa-pencil"></i>
				                            	</a>
				                            	<a href="#" class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="" data-remove="<?=$espec->id?>" data-original-title="Remove proximidade">
	                                            	<i class="fa fa-times"></i>
	                                            </a>
				                            </div>
				                        </td>
				                    </tr>
			                    <?php 
			                    	endif;
			                    endforeach;
			                    ?>
			                </tbody>
			            </table>
			        </div>
			    </div>
	    	</div>
	    <?php
	    endforeach;
	    ?>
    </div>
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->

<div id="dataSource" style="display: none !important;">
	<img alt="listaEspecificacoes" src="data:image/png;base64,<?= base64_encode(json_encode($especificacoes)); ?>" />
</div>

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/alert_modal');
	$this->template->showTemplate('template/template_footer_start'); 
?>

<!-- Page JS Plugins -->

<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>


<!-- Page JS Code -->

<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '[data-edit]', function() {
			$('#cancelar').removeClass('hidden-print');
			$('#formEspec').removeAttr('action').attr('action','/admin/produto/alter-especificacao');
		});

		$(document).on('click', '#cancelar', function() {
			$('#cancelar').addClass('hidden-print');
			$('#formEspec').removeAttr('action').attr('action','/admin/produto/new-especificacao');
			$('#id').val('');
		});

		//abre modal para confirmação de exclusão da especificação
		$(document).on('click', '[data-remove]', function(){
			$('.modal-title').text('Excluir proximidade');
			$('.excplication').text('Deseja realmente excluir a proximidade deste imovel?');
			$('#alert-modal').data('url', '/admin/produto/remove-especificacao');
			$('#alert-modal').data('el', $(this));
			$('.btn-action').attr('onclick' , 'remove_especificacao()');
			jQuery('#alert-modal').modal('show');
		});
	});

	//remove um subitem
	function remove_especificacao(){
		var $el = $('#alert-modal').data('el').closest('tr');
		var $btn = $('#alert-modal').data('el');
		var obj = {};
		obj.idEspecificacao = $btn.data('remove');
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













