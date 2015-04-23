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
        <link href='http://fonts.googleapis.com/css?family=Oxygen:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
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
        echo $this->Html->css($platformCheckoutCssPath . "main");
        echo $this->element('canonicals');
        ?>		

    </head>
    <body>
        <?php echo $this->element('google_analytics'); ?>
        <?php echo $this->Html->script('jquery'); ?>

        <?php echo $this->element('no_script'); ?>		
        <?php echo $this->element('please_wait'); ?>		


        <div id="content_wrapper">
            <div class="header">
                <div id="header">
                    <div id="header_wrapper">
                        <div class="left"> 
                                <?php
                                echo $this->Html->link( 
                                    "<img src ='/css/{$platformCheckoutCssPath}logo.jpg'/>",
                                    $this->Session->read('platform'). '?plordid=' . $this->Session->read('Order.plordid'), 
                                    array('escape' => false));                                    
                                ?>
                            <?php echo $location['Location']['name']; ?>
                        </div>
                        <div class="right">
                            <a href="<?php echo $this->Session->read('platform'). '?plordid=' . $this->Session->read('Order.plordid')?>">
                                <?php echo __('Back To Menu'); ?>
                            </a>
                        </div>
                       
                        <div class="clear"></div>        
                    </div>
                </div>
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
