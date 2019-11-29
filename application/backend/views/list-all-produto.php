<link rel="stylesheet" href="<?php echo assets_url('js/plugins/fileupload/fileupload.css'); ?>">
<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">Listagem de Planos</h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content" id="mensagens">
    <!-- Partial Table -->
    <div class="row">
	    <div class="block block-themed">
	        <div class="block-header bg-primary-dark">
	        	<div class="block-options-simple">
                    <!-- <a href="<?= base_url('produto/action-produto'); ?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Adicionar</a> -->
                    <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </div>
                <h3 class="block-title font-w400 text-white">Planos registrados no sistema</h3>
	        </div>
	        <div class="block-content">
	            <table class="table table-striped table-vcenter table-bordered table-hover">
	                <thead>
	                    <tr class="text-white bg-primary-dark">
	                    	<!-- <th width="15%" class="font-s12 text-center">Tipo de Imóvel</th>
	                    	<th width="15%" class="font-s12 text-center">Imóvel</th>
							<th width="12%" class="hidden-xs font-s12 text-center">Endereço</th>
							<th width="10%" class="hidden-xs font-s12 text-center">MEtragem Privada</th> -->
<!-- 							<th width="7%"  class="hidden-xs font-s12 text-center">Status</th> -->
							<!-- <th width="10%"  class="hidden-xs font-s12 text-center">Ações</th> -->
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
	                    foreach ($produtos as $key => $prod):
	                    ?>
	                		<tr data-obj="listaProduto#<?= $prod->id ?>">
	                			<!-- <td class="font-s12 text-center"><b><?= $prod->txtTipoProduto; ?><b></td> -->
	                			<!-- <td class="font-s12" id="documento<?=$prod->id?>"><strong><?= $prod->txtTituloImovel; ?></strong><br> <a href="<?=$prod->txtPathDocumento?>"  id="documento_link<?=$prod->id?>" class="text-info" target="_blank"><?=substr($prod->txtPathDocumento,18);?></a></td> -->
	                			<!-- <td class="hidden-xs font-s12 text-center"><strong>Bairro:</strong> <?= $prod->txtBairro; ?> <br> <strong>Estado: </strong> <?=$prod->txtEstado;?></td> -->
	                			<!-- <td class="hidden-xs font-s12 text-center"><?= $prod->txtMetragemPrivada; ?></td> -->
	                			<!-- <td class="hidden-xs font-s12 text-center"><?= $this->template->get_label($prod->bitAtivo); ?></td> -->
	                			<!-- <td class="hidden-xs font-s12 text-center">
	                				<?php
                                        echo form_open_multipart('/produto/file-upload',array('method'=>'post','id'=>'formPdf_'.$prod->id));
                                            echo form_hidden(array('id'=>$prod->id));
                                    ?>
		                				<div class="btn-group">
		                					<a href="<?= base_url('produto/action-produto/' . encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Editar" data-original-title="Editar Imóvel"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Imóvel" data-remove-imovel="obj">
                                                <i class="fa fa-times"></i>
                                            </a>
			                            	<a href="<?php echo base_url('files/list-image/'.$prod->id . '-Produto/'.$prod->txtUrlAmigavel); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Imagens do produto">
			                            		<i class="si si-camera"></i>
			                            	</a>
	                            	        <a  href="#" data-toggle="tooltip" class="btn btn-xs btn-file btn-default" id="pdf_<?=$prod->id;?>" title="Inserir PDF">
	                                            <i class="fa fa-file-pdf-o"></i><input type="file" name="userfile" data-formulario="<?= $prod->id; ?>">
	                                        </a>
                                            <?php if($prod->txtPathDocumento != ''):?>
                                                <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Remover PDF" data-remove="obj">
                                                    <i class="si si-trash"></i>
                                                </a>
                                            <?php endif;?>
	                                        <a href="<?php echo base_url('files/list-image/'.$prod->id . '-Planta/'.$prod->txtUrlAmigavel); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Plantas">
			                            		<i class="fa fa-image"></i>
			                            	</a>
			                            	<a href="<?= base_url('produto/list-diferencial-imovel/' . encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Diferenciais">
			                            		<i class="si si-info"></i>
			                            	</a>
			                            	<a href="<?= base_url('produto/list-obra-imovel/' . encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Status da Obra">
			                            		<i class="glyphicon glyphicon-equalizer"></i>
			                            	</a>
			                            	<a href="<?= base_url('produto/list-all-especificacoes/' . encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Proximidades">
			                            		<i class="si si-direction"></i>
			                            	</a>
                                            <a href="<?=base_url('produto/imoveis-relacionados/'. encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Outros Empreendimentos">
                                                <i class="si si-grid"></i>
                                            </a>
                                            <a href="<?=base_url('ficha/list-ficha/'. encode($prod->id)); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Ficha Técnica">
                                                <i class="si si-folder"></i>
                                            </a>
		                				</div>
		                			<?php echo form_close();?>
	                			</td> -->
	                		</tr>
	                    <?php
	                    endforeach;
	                    ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
    </div>
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->

<div id="dataSource" style="display: none !important;">
	<img alt="listaProduto" src="data:image/png;base64,<?= base64_encode(json_encode($produtos)); ?>" />
</div>

<?php 
	$this->template->showTemplate('template/base_footer');
	$this->template->showTemplate('template/alert_modal');
	$this->template->showTemplate('template/template_footer_start'); 
?>

<script type="text/javascript">

	$(document).ready(function(){
        $(document).on('click', '[data-remove-imovel]', function(){
            $('.modal-title').text('Excluir Imóvel');
            $('.excplication').text('Tem certeza que deseja excluir um imóvel do Sistema ?');
            $('#alert-modal').data('url', '/admin/produto/remove-imovel');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_imovel()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_imovel(){
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
    //insere o pdf
    $(document).on('change','[name="userfile"]',function(ev){
        ev.preventDefault();
        var campo = $(this).data('formulario');
        // $('#loading_action_'+campo).show(100);
        var $formPdf = $('#formPdf_'+campo);
        $formPdf.ajaxSubmit({
            dataType : "json",
            type : 'post',
            success : function(retorno) {
                $(this).notify_notie(retorno);
                document.getElementById("formPdf_"+campo).reset();
                $('#documento_link'+campo).remove();
                // $('#referencia_'+campo).after('<a class="btn btn-gradient btn-sm btn-orange fileinput-button" href="#" data-id="'+campo+'" id="pdf_'+campo+'" title="excluir pdf">'+
                //                                     '<span class="imoon imoon-file-pdf"></span>'+
                //                                 '</a>');
                $('#documento'+campo).append('<a href="<?=assets_url("documentos/'+retorno.file+'")?>" class="text-info" target="_blank">'+retorno.file+'</a>');
                location.reload();
            },
            error : function(e) {
                $(this).notify_user({msg: e, type: 'danger'});
            }
        });
        $('#loading_action_'+campo).hide(500);
        return false;
    });

    $(document).ready(function(){
        $(document).on('click', '[data-remove]', function(){
            $('.modal-title').text('Excluir Imóvel');
            $('.excplication').text('Tem certeza que deseja excluir um pdf deste Imóvel ?');
            $('#alert-modal').data('url', '/admin/produto/remove-pdf');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_pdf()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_pdf(){
        var $el = $('#alert-modal').data('el').closest(':obj');
        var $btn = $('#alert-modal').data('el');
        var obj = $el.data('obj');
        $('#alert-modal').ajaxSubmit({
            type: 'post',
            url: $('#alert-modal').data('url'),
            async : true,
            data: obj,
            success: function(json){
                $('#documento_link'+json.idImovel).remove();
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