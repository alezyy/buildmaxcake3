<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Comptable1'), ['action' => 'edit', $comptable1->ID]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comptable1'), ['action' => 'delete', $comptable1->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $comptable1->ID), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Comptable1'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comptable1'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="comptable1 view col-lg-10 col-md-9 columns">
    <h2><?= h($comptable1->ID) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Tenant') ?></h6>
                    <p><?= $comptable1->has('tenant') ? $this->Html->link($comptable1->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $comptable1->tenant->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Payment') ?></h6>
                    <p><?= $comptable1->has('payment') ? $this->Html->link($comptable1->payment->id, ['controller' => 'Payments', 'action' => 'view', $comptable1->payment->id]) : '' ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('ID') ?></h6>
                    <p><?= $this->Number->format($comptable1->ID) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
