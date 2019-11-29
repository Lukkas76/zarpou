<?php 
    $this->template->showTemplate('template/template_head_end');
    $this->template->showTemplate('template/base_head'); 
?>
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/jquery-tags-input/jquery.tagsinput.min.css'); ?>">
<!-- Page Header -->
<div class="content bg-primary-dark">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading text-white">
                Cadastro ou alteração da Ficha técnica/ <?=$nome[0]->txtTituloImovel?>
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
                    <h3 class="block-title font-w400 text-white">Ficha Técnica do Detalhe do Imóvel</h3>
                </div>
                <div class="block-content">
                    <?php
                        echo form_open('ficha/new-ficha', array('class'=>'js-validation-material form-horizontal push-10-t','id'=>'formImovel','method'=>'post'));
                            echo form_hidden('id', '');
                            echo form_hidden('idImovel', $idImovel);
                    ?>
                            <div class="form-group">
                                <div class="col-lg-4 col-xs-12">
                                    <label class="col-xs-12" for="txtProximidade">Ficha Técnica</label>
                                    <div class="col-xs-12">
                                        <?php echo form_input(array('name'=> 'txtFichaTecnica', 'required'=>'required', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off')); ?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <label class="col-xs-12" for="txtProximidade">Conteúdo / escreva e precione a tecla enter</label>
                                    <div class="col-xs-12">
                                        <?php echo form_input(array('name'=> 'txtConteudo', 'required'=>'required', 'class'=>'js-tags-input form-control', 'type'=>'text', 'autocomplete' => 'off')); ?>
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
                    <h3 class="block-title">Fichas Técnicas Cadastradas</h3>
                </div>
                <div class="block-content">
                    <table class="table table-striped table-vcenter table-bordered table-hover">
                        <thead>
                            <tr class="text-white bg-primary-dark">
                                <th>Ficha</th>
                                <th>Conteúdo</th>
                                <th class ="text-center" style = "width:100px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($ficha as $fic):
                            ?>
                            <tr data-obj="listaImovel#<?= $fic->id ?>">
                                <td><?= $fic->txtFichaTecnica; ?></td>
                                <td>
                                    <?php
                                        $conteudo = explode(',', $fic->txtConteudo);
                                        for ($i=0; $i < count($conteudo); $i++){
                                            echo $conteudo[$i] .'/ ';
                                        }
                                    ?>
                                </td>
                                <td class="text-center" style="width: 10%">
                                    <div class="text-center">
                                        <div class="btn-group">
<!--                                             <a href="#" class="btn btn-xs btn-default " data-toggle="tooltip" title="Editar Descrição" data-edit="obj" data-form="#formImovel">
                                                <i class="fa fa-pencil"></i>
                                            </a> -->
                                            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" title="Excluir Ficha Técnica" data-remove="obj">
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
    <img alt="listaImovel" src="data:image/png;base64,<?= base64_encode(json_encode($ficha)); ?>" />
</div>

<?php 
    $this->template->showTemplate('template/base_footer'); 
    $this->template->showTemplate('template/template_footer_start'); 
    $this->template->showTemplate('template/alert_modal');
?>

<!-- Page JS Plugins -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>

<script src="<?php echo assets_url('js/plugins/jquery-tags-input/jquery.tagsinput.min.js'); ?>"></script>
<script src="<?php echo assets_url('js/plugins/masked-inputs/jquery.maskedinput.min.js'); ?>"></script>


<!-- Page JS Code -->
<script src="<?php echo assets_url('js/pages/base_forms_validation.js'); ?>"></script>

<script type="text/javascript">

    App.initHelpers(['masked-inputs']); 

    jQuery('.js-tags-input').tagsInput({
        height: '70px',
        width: '100%',
        defaultText: 'Add',
        removeWithBackspace: true,
        delimiter: [',']
    });


    $(document).ready(function(){
        $('[data-edit]').click(function() {
            $('#cancelar').removeClass('hidden-print');
            $('#formImovel').removeAttr('action').attr('action','/admin/ficha/alter-ficha');
        });

        $('#cancelar').click(function() {
            $('#cancelar').addClass('hidden-print');        
            $('#formImovel').removeAttr('action').attr('action','/admin/ficha/new_ficha');
            $('#id').val('');
        });
    })  

    $(document).ready(function(){
        $(document).on('click', '[data-remove]', function(){
            $('.modal-title').text('Excluir Ficha Técnica');
            $('.excplication').text('Tem certeza que deseja excluir uma Ficha Técnica deste Imóvel ?');
            $('#alert-modal').data('url', '/admin/ficha/remove-ficha');
            $('#alert-modal').data('el', $(this));
            $('.btn-action').attr('onclick' , 'excluir_ficha()');
            jQuery('#alert-modal').modal('show');
            
        })
    })

    function excluir_ficha(){
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
