<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Applications Lease'), ['action' => 'edit', $applicationsLease->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Applications Lease'), ['action' => 'delete', $applicationsLease->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applicationsLease->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="applicationsLeases view col-lg-10 col-md-9 columns">
    <h2><?= h($applicationsLease->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Tenant') ?></h6>
                    <p><?= $applicationsLease->has('tenant') ? $this->Html->link($applicationsLease->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $applicationsLease->tenant->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Property') ?></h6>
                    <p><?= $applicationsLease->has('property') ? $this->Html->link($applicationsLease->property->id, ['controller' => 'Properties', 'action' => 'view', $applicationsLease->property->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Unit') ?></h6>
                    <p><?= $applicationsLease->has('unit') ? $this->Html->link($applicationsLease->unit->id, ['controller' => 'Units', 'action' => 'view', $applicationsLease->unit->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Rent Mount') ?></h6>
                    <p><?= h($applicationsLease->rent_mount) ?></p>
                    <h6 class="subheader"><?= __('Status') ?></h6>
                    <p><?= h($applicationsLease->status) ?></p>
                    <h6 class="subheader"><?= __('Agreement') ?></h6>
                    <p><?= h($applicationsLease->agreement) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($applicationsLease->id) ?></p>
                    <h6 class="subheader"><?= __('Leasestype Id') ?></h6>
                    <p><?= $this->Number->format($applicationsLease->leasestype_id) ?></p>
                    <h6 class="subheader"><?= __('Recurringcharge Id') ?></h6>
                    <p><?= $this->Number->format($applicationsLease->recurringcharge_id) ?></p>
                    <h6 class="subheader"><?= __('Security Deposit') ?></h6>
                    <p><?= $this->Number->format($applicationsLease->security_deposit) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Start Date') ?></h6>
                    <p><?= h($applicationsLease->start_date) ?></p>
                    <h6 class="subheader"><?= __('End Date') ?></h6>
                    <p><?= h($applicationsLease->end_date) ?></p>
                    <h6 class="subheader"><?= __('Next Due Date') ?></h6>
                    <p><?= h($applicationsLease->next_due_date) ?></p>
                    <h6 class="subheader"><?= __('Security Deposit Date') ?></h6>
                    <p><?= h($applicationsLease->security_deposit_date) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Automatically End The Lease') ?></h6>
                    <p><?= $applicationsLease->automatically_end_the_lease ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Notes') ?></h6>
                    <?= $this->Text->autoParagraph(h($applicationsLease->notes)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
