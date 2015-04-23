<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Accounting'), ['action' => 'edit', $accounting->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accounting->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accounting->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Accounting'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounting'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="accounting form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($accounting); ?>
    <fieldset>
        <legend><?= __('Edit Accounting') ?></legend>
        <?php
            echo $this->Form->input('tenant_id', ['options' => $tenants]);
            echo $this->Form->input('payment_id', ['options' => $payments]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
