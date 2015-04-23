<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __('TopMenu');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<?php echo $this->Html->charset('utf-8'); ?>
        <title>
			<?php echo $title_for_layout; ?>
        </title>
		<?php
		echo $this->Html->meta('icon');
        echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
		echo $this->fetch('meta');
		// echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-custom');		
		echo $this->Html->css('topmenu2');
		echo $this->Html->css('topmenu2-mobile');
		echo $this->fetch('css');
		?>
        <meta name="google-site-verification" content="v4lGo8dQ5cL2se8tOCGwUa1NkDfNMCIn66yAQ99aekU" />
    </head>
    <body>
        <?php echo $this->element('google_analytics'); ?>
		<div id="mobile-wrapper">
			<?php echo $this->Html->script('jquery'); ?>
            
			
			
			<!--  BREADCRUMBS 
			<?php if ($this->Session->check('Breadcrumbs')) { ?>
			<div class="btn-group dropup" id="navButton">
				<a class="btn dropdown-toggle btn-large" id="navButtonAnchor" data-toggle="dropdown" href="#">
							<?php echo __('Navigation'); ?>
							<span class="caret"></span>
						</a>
					<ul class="dropdown-menu pull-right">
						<?php
						$crumbs = $this->Session->read('Breadcrumbs');
						$i = 0;
						foreach ($crumbs as $crumb) {
							$activeBreadCrumb = (!empty($activeBreadCrumb)) ? $activeBreadCrumb : '';
							$activeClass = ($activeBreadCrumb === $crumb['Title']) ? 'active' : '';
							$breadCrumUrlArray = array(
								'controller' => $crumb['Controller'],
								'action' => $crumb['Action']);
							if (!empty($crumb['Parameter'])) {
								if (is_array($crumb['Parameter'])) {
									$breadCrumUrlArray = array_merge($breadCrumUrlArray, $crumb['Parameter']);
								} else {
									array_push($breadCrumUrlArray, $crumb['Parameter']);
								}
							}
							?>
							<li class="<?php echo $activeClass; ?>">
								<?php
								echo $this->Html->link(
									$crumb['Title'], $breadCrumUrlArray)
								?>										
							</li>
						<?php } ?>
				</div>
					<?php } ?>
			-->

			<div id="setFlash">
				<?php echo $this->Session->flash('auth'); ?>
				<?php echo $this->Session->flash(); ?>
			</div>
			
			<div id="mobile-content">
				<?php echo $content_for_layout; ?>

			</div>


			<?php
			echo $this->Html->script('application');			
			echo $this->fetch('script');
			?>
            
            <?php if($this->params['action'] == 'index'):?>
            <a href="<?php echo $this->request->here; ?>" style="bottom: 5px; right: 5px; position: fixed;" onclick="document.cookie = 'siteversion=desktop;path=/';">
                <?php echo __('FULL SITE') ?>
            </a>
            <?php endif;?>
    </body>
</html>
