<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Country'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="countries form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($country); ?>
    <fieldset>
        <legend><?= __('Add Country') ?></legend>
        <?php
            echo $this->Form->input('country');
            echo $this->Form->input('name');
            echo $this->Form->input('paypal');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
