<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Unit'), ['action' => 'edit', $unit->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $unit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Unit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Units'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="units form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($unit); ?>
    <fieldset>
        <legend><?= __('Edit Unit') ?></legend>
        <?php
            echo $this->Form->input('id_property');
            echo $this->Form->input('unit_number');
            echo $this->Form->input('size');
            echo $this->Form->input('market_rent');
            echo $this->Form->input('country');
            echo $this->Form->input('street');
            echo $this->Form->input('city');
            echo $this->Form->input('state');
            echo $this->Form->input('postal_code');
            echo $this->Form->input('bedrooms');
            echo $this->Form->input('bath');
            echo $this->Form->input('description');
            echo $this->Form->input('features');
            echo $this->Form->input('status');
            echo $this->Form->input('photo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
