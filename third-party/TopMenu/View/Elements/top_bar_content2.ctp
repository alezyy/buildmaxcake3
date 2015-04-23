<div class="toplinks">
    <ul>
        <li>
            <?php
            if ($language == 'fr') {
				echo $this->Html->link('English', $changeLanguageUrl);  // do not use get text for this string (because on the french site we want the english written in english)
            } else {
				echo $this->Html->link('Français', $changeLanguageUrl); // do not use get text for this string ...
            }
            ?>
        </li>
        <span class="divider">|</span>
        <li>
            <?php
            if (!$user_id) {    
                echo $this->Html->link(__('Sign In'), 
                    array(
                        'controller' => 'users',
                        'action'     => 'login',
                        'admin'      => false), 
                    array(
                        'icon' => 'icon-lock'));
            } else {
                echo $this->Html->link(__('Logout'), 
                    array(
                        'controller' => 'users',
                        'action'     => 'logout',
                        'admin'      => false), 
                    array(
                        'icon' => 'icon-off'));
            }
            ?>
        </li>
        <span class="divider">|</span>
        <li>
            <?php
            if (!$user_id) {
                echo $this->Html->link(__('Register'), 
                    array(
                        'controller' => 'users',
                        'action'     => 'register',
                        'admin'      => false), 
                    array(
                        'icon' => 'icon-edit'));
            } else {
                echo $this->Html->link(__('My Account'), 
                    array(
                        'controller' => 'users',
                        'action'     => 'my_account',
                        'admin'      => false), 
                    array(
                        'icon' => 'icon-user'));
            }
            ?>
        </li>
    </ul>
</div>
<div class="clear"></div>

