<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Membership Group'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Membership Groups'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipGroups form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($membershipGroup); ?>
    <fieldset>
        <legend><?= __('Add Membership Group') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('description');
            echo $this->Form->input('allowSignup');
            echo $this->Form->input('needsApproval');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
