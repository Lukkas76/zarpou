<!-- Page JS Plugins CSS -->
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
                Status da obra / <?=$nome[0]->txtTituloImovel?>
            </h1>
        </div>
    </div>
</div>
<!-- END Page Header -->

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="block block-themed" id="bloco-imovel">
                <div class="block-header bg-primary-dark">
                    <div class="block-options-simple">
                        <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-xs btn-success"><i class="si si-action-undo"></i> Voltar</a>
                        <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    </div>
                    <h3 class="block-title font-w400 text-white">Cadastrar um Status para a obra</h3>
                </div>
                <div class="block-content">
                    <?php
                        echo form_open('produto/new-obra', array('class'=>'js-validation-material form-horizontal push-10-t','id'=>'formImovel','method'=>'post'));
                            echo form_hidden('id', '');
                            echo form_hidden('idImovel', $idImovel);
                    ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-5">
                                    <label for="txtTitulo">Status da Obra</label>
                                    <?php echo form_input(array('name'=> 'txtTitulo', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'placeholder'=>'Nome do status', 'required'=>'required')); ?>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <label for="idStatus">Porcentagem</label>
                                    <?php 
                                        $options = array(
                                            '10'         => '10',
                                            '20'         => '20',
                                            '30'         => '30',
                                            '40'         => '40',
                                            '50'         => '50',
                                            '60'         => '60',
                                            '70'         => '70',
                                            '80'         => '80',
                                            '90'         => '90',
                                            '100'        => '100',
                                        );
                                        echo form_dropdown('intPorcentagem', $options, '', 'class="form-control"');
                                    ?>
                                </div>
                                <div class="col-xs-4 push-20-t">
                                    <button class="btn btn-primary" type="submit">Gravar</button>
                                    <button class="btn btn-danger hidden-print" type="reset" id="cancelar">Cancelar</button>
                                </div>
                            </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="block block-themed">
                <div class="block-header bg-primary-dark">
                    <div class="block-options-simple">
                        <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    </div>
                    <h3 class="block-title">Status das Obras Cadastradas</h3>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-vcenter table-bordered table-hover">
                        <thead>
                            <tr class="text-white bg-primary-dark">
                                <th style="width: 30%;">Título</th>
                                <th class="text-center" style="width:7%">Ordem</th>
                                <th class ="text-center" style="width: 10%;">Porcentagem</th>
                                <th class="text-center" style="width: 10%;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($imovel as $key => $pro):
                            ?>
                            <tr data-obj="listaImovel#<?= $pro->id ?>">
                                <td class="font-w600"><?= $pro->txtTitulo; ?></td>
                                <td class="hidden-xs hidden-sm text-center">
                                    <a href="#" 
                                        id=""
                                        data-name="intOrdem"
                                        data-table="tabStatusObra"
                                        data-type="text" 
                                        data-pk="<?= $pro->id; ?>" 
                                        data-value="<?= $pro->intOrdem; ?>"
                                        data-title="Edite a ordem do Status" 
                                        class="editable editable-click imovel" 
                                        style="display: inline;">
                                        <?= $pro->intOrdem; ?>
                                    </a>
                                </td>
                                <td class="text-center font-w600"><?= $pro->intPorcentagem; ?> %</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Editar Obra" data-edit="obj" data-form="#formImovel">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Obra" data-remove="obj">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
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
    </div>
</div>

<div id="dataSource" style="display: none !important;">
    <img alt="listaImovel" src="data:image/png;base64,<?= base64_encode(json_encode($imovel)); ?>" />
</div>

<?php 
    $this->template->showTemplate('template/base_footer'); 
    $this->template->showTemplate('template/template_footer_start'); 
    $this->template->showTemplate('template/alert_modal');
?>

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>


<!-- Page JS Code -->
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>
<script src="<?php echo assets_url('js/plugins/xeditable/js/bootstrap-editable.min.js'); ?>"></script>

<script type="text/javascript">

    $('.userfile').change(function(){
        App.blocks('#bloco-list', 'state_loading');
        var $el = $(this).closest(':obj');
        var $formImagem = $(this).closest('form');
        $formImagem.ajaxSubmit({
            dataType : "json",
            type : 'post',
            success : function(json) {
                $('.img-avatar', $el).attr('src', json.retorno[0]['path']);
                setTimeout(function(){
                    App.blocks('#bloco-list', 'state_normal');
                }, 1000);
            },
            error : function(e) {
                // $('#mensagens').alert({msg: e});
            }
        });
        return false;
    })

    $(document).ready(function(){
        $('[data-edit]').click(function() {
            $('#cancelar').removeClass('hidden-print');
            $('#formImovel').removeAttr('action').attr('action','/admin/produto/alter-obra');
        });

        $('#cancelar').click(function() {
            $('#cancelar').addClass('hidden-print');        
            $('#formImovel').removeAttr('action').attr('action','/admin/produto/new_obra');
            $('#id').val('');
        });
    })  

    $(document).on('click', '.imovel', function(){
        $('.imovel').editable({
            showbuttons: true,
            url : "/admin/produto/alter-dados-obra",
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

    $(document).ready(function(){
        $(document).on('click', '[data-remove]', function(){
            $('.modal-title').text('Excluir Status da Obra');
            $('.excplication').text('Tem certeza que deseja excluir uma Status da Obra deste Imóvel ?');
            $('#alert-modal').data('url', '/admin/produto/remove-obra');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_obra()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_obra(){
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

</script>

</body>
</html>
