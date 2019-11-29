

<?php 
    $this->template->showTemplate('template/template_head_end');
    $this->template->showTemplate('template/base_head');
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">Outros Empreendimentos / <?=$imovel[0]->txtTituloImovel?></h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
	<div class="row">
		<div class="col-lg-12">
		    <!-- Forms Row -->
		    <!-- Material Forms Validation -->
		    <div class="block block-themed">
		        <div class="block-header bg-primary-dark">
		        	<div class="block-options-simple">
                    	<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-xs btn-success"><i class="si si-action-undo"></i> Voltar</a>
                    	<button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                	</div>
		        	<ul class="block-options">
		                <li><span>Escolha 3 imóveis</span></li>
		            </ul>
		            <h3 class="block-title">Imóveis Relacionados</h3>
		        </div>
		        <div class="block-content">
		        	<?php 
		        		echo form_open('/produto/config-relacionados',array('class'=>'js-validation-material form-horizontal push-10-t', 'id'=>'formRotasRelacionados', 'method'=>'post'));
						echo form_hidden('id', $imovel[0]->id);
		        		$arrayRelacionadasRota = array();
		        		$countRelacionadas = count($relacionadas);
		        		foreach ($relacionadas as $relRota){
							array_push($arrayRelacionadasRota, $relRota);
						} 
		        	?>
		        	<div class="row">
						<div class="col-xs-12">
							<?php 
							if(!count($all_imoveis)){
								echo '<h5>Não há imóveis para listar </h5>';
							}
							foreach($all_imoveis as $rot):
								if($rot->id != $imovel[0]->id):
									$estiloLabel = '';
									$disable = '';
									if(!in_array($rot->id, $arrayRelacionadasRota) && $countRelacionadas >= 3){
										// $estiloLabel = 'style="color:#BEBBBB"';
										// $disable = "disabled";
									}
							?>
								<div class="col-sm-12 col-sm-6">	
					        		<div class="form-group">
					        			<div class="form-material form-material-primary">
					                        <label class="css-input css-checkbox css-checkbox-success" <?=$estiloLabel?>>
					                        	<?php echo form_checkbox(array('checked'=>(in_array($rot->id, $arrayRelacionadasRota))?'checked':'', 'name'=> 'relacionadas[]', 'class'=>'checkbox', 'value'=>$rot->id)); ?>
					                            <span></span> <?=$rot->txtTituloImovel?>
					                        </label>
					                	</div>	
					                </div>
					            </div>
			            	<?php 
		            			endif;
		            		endforeach;
			            	?>
			        	</div>
	                </div>
	                <div class="form-group"  style="padding-top:100px">
	                    <div class="col-xs-12">
	                        <button class="btn btn-primary" type="submit">Salvar</button>
	                    </div>
	                </div>
		            <?php 
		            echo form_close();
		            ?>
		        </div>
		    </div>
    		<!-- END Material Forms Validation -->
    		<!-- END Forms Row -->
		</div>    	
	</div>
</div>
<!-- END Page Content -->

<div id="dataSource" style="display: none !important;">
	<img alt="listaRotas" src="data:image/png;base64,<?= base64_encode(json_encode($all_imoveis)); ?>" />
</div>

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/alert_modal');
	$this->template->showTemplate('template/template_footer_start'); 
?>

	
	</body>
</html>