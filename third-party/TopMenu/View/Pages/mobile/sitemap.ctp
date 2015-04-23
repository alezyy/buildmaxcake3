
<ul>
    <li>
        <?php
        echo $this->Html->link(
            __('Home'), array(
            'controller' => 'homes',
            'action'     => 'index'), array('icon' => 'icon-home'));
        ?>
    </li>

    <li>
        <?php
        echo $this->Html->link(
            __("All cuisines types"), array(
            'controller' => 'cuisines',
            'action'     => 'view'), array('icon' => 'icon-th-list'));
        ?>
    </li>

    <li>
<?php
echo $this->Html->link(__("Sectors from 'A' to 'N'"), array(
    'controller' => 'sectors',
    'action'     => 'view',
    'start'      => 'A',
    'end'        => 'N'), array('icon' => 'icon-globe'));
?>
    </li>
    <li >
        <?php
        echo $this->Html->link(__("Sectors from 'N' to 'Z'"), array(
            'controller' => 'sectors',
            'action'     => 'view',
            'start'      => 'N',
            'end'        => 'Z'), array('icon' => 'icon-globe'));
        ?>
    </li>
    <li>
        <?php
        if ($language == 'fr') {
            echo $this->Html->link(__('English site'), '/en', array('icon' => 'icon-font'));
        } else {
            echo $this->Html->link(__('Site français'), '/fr', array('icon' => 'icon-font'));
        }
        ?>
    </li>

    <li>
        <?php
        echo $this->Html->link(__('FAQ'), array('controller' => 'pages', 'action' => 'user_guide'), array('icon' => 'icon-question-sign'));
        ?>
    </li>

    <li>
        <a href="javascript:void(0)" onclick="return popitup('http://www.providesupport.com/?messenger=topmenuweb')"><i class="icon-comment" style="margin-right:3px;"></i><?php echo __('Client support'); ?></a>                    
    </li>   

    <li>
        <?php
        echo $this->Html->link(
            __('Terms and conditions.'), array(
            'controller' => 'pages',
            'action'     => 'display',
            'escape'     => false,
            'terms'), array('icon' => 'icon-file'));
        ?>
    </li>

    <li>
        <a href="<?php echo $this->request->here; ?>" onclick="document.cookie = 'siteversion=mobile;path=/';">
            <i class="icon-home" style="margin-right:3px;"></i><?php echo __('Mobile site') ?></a>
    </li>

    <li>
        <?php
        echo $this->Html->link(
            __('About us'), array(
            'controller' => 'pages',
            'action'     => 'about_us'), array('icon' => 'icon-info-sign'));
        ?>
    </li>

    <li>
        <?php
        echo $this->Html->link(
            __('Contact-Us'), array(
            'controller' => 'contacts',
            'action'     => 'index'), array('icon' => 'icon-envelope'));
        ?>
    </li>

    <li>
        <?php
        echo $this->Html->link(
            __('Add your restaurant'), array(
            'controller' => 'restaurants',
            'action'     => 'add_restaurant'), array('icon' => 'icon-plus-sign'));
        ?>
    </li>

    <li>
<?php
if (!$user_id) {
    echo $this->Html->link(
        __('Sign In'), array(
        'controller' => 'users',
        'action'     => 'login',
        'admin'      => false), array(
        'icon' => 'icon-lock'));
} else {
    echo $this->Html->link(
        __('Logout'), array(
        'controller' => 'users',
        'action'     => 'logout',
        'admin'      => false
        ), array(
        'icon' => 'icon-off'
        )
    );
}
?>
    </li>

    <li>
        <?php
        if (!$user_id) {
            echo $this->Html->link(
                __('Register'), array(
                'controller' => 'users',
                'action'     => 'register',
                'admin'      => false
                ), array(
                'icon' => 'icon-edit'
                )
            );
        } else {
            echo $this->Html->link(
                __('My Account'), array(
                'controller' => 'users',
                'action'     => 'my_account',
                'admin'      => false
                ), array(
                'icon' => 'icon-user'
                )
            );
        }
        ?>
    </li>

</ul>