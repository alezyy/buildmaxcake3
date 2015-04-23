<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Marital Status'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Marital Status'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="maritalStatus form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($maritalStatus); ?>
    <fieldset>
        <legend><?= __('Add Marital Status') ?></legend>
        <?php
            echo $this->Form->input('marital_status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
