<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Membership Userrecord'), ['action' => 'edit', $membershipUserrecord->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $membershipUserrecord->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUserrecord->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Membership Userrecord'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Membership Userrecords'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipUserrecords form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($membershipUserrecord); ?>
    <fieldset>
        <legend><?= __('Edit Membership Userrecord') ?></legend>
        <?php
            echo $this->Form->input('tableName');
            echo $this->Form->input('pkValue');
            echo $this->Form->input('id_membership_user');
            echo $this->Form->input('dateAdded');
            echo $this->Form->input('dateUpdated');
            echo $this->Form->input('id_membership_group');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
