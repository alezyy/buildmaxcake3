<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Propertiestypes Specification'), ['action' => 'edit', $propertiestypesSpecification->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $propertiestypesSpecification->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $propertiestypesSpecification->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Propertiestypes Specification'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Propertiestypes Specifications'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Propertiestypes'), ['controller' => 'Propertiestypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Propertiestype'), ['controller' => 'Propertiestypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="propertiestypesSpecifications form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($propertiestypesSpecification); ?>
    <fieldset>
        <legend><?= __('Edit Propertiestypes Specification') ?></legend>
        <?php
            echo $this->Form->input('propertiestype_id', ['options' => $propertiestypes]);
            echo $this->Form->input('propertiestypes_specification');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
