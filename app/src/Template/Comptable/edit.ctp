<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Comptable'), ['action' => 'edit', $comptable->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $comptable->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $comptable->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Comptable'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comptable'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="comptable form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($comptable); ?>
    <fieldset>
        <legend><?= __('Edit Comptable') ?></legend>
        <?php
            echo $this->Form->input('id_tenants');
            echo $this->Form->input('id_payments');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
