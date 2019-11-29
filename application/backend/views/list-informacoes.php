<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<div class="content text-white bg-primary-dark">
    <div class="row items-push">
    	<div class="col-sm-2">
            <div class="form-group">
                <div class="row col-sm-12">
                    <div class="form-material">
                    	<input type="text" name="datInicial" style="color:#fff" value="<?=$datInicio?>" class="form-control text-white js-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" required="required">
                        <label for="datInicial">De</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <div class="row col-sm-12">
                    <div class="form-material">
                    	<input type="text" name="datFinal" style="color:#fff" value="<?=$datFinal?>" class="form-control text-white js-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" required="required">
                        <label for="datFinal">Até</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="row col-sm-12">
                    <button class="btn btn-minw btn-primary push-10-t" type="button" id="filtroData">Filtrar</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
        	<a href="<?= base_url($urlPost . date('Y-m-d') . '/' .date('Y-m-d')); ?>" class="btn btn-minw btn-default push-10-t" title="Download">Hoje</a>
        	<a href="<?= base_url($urlPost . DatInicioMesAnterior . '/' .DatTerminoMesAnterior); ?>" class="btn btn-minw btn-default push-10-t" title="Download"><?= FormataMesPorExtenso((int)MesAnterior); ?></a>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="content">
    <!-- Partial Table -->
    <div class="row">
	    <div class="block block-themed">
	        <div class="block-header bg-primary-dark">
	        	<div class="block-options-simple">
                    <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </div>
                <h3 class="block-title font-w400 text-white">Contatos registrados no sistema</h3>
	        </div>
	        <div class="block-content">
	            <table class="table table-striped table-vcenter table-bordered table-hover js-clients">
	                <thead>
	                    <tr class="text-white bg-primary-dark">
	                    	<th width="10%" class="font-s12 hidden-xs hidden-sm">Nome</th>
	                    	<th width="10%" class="font-s12 hidden-xs hidden-sm">Email</th>
	                    	<th width="7%" class="font-s12 hidden-xs hidden-sm">Telefone</th>
							<th width="15%">Mensagem</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
	                    foreach ($contato as $key => $con):
	                    ?>
	                		<tr>
	                			<td class="font-s12"><?= $con->txtNome; ?></td>
	                			<td class="font-s12"><?= $con->txtEmail ;?></td>
	                			<td class="font-s12"><?= $con->txtTelefone ;?></td>
	                			<td class="font-s12"><?= $con->txtMensagem ;?></td>
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

<?php 
	$this->template->showTemplate('template/base_footer'); 
	$this->template->showTemplate('template/template_footer_start'); 
?>

<script src="<?php echo assets_url('js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js');?>"></script>


<script type="text/javascript">
	$(document).ready(function(){
		// Init page helpers (Masked Input)
		// App.initHelpers(['masked-inputs']);
		App.initHelpers(['datepicker']);

		$(document).on('click', '#filtroData', function() {
			var dataInicio = $('[name="datInicial"]').val().split('/').reverse().join('-');
			var dataTermino = $('[name="datFinal"]').val().split('/').reverse().join('-');
			document.location.assign('/admin/informacoes/list-informacoes/'+dataInicio+'/'+dataTermino)
		});
	})
</script>

</body>
</html>













