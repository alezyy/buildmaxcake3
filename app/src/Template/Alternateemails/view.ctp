<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Alternateemail'), ['action' => 'edit', $alternateemail->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alternateemail'), ['action' => 'delete', $alternateemail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alternateemail->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Alternateemails'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alternateemail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="alternateemails view col-lg-10 col-md-9 columns">
    <h2><?= h($alternateemail->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Tenant') ?></h6>
                    <p><?= $alternateemail->has('tenant') ? $this->Html->link($alternateemail->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $alternateemail->tenant->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Alternate Email') ?></h6>
                    <p><?= h($alternateemail->alternate_email) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($alternateemail->id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
