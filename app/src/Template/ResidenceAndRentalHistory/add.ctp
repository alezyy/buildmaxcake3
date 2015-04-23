<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Residence And Rental History'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Residence And Rental History'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="residenceAndRentalHistory form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($residenceAndRentalHistory); ?>
    <fieldset>
        <legend><?= __('Add Residence And Rental History') ?></legend>
        <?php
            echo $this->Form->input('id_tenant');
            echo $this->Form->input('address');
            echo $this->Form->input('landlord_or_manager_name');
            echo $this->Form->input('landlord_or_manager_phone');
            echo $this->Form->input('monthly_rent');
            echo $this->Form->input('date_of_residency_from');
            echo $this->Form->input('date_of_residency_to');
            echo $this->Form->input('reason_for_leaving');
            echo $this->Form->input('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
