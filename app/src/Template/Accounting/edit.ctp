<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Accounting'), ['action' => 'edit', $accounting->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accounting->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accounting->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Accounting'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="accounting form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($accounting); ?>
    <fieldset>
        <legend><?= __('Edit Accounting') ?></legend>
        <?php
            echo $this->Form->input('tenant_id');
            echo $this->Form->input('payment_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
