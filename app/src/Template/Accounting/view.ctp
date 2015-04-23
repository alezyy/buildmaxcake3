<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Accounting'), ['action' => 'edit', $accounting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accounting'), ['action' => 'delete', $accounting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accounting->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="accounting view col-lg-10 col-md-9 columns">
    <h2><?= h($accounting->id) ?></h2>
    <div class="row">
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($accounting->id) ?></p>
                    <h6 class="subheader"><?= __('Tenant Id') ?></h6>
                    <p><?= $this->Number->format($accounting->tenant_id) ?></p>
                    <h6 class="subheader"><?= __('Payment Id') ?></h6>
                    <p><?= $this->Number->format($accounting->payment_id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
