<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Alternateemail'), ['action' => 'edit', $alternateemail->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $alternateemail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $alternateemail->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Alternateemail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alternateemails'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="alternateemails form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($alternateemail); ?>
    <fieldset>
        <legend><?= __('Edit Alternateemail') ?></legend>
        <?php
            echo $this->Form->input('tenant_id', ['options' => $tenants]);
            echo $this->Form->input('alternate_email');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
