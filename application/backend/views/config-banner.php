<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/magnific-popup/magnific-popup.min.css'); ?>">
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/dropzonejs/dropzone.min.css'); ?>">
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/xeditable/css/bootstrap-editable.css'); ?>"/>
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
                Administração de Banners
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="block block-themed" id="bloco-upload">
				<div class="block-content">
					<?php $attributes = array('class' => 'dropzone  push-20', 'id' => 'mydropzone');
						echo form_open_multipart('banner/do_upload', $attributes);
						echo form_hidden('txtAreaImagem', 'type-banner');
						echo form_close();
					?>
				</div>
			</div>
		</div>
	</div>
    <div class="items-push js-gallery-advanced">
    	<div class="block-content">
	        <?php 
	        foreach ($banners as $key => $arq):
	    	?>
	    		<div id="<?= $arq->id; ?>">
			        <div class="col-sm-6 col-md-4 col-lg-3 animated fadeIn" id="<?= $arq->id; ?>">
			            <div class="img-container fx-img-rotate-r">
			            	<img class="img-responsive" src="<?= assets_url($arq->txtPath);?>" alt="">
			                <div class="img-options">
			                    <div class="img-options-content">
			                        <!-- <h3 class="font-w400 text-white push-5">Image Caption</h3> -->
			                        <!-- <h4 class="h6 font-w400 text-white-op push-15">Some Extra Info</h4> -->
			                        <a class="btn btn-sm btn-default img-lightbox" href="<?= assets_url($arq->txtPath);?>">
			                            <i class="fa fa-search-plus"></i> View
			                        </a>
			                        <div class="btn-group btn-group-sm">
			                            <!-- <a class="btn btn-default" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" type="button" data-original-title="Editar"><i class="fa fa-pencil"></i></a> -->
			                            <a class="btn btn-default" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" type="button" data-original-title="Excluir" data-remove="<?= $arq->id; ?>" data-image="<?= $arq->txtFileName; ?>" data-table="Banner"><i class="fa fa-times"></i></a>
			                            <!-- <a class="btn btn-default" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" type="button" data-original-title="SEO"><i class="fa fa-google"></i></a> -->
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			        <div class="col-sm-6 col-md-8 col-lg-9">
			        	<table class="table remove-margin-b font-s12">
			        		<thead>
		                        <tr>
		                            <th class="font-s12 remove-padding-t">Título</th>
		                            <th class="hidden-xs hidden-sm font-s12 remove-padding-t" style="width: 30%;">Alt</th>
<!-- 		                            <th class="hidden-xs hidden-sm font-s12 remove-padding-t">Upload de Imagens</th> -->
<!-- 		                            <th class="hidden-xs hidden-sm font-s12 remove-padding-t">Imagem Sobre o Banner</th> -->
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr data-obj="listaImagens#<?= $arq->id ?>">
		                            <td>
		                                <h3 class="h5">
		                                	<a href="#" 
												id="txtTitle" 
												data-table="Banner" 
												data-type="text" 
												data-pk="<?=$arq->id?>" 
												data-title="Title da imagem" 
												class="editable editable-click media link-effect">
												<?=$arq->txtTitle; ?>
											</a>
		                                </h3>
		                            </td>
		                            <td class="hidden-xs hidden-sm h5">
		                            	<a href="#" 
											id="txtAlt" 
											data-table="Banner" 
											data-type="text" 
											data-pk="<?=$arq->id?>" 
											data-title="Alt da imagem" 
											class="editable editable-click media link-effect">
											<?= ($arq->txtAlt == '')?'Clique aqui para inserir':$arq->txtAlt; ?>
										</a>
		                            </td>
