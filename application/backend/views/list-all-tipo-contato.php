<link rel="stylesheet" href="<?php echo assets_url('js/plugins/xeditable/css/bootstrap-editable.css'); ?>"/>

<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Informações de Contato
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <!-- Partial Table -->
    <div class="row">
	    <div class="block block-themed">
	        <div class="block-header bg-primary-dark">
	        	<div class="block-options-simple">
	        		<!-- <a href="<?= base_url('contato/action-tipo-contato'); ?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Adicionar</a> -->
                    <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </div>
                <h3 class="block-title font-w400 text-white">Blocos de Contato Registrados no sistema</h3>
	        </div>
	        <div class="block-content">
	            <table class="table table-striped table-vcenter table-bordered table-hover js-clients">
	                <thead>
	                    <tr class="text-white bg-primary-dark">
	                    	<th width="40px" class="text-center font-s12">Icone</th>
	                    	<th width="70%" class="font-s12">Informações dos Blocos de Contato</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
	                    foreach ($tipo_contato as $key => $con):
	                    ?>
	                		<tr data-obj="listaContatos#<?= $con->id ?>">
	                			<td class="text-center"><img class="img-avatar img-avatar32" src="<?= assets_url($con->txtIconeContato); ?>" alt=""></td>
	                			<td class="font-s12">
                                    <a href="#" 
                                        id=""
                                        data-name="txtTitulo"
                                        data-table="InformacoesContato"
                                        data-type="text" 
                                        data-pk="<?= $con->id; ?>" 
                                        data-value="<?= $con->txtTitulo; ?>"
                                        data-title="Edite a Informação de Contato" 
                                        class="editable editable-click tipo_contato" 
                                        style="display: inline;">
                                        <?php if($con->txtTitulo == ""): echo 'Empty'; endif;?>
                                        <?= $con->txtTitulo; ?>
                                    </a>
                                </td>
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
    <img alt="listaContatos" src="data:image/png;base64,<?= base64_encode(json_encode($tipo_contato)); ?>" />
</div>

<?php 
    $this->template->showTemplate('template/base_footer'); 
    $this->template->showTemplate('template/template_footer_start');
?>

<script src="<?php echo assets_url('js/plugins/xeditable/js/bootstrap-editable.min.js'); ?>"></script>


<script type="text/javascript">

    $(document).on('click', '.tipo_contato', function(){
        $('.tipo_contato').editable({
            showbuttons: true,
            url : "/admin/contato/alter-dados-contato",
            inputclass: 'input-large',
            params: function(params) {
                params.table = $(this).data('table');
                params.mensagemLog = $(this).data('log');
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
</script>

</body>
</html>













