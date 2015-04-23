<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Membership User'), ['action' => 'edit', $membershipUser->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $membershipUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUser->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Membership User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Membership Users'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipUsers form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($membershipUser); ?>
    <fieldset>
        <legend><?= __('Edit Membership User') ?></legend>
        <?php
            echo $this->Form->input('passMD5');
            echo $this->Form->input('email');
            echo $this->Form->input('signupDate');
            echo $this->Form->input('id_membership_group');
            echo $this->Form->input('isBanned');
            echo $this->Form->input('isApproved');
            echo $this->Form->input('custom1');
            echo $this->Form->input('custom2');
            echo $this->Form->input('custom3');
            echo $this->Form->input('custom4');
            echo $this->Form->input('comments');
            echo $this->Form->input('pass_reset_key');
            echo $this->Form->input('pass_reset_expiry');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
