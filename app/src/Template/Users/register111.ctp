<div class="page-header">
	<h1><?php echo __('Register'); ?></h1>
</div>

 <div class="users form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($user); ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('email');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('salt');
            echo $this->Form->input('group_id', ['options' => $groups]);
            echo $this->Form->input('role');
            echo $this->Form->input('is_active');
            echo $this->Form->input('last_login');
            echo $this->Form->input('last_ip');
            echo $this->Form->input('old_salt');
            echo $this->Form->input('old_hash');
            echo $this->Form->input('force_reset');
            echo $this->Form->input('fraudulent');
        ?>
    </fieldset>

    
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-lg btn-primary btn-block', 'id' => 'registerFormSubmit']) ?>
    <?= $this->Form->end() ?>
</div>


<div class="form-group col-xs-12">
    <?php // echo $this->Form->submit(__('Sign Up!'), array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'registerFormSubmit')); ?>
</div>
 <?php echo $this->Form->End(); ?>

<div class="col-xs-12 col-md-5 col-lg-5 pull-right text-right panel panel-default" id="steps">
    <a href="/<?php echo $langSuffix ?>/faq"> 
        <h2 class="text-red">
            <span class=""><?php echo __('How does'); ?></span><br/>
            <span class=""><?php echo __('it work?'); ?></span>
        </h2>
        <div class="col-xs-10">
            <h1><strong><?php echo __('1.'); ?></strong></h1>
            <p><?php echo __('Enter your postal code'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/code-postal.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Code postal",
    "title" => "Code postal"
                )
            ); ?>
        </div>
        <div class="col-xs-10">
            <h2><strong><?php echo __('2.'); ?></strong></h2>
            <p><?php echo __('Choose a restaurant'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/choix.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Choix"
                )
            ); ?>
        </div>   
        <div class="col-xs-10">
            <h3><strong><?php echo __('3.'); ?></strong></h3>
            <p><?php echo __('Confirm your order'); ?></p>
        </div>
        <div class="col-xs-2">
            <?php echo $this->Html->image('home_page/commande.png', array(
                    'width' => 'auto',
                    'height' => 70,
    "alt" => "Commande"
                )
            ); ?>
        </div>
    </a>     
</div>

<?php echo $this->element('password_meter');
    echo $this->Html->script('password_meter', array('inline' => false)); ?>
