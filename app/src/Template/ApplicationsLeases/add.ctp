<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Applications Lease'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="applicationsLeases form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($applicationsLease); ?>
    <fieldset>
        <legend><?= __('Add Applications Lease') ?></legend>
        <?php
            echo $this->Form->input('tenant_id');
            echo $this->Form->input('property_id');
            echo $this->Form->input('unit_id');
            echo $this->Form->input('type');
            echo $this->Form->input('start_date');
            echo $this->Form->input('end_date');
            echo $this->Form->input('recurring_charges_frequency');
            echo $this->Form->input('next_due_date');
            echo $this->Form->input('rent');
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
