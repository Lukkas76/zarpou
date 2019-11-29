<?php 
	$this->template->showTemplate('template/template_head_end');
	$this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Focal Inc
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
                    <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                </div>
                <h3 class="block-title font-w400 text-white">Conteudo institucional da home</h3>
	        </div>
	        <div class="block-content">
	            <table class="table table-striped table-vcenter table-bordered table-hover js-clients">
	                <thead>
	                    <tr class="text-white bg-primary-dark">
	                    	<th width="40px" class="text-center font-s12">Título</th>
	                    	<th width="70%" class="font-s12">Descrição</th>
                            <th width="10%" class="text-center font-s12">Ações</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
	                    foreach ($sobre as $key => $con):
	                    ?>
	                		<tr data-obj="listaContatos#<?= $con->id ?>">
                                <td class ="text-center"><b><?= $con->txtTitulo; ?></b></td>
	                			<td class="font-s12"><?= $con->txtDescricao; ?></td>
                                <td class="text-center"><a href="<?= base_url('sobre/action-sobre/' . $con->id); ?>" class="btn btn-xs btn-default" data-toggle="tooltip" title="Editar"><i class="fa fa-pencil"></i></a></td>
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
    <img alt="listaContatos" src="data:image/png;base64,<?= base64_encode(json_encode($sobre)); ?>" />
</div>

<?php 
    $this->template->showTemplate('template/base_footer'); 
    $this->template->showTemplate('template/template_footer_start');
?>

</body>
</html>













