<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Property'), ['action' => 'edit', $property->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $property->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $property->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Property'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Properties'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="properties form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($property); ?>
    <fieldset>
        <legend><?= __('Edit Property') ?></legend>
        <?php
            echo $this->Form->input('property_name');
            echo $this->Form->input('id_unit');
            echo $this->Form->input('type');
            echo $this->Form->input('number_of_units');
            echo $this->Form->input('id_rental_owner');
            echo $this->Form->input('operating_account');
            echo $this->Form->input('property_reserve');
            echo $this->Form->input('rental_amount');
            echo $this->Form->input('deposit_amount');
            echo $this->Form->input('lease_term');
            echo $this->Form->input('country');
            echo $this->Form->input('street');
            echo $this->Form->input('City');
            echo $this->Form->input('State');
            echo $this->Form->input('ZIP');
            echo $this->Form->input('photo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
