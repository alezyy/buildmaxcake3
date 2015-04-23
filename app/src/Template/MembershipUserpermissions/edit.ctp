<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Membership Userpermission'), ['action' => 'edit', $membershipUserpermission->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $membershipUserpermission->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUserpermission->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Membership Userpermission'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Membership Userpermissions'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipUserpermissions form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($membershipUserpermission); ?>
    <fieldset>
        <legend><?= __('Edit Membership Userpermission') ?></legend>
        <?php
            echo $this->Form->input('id_membership_user');
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
