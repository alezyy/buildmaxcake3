<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Tenant'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="tenants form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($tenant); ?>
    <fieldset>
        <legend><?= __('Add Tenant') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('email');
            echo $this->Form->input('phone');
            echo $this->Form->input('birth_date');
            echo $this->Form->input('driver_license_number');
            echo $this->Form->input('driver_license_state');
            echo $this->Form->input('total_number_of_occupants');
            echo $this->Form->input('unit_or_address_applying_for');
            echo $this->Form->input('requested_lease_term');
            echo $this->Form->input('status');
            echo $this->Form->input('emergency_contact');
            echo $this->Form->input('co_signer_details');
            echo $this->Form->input('notes');
            echo $this->Form->input('photo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
