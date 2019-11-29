<?php
/**
 * base_head.php
 *
 * Author: Zarpou JRJ
 *
 * The head of each page (Backend)
 *
 */
?>

<!-- Page Container -->
<div id="page-container"<?php $this->template->page_classes(); ?>>
    <?php 
    if($this->template->inc_side_overlay)
    	$this->template->showTemplate('template/base_side_overlay');
	?>
    <?php 
    	$this->template->showTemplate('template/base_sidebar');
	?>
    <?php 
    	$this->template->showTemplate('template/base_header');
	?>

    <!-- Main Container -->
    <main id="main-container">