<!-- 		                            <td>
		                            	<?php
		                                    echo form_open('files/upload-avatar-capa', array('class'=>'','id'=>'formImagem','method'=>'post'));
		                                        echo form_hidden('txtImagemAnterior', $arq->txtIcone);
		                                        echo form_hidden('idImagem', $arq->id);
                                    	?>
                                            <a href="#" class="" data-toggle="tooltip" title="Alterar ícone"  data-provides="fileupload" id="bloco-avatar" data-file="obj">
					                            <div class="fileUpload btn btn-primary">
					                                <span style="color:black;">Imagem</span>
					                                <input id="userfile" name="userfile" type="file" class="userfile upload" />
					                            </div>
					                        </a>
		                                <?= form_close(); ?>
				                        <td class="hidden-xs hidden-sm text-center">
		                                    <img class="img-avatar img-avatar64" src="<?= assets_url($arq->txtIcone); ?>" alt="">
		                                </td>
	                                </td> -->
		                        </tr>
		                    </tbody>
		                </table>
		                <table class="table remove-margin-b font-s12">
			        		<thead>
		                        <tr>
		                            <th class="font-s12 remove-padding-t">Descrição</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                            <td>
		                                <h3 class="h5">
		                                	<a href="#" 
												id="txtDescription" 
												data-table="Banner" 
												data-type="text" 
												data-pk="<?=$arq->id?>" 
												data-title="Descrição da imagem"
												class="editable editable-click media link-effect">
												<?= ($arq->txtDescription == '')?'Clique aqui para inserir':$arq->txtDescription; ?>
											</a>
		                                </h3>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <table class="table remove-margin-b font-s12">
		                    <thead>
		                        <tr>
		                            <th class="font-s12">Ordem</th>
		                            <th class="font-s12 remove-padding-t">URL</th>
		                            <th class="font-s12 remove-padding-t">Tipo</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                            <td class="h5" style="width: 5%">
		                                <a href="#" 
											id="intOrdenacao" 
											data-table="Banner" 
											data-type="text" 
											data-pk="<?=$arq->id?>" 
											data-title="Ordenação da imagem" 
											class="editable editable-click media link-effect">
											<?= $arq->intOrdenacao; ?>
										</a>
		                            </td>
		                            <td class="h5" style="width: 50%">
		                            	<a href="#" 
											id="txtUrl" 
											data-table="Banner" 
											data-type="text" 
											data-pk="<?=$arq->id?>" 
											data-title="Ao clicar na imagem definir a URL que o usuário será direcionado" 
											class="editable editable-click media link-effect">
											<?= ($arq->txtUrl == '#')?'Clique aqui para inserir':$arq->txtUrl; ?>
										</a>
		                        	</td>
		                        	<td class="h5" style="width: 15%">
		                            	<a href="#" 
											id="txtTypeTarget" 
											data-table="Banner" 
											data-type="select" 
											data-pk="<?=$arq->id?>" 
											data-title="Definir a abertura da URL"
											data-source="[{value: 'imagem', text: 'Banner'}, {value: 'logo', text: 'Logo do Banner'}]"
											class="editable editable-click media link-effect">
											<?= $arq->txtTypeTarget; ?>
										</a>
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
    <!-- END Gallery -->
</div>
<!-- END Page Content -->
<div id="dataSource" style="display: none !important;">
    <img alt="listaImagens" src="data:image/png;base64,<?= base64_encode(json_encode($banners)); ?>" />
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
	    $(function () {
	        // Init page helpers ( BS Colorpicker)
	        App.initHelpers([ 'colorpicker']);
    	});
	    $('[data-remove]').click(function(){
	    	var obj = new (Object);
			obj.remove = $(this).data('remove');
			obj.image = $(this).data('image');
			obj.table = $(this).data('table');
			$(this).ajaxSubmit({
				type: 'post',
				url: '/admin/banner/remove-reference',
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
					url : "/admin/banner/alter-dados-media",
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

	    $('.userfile').change(function(){
	        App.blocks('#bloco-list', 'state_loading');
	        var $el = $(this).closest(':obj');
	        var $formParceiros = $(this).closest('form');
	        $formParceiros.ajaxSubmit({
	            dataType : "json",
	            type : 'post',
	            success : function(json) {
	                $('.img-avatar', $el).attr('src', json.retorno[0]['path']);
	                setTimeout(function(){
	                    App.blocks('#bloco-list', 'state_normal');
	                }, 1000);
	            },
	            error : function(e) {
	                $('#mensagens').alert({msg: e});
	            }
	        });
	        return false;
	    })
	</script>
	</body>
</html>
