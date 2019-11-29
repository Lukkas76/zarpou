<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/magnific-popup/magnific-popup.min.css'); ?>">
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/dropzonejs/dropzone.min.css'); ?>">
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/xeditable/css/bootstrap-editable.css'); ?>"/>

<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white"><?= $name; ?></h1>
            <!-- <ul class="block-options">
                <li>
                    <button type="button"><i class="si si-settings"></i></button>
                </li>
            </ul> -->
            <!-- <a href="<?= $_SERVER['HTTP_REFERER']; ?>"> Voltar </a> -->
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
	<div class="row">
		<div class="col-xs-12 col-lg-8">
			<div class="block block-rounded">
				<div class="items-push js-gallery-advanced">
					<div class="block-header bg-primary-dark">
						<div class="block-options-simple">
                            <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-xs btn-success"><i class="si si-action-undo"></i> Voltar</a>
                        </div>
	                    <h3 class="block-title font-w400 text-white">Cadastrar Plantas <small class="text-white">(clique duas vezes na ordem ou no título para alterar os dados)</small></h3>
	            	</div>
			    	<div class="block-content">
				        <?php 
				        foreach ($arquivos as $key => $arq):
				    	?>
				    		<div id="<?= $arq->id; ?>">
						        <div class="col-sm-6 col-md-3 col-lg-2 animated fadeIn" id="<?= $arq->id; ?>">
						            <div class="img-container">
						            	<img class="img-responsive" src="<?= assets_url($arq->txtPath);?>" alt="">
						                <div class="img-options">
						                    <div class="img-options-content">
						                        <a class="btn btn-sm btn-default img-lightbox" href="<?= assets_url($arq->txtPath);?>">
						                            <i class="fa fa-search-plus"></i> Ver
						                        </a>
						                        <div class="btn-group btn-group-sm">
						                            <a class="btn btn-default" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" type="button" data-original-title="Excluir" data-remove="<?= $arq->id; ?>" data-image="<?= $arq->txtFileName; ?>" data-table="Media"><i class="fa fa-times"></i></a>
						                        </div>
						                    </div>
						                </div>
						            </div>
						        </div>
						        <div class="col-sm-6 col-md-8 col-lg-10">
						        	<table class="table remove-margin-b font-s12">
						        		<thead>
					                        <tr>
					                            <th class="font-s12 remove-padding-t">Ordem</th>
					                            <th class="font-s12 remove-padding-t">Título da imagem</th>
					                            <th class="font-s12 remove-padding-t">Tipo de Imagem</th>
					                        </tr>
					                    </thead>
					                    <tbody>
					                        <tr data-obj="listaImagens#<?= $arq->id ?>">
					                        	<td class="h5" style="width: 5%">
					                                <a href="#" id="intOrdenacao" data-table="Media" data-type="text" data-pk="<?=$arq->id?>" data-title="Ordenação da imagem" class="editable editable-click media link-effect"><?= ($arq->intOrdenacao == 999) ? 0 : $arq->intOrdenacao; ?></a>
					                            </td>
					                            <td class="h5">
					                                <a href="#" id="txtTitle" data-table="Media" data-type="text" data-pk="<?=$arq->id?>" data-title="Title da imagem" class="editable editable-click media link-effect"><?=$arq->txtTitle; ?></a>
					                            </td>
					                            <td class="h5" style="width: 25%">
													<a href="#" id="txtTipo" data-table="Media" data-type="select" data-pk="<?=$arq->id?>" data-title="Definir o tipo de imagem" data-source="<?=$plantas;?>"class="editable editable-click media link-effect"><?=$arq->txtTipo; ?></a>
					                            </td>
					                        </tr>
					                    </tbody>
					                </table>
						        </div>
						        <div class="col-xs-12"><hr></div>
						        <div class="clearfix"></div>
				    		</div>
				        <?php 
				        endforeach; 
				        ?>
				    </div>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 col-lg-4">
			<div class="block block-rounded" id="bloco-upload">
				<div class="block-header bg-primary-dark">
	                    <div class="font-w400 text-white">Carregar arquivos</div>
	            	</div>
				<div class="block-content">
					<?php $attributes = array('class' => 'dropzone  push-20', 'id' => 'mydropzone');
						echo form_open_multipart('files/do_upload', $attributes);
						echo form_hidden('txtReferencia', $referencia[0] . '-' . $referencia[1]);
						// echo form_hidden('txtAreaImagem', 'type-image');
						echo form_close();
					?>
				</div>
			</div>
		</div>
	</div>
    
    <!-- END Gallery -->
