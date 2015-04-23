<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Applications Lease'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="applicationsLeases form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($applicationsLease); ?>
    <fieldset>
        <legend><?= __('Add Applications Lease') ?></legend>
        <?php
            echo $this->Form->input('tenant_id', ['options' => $tenants, 'empty' => true]);
            echo $this->Form->input('property_id', ['options' => $properties, 'empty' => true]);
            echo $this->Form->input('unit_id', ['options' => $units, 'empty' => true]);
            echo $this->Form->input('leasestype_id');
            echo $this->Form->input('start_date');
            echo $this->Form->input('end_date');
            echo $this->Form->input('automatically_end_the_lease');
            echo $this->Form->input('recurringcharge_id');
            echo $this->Form->input('next_due_date');
            echo $this->Form->input('rent_mount');
            echo $this->Form->input('security_deposit');
            echo $this->Form->input('security_deposit_date');
            echo $this->Form->input('status');
            echo $this->Form->input('notes');
            echo $this->Form->input('agreement');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
