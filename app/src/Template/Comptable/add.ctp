<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Comptable'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comptable'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="comptable form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($comptable); ?>
    <fieldset>
        <legend><?= __('Add Comptable') ?></legend>
        <?php
            echo $this->Form->input('id_tenants');
            echo $this->Form->input('id_payments');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
