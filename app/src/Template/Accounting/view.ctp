<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Accounting'), ['action' => 'edit', $accounting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accounting'), ['action' => 'delete', $accounting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accounting->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="accounting view col-lg-10 col-md-9 columns">
    <h2><?= h($accounting->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Tenant') ?></h6>
                    <p><?= $accounting->has('tenant') ? $this->Html->link($accounting->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $accounting->tenant->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Payment') ?></h6>
                    <p><?= $accounting->has('payment') ? $this->Html->link($accounting->payment->id, ['controller' => 'Payments', 'action' => 'view', $accounting->payment->id]) : '' ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($accounting->id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