</div>
<!-- END Page Content -->

<div id="dataSource" style="display: none !important;">
    <img alt="listaImagens" src="data:image/png;base64,<?= base64_encode(json_encode($arquivos)); ?>" />
</div>

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/template_footer_start'); 
?>
	<!-- Page JS Plugins -->
	<script src="<?php echo assets_url('js/plugins/magnific-popup/magnific-popup.min.js'); ?>"></script>
	<script src="<?php echo assets_url('js/plugins/dropzonejs/dropzone.min.js'); ?>"></script>
	<script src="<?php echo assets_url('js/plugins/xeditable/js/bootstrap-editable.min.js'); ?>"></script>

	<script>
	    $(function(){
	        // Init page helpers (Magnific Popup plugin)
	        App.initHelpers('magnific-popup');
	    });
	    $('[data-remove]').click(function(){
	    	var obj = new (Object);
			obj.remove = $(this).data('remove');
			obj.image = $(this).data('image');
			obj.table = $(this).data('table');
			$(this).ajaxSubmit({
				type: 'post',
				url: '/admin/files/remove-reference',
				async : true,
				data: obj,
				success: function(json){
					$('#'+obj.remove).slideUp(500, function(){
						$('#'+obj.remove).remove();
					});
					$(this).notify_notie(json);
				},
				error: function(e){
					$(this).notify_notie({msg: e, type: 'danger'});
				}
			});
		});

		$(document).ready(function() {
			startDropzone();

			function startDropzone (){
				Dropzone.autoDiscover = false; //evita plugin carregar novamente
				var md = new Dropzone("#mydropzone", {
					maxFilesize: 256,
					dictDefaultMessage: "Clique aqui e carregue os arquivos para upload",
					dictResponseError: "Erro uploading arquivo!"
				});	
				md.on("processing", function(){
					App.blocks('#bloco-upload', 'state_loading');
				})

				md.on("complete", function (file) {
					if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
						setTimeout(function(){
							window.location.reload(); //recarrega a página depois de 1 segundo após upload do último arquivo
						}, 1000); 
					} 
				}); 
			}

			// Editi inline
			$(document).on('click', '.media', function(){
				var data = new Date;
				$('.media').editable({
					showbuttons: true,
					url : "/admin/files/alter-dados-media",
					inputclass: 'input-large',
					params: function(params) {
						params.table = $(this).data('table');
						return params;
					},
					error: function(response, newValue) {
						if(response.status === 500) {
							return response.responseText;
						} else {
							return response.responseText;
						}
					}
				});
			})

		});

	    $(document).ready(function(){
	        $('[data-destaque]').on('click', function(){
	        	 var $el = $(this).closest(':obj');
	            var $btn = $(this);
	            var obj = $el.data('obj');
	            var action = $(this).data('action');
	            obj.bitCapa = Number(!Number(obj.bitCapa));
	            console.log(obj);
	            $(this).ajaxSubmit({
	                type: 'post',
	                url: action,
	                async : true,
	                data: obj,
	                success: function(json){
	                    if(Number(json.bitCapa == 0)){
	                        $('.fa-bookmark', $el).removeClass('fa-bookmark').addClass('fa-bookmark-o');
	                    }else{
	                        $('.fa-bookmark-o', $el).removeClass('fa-bookmark-o').addClass('fa-bookmark');
	                    }
	                    $(this).notify_notie(json);
	                },
	                error: function(json){
	                    $(this).notify_notie({msg: e, type: 'danger'});
	                }
	            });
	            return false;
	        });
	    });

	</script>
	</body>
</html>
