<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Accounting'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="accounting form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($accounting); ?>
    <fieldset>
        <legend><?= __('Add Accounting') ?></legend>
        <?php
            echo $this->Form->input('tenant_id');
            echo $this->Form->input('payment_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
