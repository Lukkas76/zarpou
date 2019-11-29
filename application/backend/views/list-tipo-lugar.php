<?php 
    $this->template->showTemplate('template/template_head_end');
    $this->template->showTemplate('template/base_head'); 
?>

<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Cadastro ou alteração dos Tipo de Locais
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
                        <button class="btn btn-xs btn-warning" type="button" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    </div>
                    <h3 class="block-title font-w400 text-white">Tipos de locais no Detalhe do Imóvel</h3>
                </div>
                <div class="block-content">
                    <?php
                        echo form_open('lugar/new-tipo', array('class'=>'js-validation-material form-horizontal push-10-t','id'=>'formImovel','method'=>'post'));
                            echo form_hidden('id', '');
                    ?>
                            <div class="form-group">
                                <div class="col-lg-5 col-xs-12">
                                    <label class="col-xs-12" for="txtProximidade">Tipo de Lugar</label>
                                    <div class="col-xs-12">
                                        <?php echo form_input(array('name'=> 'txtProximidade', 'required'=>'required', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off')); ?>
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
                                <th>Título</th>
                                <th class ="text-center" style = "width:100px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($tipo as $pro):
                            ?>
                            <tr data-obj="listaImovel#<?= $pro->id ?>">
                                <td><?= $pro->txtProximidade; ?></td>
                                <td class="text-center" style="width: 10%">
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-xs btn-default " data-toggle="tooltip" title="Editar Descrição" data-edit="obj" data-form="#formImovel">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Descrição" data-remove="obj">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
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
    <img alt="listaImovel" src="data:image/png;base64,<?= base64_encode(json_encode($tipo)); ?>" />
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

<script type="text/javascript">


    $(document).ready(function(){
        $('[data-edit]').click(function() {
            $('#cancelar').removeClass('hidden-print');
            $('#formImovel').removeAttr('action').attr('action','/admin/lugar/alter-tipo');
        });

        $('#cancelar').click(function() {
            $('#cancelar').addClass('hidden-print');        
            $('#formImovel').removeAttr('action').attr('action','/admin/lugar/new_tipo');
            $('#id').val('');
        });
    })  

    $(document).ready(function(){
        $(document).on('click', '[data-remove]', function(){
            $('.modal-title').text('Excluir Tipo de Localização');
            $('.excplication').text('Tem certeza que deseja excluir um tipo de localização do Sistema ?');
            $('#alert-modal').data('url', '/admin/lugar/remove-tipo');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_tipo()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_tipo(){
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
                $(this).notify_notie({msg: 'Você não pode excluir uma localização que está vinculada a um imóvel', type: 'danger'});
            }
        });
    }

</script>

</body>
</html>
