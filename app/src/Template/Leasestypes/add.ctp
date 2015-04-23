<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Leasestype'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Leasestypes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="leasestypes form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($leasestype); ?>
    <fieldset>
        <legend><?= __('Add Leasestype') ?></legend>
        <?php
            echo $this->Form->input('type_lease');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
