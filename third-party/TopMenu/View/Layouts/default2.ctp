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
/**
 * @var $this View
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
        echo $meta_description;
        echo $meta_keywords;
        echo $meta_city;
        echo empty($meta_robot) ? '' : $meta_robot;
        echo empty($meta_zipcode) ? '' : $meta_zipcode;
        echo $meta_state;
        echo $this->Html->css('topmenu2');
        echo $this->fetch('css');
        echo $this->element('canonicals');
        ?>		

        <!-- Apple icon stuff -->
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
        <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"/>
        <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
        <meta name="msapplication-TileColor" content="#da532c"/>
        <meta name="msapplication-TileImage" content="/mstile-144x144.png"/>
        <meta name="google-site-verification" content="v4lGo8dQ5cL2se8tOCGwUa1NkDfNMCIn66yAQ99aekU" />
    </head>
    <body>
        <?php echo $this->element('google_analytics'); ?>
        <?php echo $this->Html->script('jquery'); ?>
        
        <?php echo $this->element('no_script'); ?>		
        <?php echo $this->element('please_wait'); ?>		

        <div id="content_wrapper">
            <div class="header">
                <?php echo $this->element('topbar'); ?>
            </div>				
            <div id="content_home">

                <div style='left:0px; margin-top:10px;'>
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
            // Data for javascript
            echo $this->Form->hidden('isDesktop', array('value' => (!$is_tablet || !$is_mobile), 'id' => 'isDesktop'));
            ?>

            <?php
            echo $this->Html->script('application');
            echo $this->Html->css('jquery-ui/jquery-ui-1.10.3.custom-highlight.min');
            echo $this->fetch('script');
            ?>
    </body>
</html>
