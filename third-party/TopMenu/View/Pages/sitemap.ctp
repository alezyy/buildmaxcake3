<div class="container-white">
    
    <div class="row directory">
        <div class="page-header">
            <h1><?php echo __("Sitemap"); ?></h1>               
        </div>

        <ul class="list-group">
            <li class="list-group-item">
                 <?php
                echo $this->Html->link(
                    __('Home'), array(
                    'controller' => 'homes',
                    'action' => 'index'),
                    array('icon' => 'ion-home'));
                ?>
            </li>
            
             <li class="list-group-item">
                 <?php echo $this->Html->link(
                     __("All cuisines types"), 
                     array(
                         'controller' => 'cuisines',
                         'action'=> 'index'),
                    array('icon' => ''));
                     ?>
            </li>

            <li class="list-group-item">
                <?php
                echo $this->Html->link(__("Sectors"), 
                    array(
                        'controller' => 'sectors',
                        'action' => 'index'),
                    array('icon' => ''));
                ?>
            </li>
            <li class="list-group-item">
                <?php
                if ($language == 'fr') {
                    echo $this->Html->link(__('English site'), '/en' , array('icon' => 'icon-font'));
                } else {
                    echo $this->Html->link(__('Site français'), '/fr', array('icon' => 'icon-font'));
                }
                ?>
            </li>
            
            <li class="list-group-item">
                <?php 
                    echo $this->Html->link(__('FAQ'), 
                        array('controller' => 'pages', 'action' => 'user_guide'),
                        array('icon' => 'icon-question-sign'));
                ?>
            </li>
            
            <li class="list-group-item">
                <a href="javascript:void(0)" onclick="return popitup('http://www.providesupport.com/?messenger=topmenuweb')"><i class="icon-comment" style="margin-right:3px;"></i><?php echo __('Client support');?></a>                    
            </li>   
            
            <li class="list-group-item">
                <?php
                echo $this->Html->link(
                    __('Terms and conditions.'), array(
                    'controller' => 'pages',
                    'action' => 'display',
                    'escape' => false,
                    'terms'),
                    array('icon' => 'icon-file'));
                ?>
            </li>
            
            <li class="list-group-item">
                <a href="<?php echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=mobile;path=/';">
                    <i class="icon-home" style="margin-right:3px;"></i><?php echo __('Mobile site') ?></a>
            </li>
            
            <li class="list-group-item">
                <?php
                echo $this->Html->link(
                    __('About us'), array(
                    'controller' => 'pages',
                    'action' => 'about_us'),
                    array('icon' => 'icon-info-sign'));
                ?>
            </li>

            <li class="list-group-item">
                <?php
                echo $this->Html->link(
                    __('Contact-Us'), array(
                    'controller' => 'contacts',
                    'action' => 'index'),
                    array('icon' => 'icon-envelope'));
                ?>
            </li>

            <li class="list-group-item">
                <?php
                echo $this->Html->link(
                    __('Add your restaurant'), array(
                    'controller' => 'restaurants',
                    'action' => 'add_restaurant'),
                    array('icon' => 'icon-plus-sign'));
                ?>
            </li>

            <li class="list-group-item">
                <?php
                if (!$user_id) {
                    echo $this->Html->link(
                        __('Sign In'), 
                            array(
                            'controller' => 'users',
                            'action' => 'login',
                            'admin' => false), 
                        array(
                            'icon' => 'icon-lock'));
                } else {
                    echo $this->Html->link(
                        __('Logout'), array(
                        'controller' => 'users',
                        'action' => 'logout',
                        'admin' => false
                        ), array(
                        'icon' => 'icon-off'
                        )
                    );
                }
                ?>
            </li>

            <li class="list-group-item">
                <?php
                if (!$user_id) {
                    echo $this->Html->link(
                        __('Register'), array(
                        'controller' => 'users',
                        'action' => 'register',
                        'admin' => false
                        ), array(
                        'icon' => 'icon-edit'
                        )
                    );
                } else {
                    echo $this->Html->link(
                        __('My Account'), array(
                        'controller' => 'users',
                        'action' => 'my_account',
                        'admin' => false
                        ), array(
                        'icon' => 'icon-user'
                        )
                    );
                }
                ?>
            </li>

        </ul>
    </div>

    
</div>