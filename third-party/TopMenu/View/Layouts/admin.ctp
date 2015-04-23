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
        <?php
        
        // CSS
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('ionicons.min');
        echo $this->Html->css('font-awesome.min');
        echo $this->Html->css("http://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>");
        echo $this->Html->css('star-rating');
        echo $this->Html->css('style');
        
        echo $this->fetch('css');
        
        // Canonicals
        echo $this->element('canonicals'); 
        ?>
        
        <!-- Apple icons -->
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png"/>
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png"/>
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png"/>
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png"/>
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png"/>
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png"/>
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png"/>
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png"/>
        <link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196"/>
        <link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160"/>
        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96"/>
        <link rel="shortcut icon" type="image/png" href="/favicon.ico" sizes="16x16"/>
        <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
        <meta name="msapplication-TileColor" content="#da532c"/>
        <meta name="msapplication-TileImage" content="/mstile-144x144.png"/>
        <meta name="google-site-verification" content="v4lGo8dQ5cL2se8tOCGwUa1NkDfNMCIn66yAQ99aekU" />
        
    </head>
    <body>
            <?php echo $this->Html->script('jquery'); ?>
  
            <?php echo $this->element('topbar'); ?>

            <div class="container container-body">
                <div class="container-white">
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
            </div>


            <?php echo $this->element('footer'); ?>
            

        <?php
        // JS
        echo $this->Html->script('jquery');
        echo $this->Html->script('jquery.validate.min');
        echo $this->Html->script('validate.custom');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('application');
        echo $this->element('password_meter');
        echo $this->Html->script('password_meter', array('inline' => false));
        echo $this->Html->script('dropdown-login');
        echo $this->Html->script('star-rating');
        // echo $this->Html->script('provinces', array('inline' => false));
        echo $this->Js->writeBuffer();
        echo $this->fetch('script');
        ?>
    </body>
</html>
