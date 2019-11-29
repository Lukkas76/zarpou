<?php
/**
 * base_header.php
 *
 * Author: Zarpou JRJ
 *
 * The header of each page (Backend)
 *
 */
?>

<!-- Header -->
<header id="header-navbar" class="content-mini content-mini-full">
    <!-- Header Navigation Right -->
    <ul class="nav-header pull-right">
        <li>
            <div class="btn-group">
                <button class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                    <img src="<?= assets_url($this->session->userdata['user-adm']['txtPathAvatar']); ?>" alt="Avatar">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a tabindex="-1" href="<?= base_url('user/perfil-user'); ?>" alt="Perfil do usuário">
                            <i class="si si-user pull-right"></i>Perfil
                        </a>
                    </li>
                    <li>
                        <a tabindex="-1" href="<?= base_url('user/perfil-user'); ?>" alt="Perfil do usuário">
                            <i class="si si-settings pull-right"></i>Configurações
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a tabindex="-1" href="<?= base_url('logout'); ?>">
                            <i class="si si-logout pull-right"></i>Log out
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <?php
        if($this->template->inc_side_overlay):
    	?>
	        <li>
	            <button class="btn btn-default" data-toggle="layout" data-action="side_overlay_toggle" type="button">
	                <i class="fa fa-tasks"></i>
	            </button>
	        </li>
		<?php
		endif;
		?>
    </ul>
    <!-- END Header Navigation Right -->

    <!-- Header Navigation Left -->
    <ul class="nav-header pull-left">
        <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button">
                <i class="fa fa-navicon"></i>
            </button>
        </li>
        <li class="hidden-xs hidden-sm">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button">
                <i class="fa fa-ellipsis-v"></i>
            </button>
        </li>
        <li class="visible-xs">
            <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
            <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button">
                <i class="fa fa-search"></i>
            </button>
        </li>
<!--         <li class="js-header-search header-search">
        	<?php
        	echo form_open('', array('class'=>'form-horizontal','id'=>'formSearch','method'=>'post'));
        	?>
            <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
            	<?php echo form_input(array('name'=> 'txtSearch', 'id'=>'txtSearch', 'class'=>'form-control', 'type'=>'text', 'placeholder'=>'Procurar um imóvel pelo Nome ou Endereço...')); ?>
                <span class="input-group-addon"><i class="si si-magnifier" id="search"></i></span>
            </div>
           	<?php
           	echo form_close();
           	?>
        </li> -->
    </ul>
    <!-- END Header Navigation Left -->
</header>
<!-- END Header -->
