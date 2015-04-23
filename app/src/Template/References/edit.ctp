<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Reference'), ['action' => 'edit', $reference->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reference->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reference->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Reference'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List References'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="references form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($reference); ?>
    <fieldset>
        <legend><?= __('Edit Reference') ?></legend>
        <?php
            echo $this->Form->input('id_tenant');
            echo $this->Form->input('reference_first_name_1');
            echo $this->Form->input('reference_last_name_1');
            echo $this->Form->input('phone_1');
            echo $this->Form->input('first_name_2');
            echo $this->Form->input('last_name_2');
            echo $this->Form->input('phone_2');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
