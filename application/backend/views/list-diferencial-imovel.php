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
                Imóvel <?=$nome[0]->txtTituloImovel?>
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
                    <h3 class="block-title">Descrição</h3>
                </div>
                <div class="block-content">
                    <?php
                        echo form_open('produto/new-diferencial', array('class'=>'js-validation-material form-horizontal push-10-t','id'=>'formImovel','method'=>'post'));
                            echo form_hidden('id', '');
                            echo form_hidden('idImovel', $idImovel);
                    ?>
                            <div class="form-group">
                                <div class="col-lg-8 col-xs-12">
                                    <label class="col-xs-12" for="txtDescricao">Descrição</label>
                                    <div class="col-xs-12">
                                        <?php echo form_textarea(array('name'=> 'txtDescricao', 'required'=>'required', 'rows'=>'5', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off')); ?>
                                    </div>
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
                    <h3 class="block-title">Descrições Cadastradas</h3>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-vcenter table-bordered table-hover">
                        <thead>
                            <tr class="text-white bg-primary-dark">
                                <th class="hidden-xs hidden-sm text-center" style="width: 120px;"><i class="fa fa-file-image-o"></i></th>
                                <th class="hidden-xs hidden-sm text-center" style = "width:150px">Ordem</th>
                                <th>Descrição</th>
                                <th class ="text-center" style = "width:100px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($imovel as $pro):
                            ?>
                            <tr data-obj="listaImovel#<?= $pro->id ?>">
                                <td class="hidden-xs hidden-sm text-center">
                                    <img class="hidden-xs hidden-sm img-avatar img-avatar32" src="<?= assets_url($pro->txtPathIcone); ?>" alt="">
                                </td>
                                <td class="hidden-xs hidden-sm text-center">
                                    <a href="#" 
                                        id=""
                                        data-name="intOrdem"
                                        data-table="tabDiferencialImovel"
                                        data-type="text" 
                                        data-pk="<?= $pro->id; ?>" 
                                        data-value="<?= $pro->intOrdem; ?>"
                                        data-title="Edite a ordem da Descrição" 
                                        class="editable editable-click imovel" 
                                        style="display: inline;">
                                        <?= $pro->intOrdem; ?>
                                    </a>
                                </td>
                                <td><?= $pro->txtDescricao; ?></td>
                                <td class="text-center" style="width: 10%">
                                    <?php
                                    echo form_open('files/upload-avatar-produto', array('class'=>'','id'=>'formImagem','method'=>'post'));
                                        echo form_hidden('txtImagemAnterior', $pro->txtPathIcone);
                                        echo form_hidden('idProduto', $pro->id);
                                    ?>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-xs btn-default " data-toggle="tooltip" title="Editar Descrição" data-edit="obj" data-form="#formImovel">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Descrição" data-remove="obj">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <a href="#" class="" data-toggle="tooltip" title="Alterar ícone"  data-provides="fileupload" id="bloco-avatar" data-file="obj">
                                                <span class="btn btn-xs btn-file link"> 
                                                    <button class="bg-city-dark" type="submit">
                                                        <i class="fa fa-file-image-o text-white"></i>
                                                    </button>
                                                    <input type="file" name="userfile" id="userfile" class="userfile">
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
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
            $('#formImovel').removeAttr('action').attr('action','/admin/produto/alter-diferencial');
        });

        $('#cancelar').click(function() {
            $('#cancelar').addClass('hidden-print');        
            $('#formImovel').removeAttr('action').attr('action','/admin/produto/new_diferencial');
            $('#id').val('');
        });
    })  

    $(document).on('click', '.imovel', function(){
        $('.imovel').editable({
            showbuttons: true,
            url : "/admin/produto/alter-dados-diferencial",
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
            $('.modal-title').text('Excluir Descrição');
            $('.excplication').text('Tem certeza que deseja excluir uma diferencial do Sistema ?');
            $('#alert-modal').data('url', '/admin/produto/remove-diferencial');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_descricao()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_descricao(){
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
