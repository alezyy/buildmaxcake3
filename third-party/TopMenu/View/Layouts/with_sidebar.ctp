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
        echo $this->fetch('meta');
        echo $this->Html->css('bootstrap');
        // echo $this->Html->css('bootstrap-custom');
        // echo $this->Html->css('bootstrap-responsive');
        // echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));
        echo $this->Html->css('prettify');
        echo $this->Html->css('docs');
        echo $this->Html->css('misc');
        echo $this->Html->css('default');
        echo $this->Html->css('topmenu');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
        <?php echo $this->Html->script('jquery'); ?>
        <div class="main">
            <?php echo $this->element('topbar'); ?>




            <div id="content_wrapper_inner">
                <div id="content_inner_frame">
                    <div id="content_inner">  
                        <div class="other_pages_left">
                        </div>
                        <div class="other_right_cntnr" id="right_col">
                        </div>
                    </div>

                    <div style='left:0px; margin-top:10px;'>
                        <?php echo $this->Html->getCrumbs(' > ', __('Home')); ?>
                    </div>
                    <?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php
                    echo $content_for_layout;
                    ?>

                    <footer class="footer">
                        <div class="innergray">
                            <?php echo $this->element('footer'); ?>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
        <?php
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('application');
        echo $this->Html->script('prettify');
        // echo $this->Html->script('addthis_widget');
        echo $this->Html->script('jcarousellite');
        echo $this->Html->script('home_page');
        echo $this->fetch('script');
        ?>
    </body>
</html>
