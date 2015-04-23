<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Rental Owner'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rental Owners'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="rentalOwners form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($rentalOwner); ?>
    <fieldset>
        <legend><?= __('Add Rental Owner') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('company_name');
            echo $this->Form->input('date_of_birth');
            echo $this->Form->input('primary_email');
            echo $this->Form->input('alternate_email');
            echo $this->Form->input('phone');
            echo $this->Form->input('country');
            echo $this->Form->input('street');
            echo $this->Form->input('city');
            echo $this->Form->input('state');
            echo $this->Form->input('zip');
            echo $this->Form->input('comments');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
