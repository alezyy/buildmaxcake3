<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Propertiestype'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Propertiestypes'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="propertiestypes form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($propertiestype); ?>
    <fieldset>
        <legend><?= __('Add Propertiestype') ?></legend>
        <?php
            echo $this->Form->input('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
