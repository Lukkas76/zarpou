
<?php $this->template->showTemplate('template/template_head_end'); ?>
<?php $this->template->showTemplate('template/base_head'); ?>

<!-- Page Header -->
<div class="content overflow-hidden">
    <div class="push-50-t push-15">
        <h1 class="h2 animated zoomIn">Dashboard</h1>
        <h2 class="h5 animated zoomIn">Bem vindo, <?= $this->session->userdata['user-adm']['txtNome']; ?></h2>
    </div>
</div>
<!-- END Page Header -->

<!-- Stats -->
<div class="content bg-white border-b">
    <div class="block">
        <div class="block-content">
            <blockquote>
                <p>Olá <?= $this->session->userdata['user-adm']['txtNome']; ?>, esta é a área restrita para inserção e alteração de conteúdo da <?= NAME_CLIENT; ?></p>
                <p>Todos os dados alterados nesta seção, serão automaticamente visualizados pelos usuários.</p>
            </blockquote>
        </div>
    </div>
</div>
<!-- END Stats -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <!-- Main Dashboard Chart -->
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Conteúdo do cliente para o Dashboard</h3>
                </div>
            </div>
            <!-- END Main Dashboard Chart -->
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php $this->template->showTemplate('template/base_footer'); ?>
<?php $this->template->showTemplate('template/template_footer_start'); ?>

    </body>
</html>