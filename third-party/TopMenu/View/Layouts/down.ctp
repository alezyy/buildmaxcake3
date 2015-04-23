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
        echo $this->Html->css('topmenu-down');
        echo $this->fetch('css');
        ?>
        <meta name="google-site-verification" content="v4lGo8dQ5cL2se8tOCGwUa1NkDfNMCIn66yAQ99aekU" />
        <link rel="canonical" href="<?php echo $defaultCononical; ?>"/>
    </head>
    <body>
        <?php echo $this->element('google_analytics'); ?>
            <div id="content_wrapper">
                <div class="header">
                    <?php echo $this->element('topbar_down'); ?>
                </div>
                

                <div id="content_home">
                    <?php
                    echo $content_for_layout;
                    ?>
                    <div class="clear"></div>
                </div>
            </div>
    </body>
</html>
