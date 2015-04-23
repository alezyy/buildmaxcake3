<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Recurringcharge'), ['action' => 'edit', $recurringcharge->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $recurringcharge->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $recurringcharge->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Recurringcharge'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recurringcharges'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="recurringcharges form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($recurringcharge); ?>
    <fieldset>
        <legend><?= __('Edit Recurringcharge') ?></legend>
        <?php
            echo $this->Form->input('frequency');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
