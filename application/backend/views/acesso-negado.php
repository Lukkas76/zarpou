<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/slick/slick.min.css'); ?>">
<link rel="stylesheet" href="<?php echo assets_url('js/plugins/slick/slick-theme.min.css'); ?>">

<?php $this->template->showTemplate('template/template_head_end'); ?>
<?php $this->template->showTemplate('template/base_head'); ?>

<!-- Page Header -->
<div class="content bg-danger">
    <div class="row items-push">
        <div class="col-sm-12">
            <h1 class="page-heading animated zoomIn text-white">
                Acesso Negado <small>Acesso a uma área restrita.</small>
            </h1>
        </div>
    </div>
</div>
<!-- Stats -->
<div class="content bg-white border-b">
	<div class="block block-themed">
        <div class="block-content">
            <blockquote>
                <p>Olá <?= $this->session->userdata['user-adm']['txtNome']; ?>, você está tentando acessar uma função ou área que não possui acesso.</p>
                <p>Por favor entre em contato com o Administrador do sistema para poder providenciar a liberação do acesso.</p>
                <footer>Obrigado</footer>
                <footer>Equipe <?= NAME_CLIENT; ?></footer>
            </blockquote>
        </div>
    </div>
</div>
<!-- END Stats -->
<?php $this->template->showTemplate('template/base_footer'); ?>
<?php $this->template->showTemplate('template/template_footer_start'); ?>

	</body>
</html>