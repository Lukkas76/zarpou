<?php 
$this->template->showTemplate('template/template_head_end.php'); 
?>
<!-- Login Content -->
<div class="pulldown">
    <div class="overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="push-30-t push-50 animated fadeIn">
                    <!-- Login Title -->
                    <div class="text-center">
                    	<img src="<?= assets_url('img/site/logo.png'); ?>" alt="Zarpou">
                        <p class="text-muted push-15-t">Área administrativa <b><?= NAME_CLIENT; ?></b></p>
                    </div>
                    <!-- END Login Title -->
                    <?php
						echo form_open('login/validar_login', array('class'=>'js-validation-login form-horizontal push-30-t','id'=>'form_login','method'=>'post'));
					?>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material-primary">
                                    <label for="login-username">Usuário</label>
                                	<?php echo form_input(array('name'=> 'txtLogin', 'id'=>'txtLogin', 'class'=>'form-control', 'type'=>'text', 'autocomplete' => 'off', 'placeholder'=>'Informe seu email ou login ...')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material-primary">
                                    <label for="login-password">Senha</label>
                                	<?php echo form_input(array('name'=> 'txtSenha', 'id'=>'txtSenha', 'class'=>'form-control', 'type'=>'password', 'autocomplete' => 'off')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group push-30-t">
                            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                <button class="btn btn-sm btn-block btn-danger" type="submit">Acessar</button>
                            </div>
                        </div>
                    <?= form_close(); ?>
                    <!-- END Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Login Content -->

<?php $this->template->showTemplate('template/template_footer_start.php'); ?>

<!-- Page JS Plugins Adicionais -->
<script src="<?php echo assets_url('js/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>

<!-- Page JS Code -->
<script src="<?= assets_url('js/pages/base_forms_validation.js'); ?>"></script>
<script src="<?= assets_url('js/pages/base_page_login.js'); ?>"></script>

</body>
</html>