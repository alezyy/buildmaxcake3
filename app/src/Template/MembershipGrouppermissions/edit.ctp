<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Membership Grouppermission'), ['action' => 'edit', $membershipGrouppermission->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $membershipGrouppermission->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $membershipGrouppermission->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Membership Grouppermission'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Membership Grouppermissions'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipGrouppermissions form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($membershipGrouppermission); ?>
    <fieldset>
        <legend><?= __('Edit Membership Grouppermission') ?></legend>
        <?php
            echo $this->Form->input('id_membership_group');
            echo $this->Form->input('tableName');
            echo $this->Form->input('allowInsert');
            echo $this->Form->input('allowView');
            echo $this->Form->input('allowEdit');
            echo $this->Form->input('allowDelete');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
