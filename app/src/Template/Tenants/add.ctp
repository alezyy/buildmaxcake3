<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Tenant'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alternateemails'), ['controller' => 'Alternateemails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alternateemail'), ['controller' => 'Alternateemails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting'), ['controller' => 'Accounting', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting'), ['controller' => 'Accounting', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comptable1'), ['controller' => 'Comptable1', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comptable1'), ['controller' => 'Comptable1', 'action' => 'add']) ?> </li>
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
            echo $this->Form->input('alternateemails_id');
            echo $this->Form->input('cell_phone');
            echo $this->Form->input('home_phone');
            echo $this->Form->input('work_phone');
            echo $this->Form->input('fax');
            echo $this->Form->input('country_id', ['options' => $countries]);
            echo $this->Form->input('state_id', ['options' => $states]);
            echo $this->Form->input('street');
            echo $this->Form->input('city_id', ['options' => $cities]);
            echo $this->Form->input('zip');
            echo $this->Form->input('birth_date');
            echo $this->Form->input('driver_license_number');
            echo $this->Form->input('driver_license_state');
            echo $this->Form->input('total_number_of_occupants');
            echo $this->Form->input('unit_or_address_applying_for');
            echo $this->Form->input('requested_lease_term');
            echo $this->Form->input('status');
            echo $this->Form->input('emergency_contact');
            echo $this->Form->input('emergency_contact_email');
            echo $this->Form->input('emergency_contact_phone');
            echo $this->Form->input('relationship_to_tenant');
            echo $this->Form->input('co_signer_details');
            echo $this->Form->input('notes');
            echo $this->Form->input('photo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
