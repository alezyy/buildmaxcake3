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
        echo $this->Html->css('topmenu2');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
            <?php echo $this->Html->script('jquery'); ?>
        
            <div id="content_wrapper">
                <div class="header">
                    <?php echo $this->element('topbar'); ?>
                </div>

                <div id="content_home">
                    <div style='left:0px; margin-top:10px;'>
                        <?php echo $this->Html->getCrumbs(' > ', __('Home')); ?>
                    </div>

                    <?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php
                    echo $content_for_layout;
                    ?>
                    <div class="clear"></div>
                </div>


                 <div class="footer-other">
                    <div class="outergray">
                        <div class="innergray">
                            <?php echo $this->element('footer'); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        echo $this->Html->script('application');
        echo $this->Html->script('home_page');
        echo $this->fetch('script');
        ?>
    </body>
</html>
