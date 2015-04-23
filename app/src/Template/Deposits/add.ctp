<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Deposit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Deposits'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="deposits form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($deposit); ?>
    <fieldset>
        <legend><?= __('Add Deposit') ?></legend>
        <?php
            echo $this->Form->input('security_deposit');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
