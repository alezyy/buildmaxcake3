<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Comptable'), ['action' => 'edit', $comptable->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Comptable'), ['action' => 'delete', $comptable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comptable->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Comptable'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comptable'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="comptable view col-lg-10 col-md-9 columns">
    <h2><?= h($comptable->id) ?></h2>
    <div class="row">
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($comptable->id) ?></p>
                    <h6 class="subheader"><?= __('Id Tenants') ?></h6>
                    <p><?= $this->Number->format($comptable->id_tenants) ?></p>
                    <h6 class="subheader"><?= __('Id Payments') ?></h6>
                    <p><?= $this->Number->format($comptable->id_payments) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
