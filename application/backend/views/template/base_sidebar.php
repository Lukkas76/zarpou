<?php
/**
 * template/base_sidebar.php
 *
 * Author: Zarpou JRJ
 *
 * Barra lateral de cada página (backend)
 *
 */
?>

<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="side-header side-content bg-white-op">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <a class="h5" href="index.php">
                	<!-- <img src="<?php echo assets_url('img/favicons/favicon-Zarpou-32x32.png'); ?>" alt="Zarpou Desenvolvimento e Negócios"> -->

                	<img class="img-avatar img-avatar32" src="<?= assets_url($this->session->userdata['user-adm']['txtPathAvatar']); ?>" alt="Zarpou Desenvolvimento e Negócios">

                    <span class="h4 font-w600 sidebar-mini-hide">Zarpou</span>
                </a>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="side-content">
                <ul class="nav-main">
                    <?php $this->template->build_nav(); ?>
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->
