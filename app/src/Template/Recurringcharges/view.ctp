<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Recurringcharge'), ['action' => 'edit', $recurringcharge->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recurringcharge'), ['action' => 'delete', $recurringcharge->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recurringcharge->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Recurringcharges'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recurringcharge'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="recurringcharges view col-lg-10 col-md-9 columns">
    <h2><?= h($recurringcharge->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Frequency') ?></h6>
                    <p><?= h($recurringcharge->frequency) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($recurringcharge->id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related ApplicationsLeases') ?></h4>
    <?php if (!empty($recurringcharge->applications_leases)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Tenant Id') ?></th>
                <th><?= __('Property Id') ?></th>
                <th><?= __('Unit Id') ?></th>
                <th><?= __('Leasestype Id') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Automatically End The Lease') ?></th>
                <th><?= __('Recurringcharge Id') ?></th>
                <th><?= __('Next Due Date') ?></th>
                <th><?= __('Rent Mount') ?></th>
                <th><?= __('Security Deposit') ?></th>
                <th><?= __('Security Deposit Date') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Notes') ?></th>
                <th><?= __('Agreement') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($recurringcharge->applications_leases as $applicationsLeases): ?>
            <tr>
                <td><?= h($applicationsLeases->id) ?></td>
                <td><?= h($applicationsLeases->tenant_id) ?></td>
                <td><?= h($applicationsLeases->property_id) ?></td>
                <td><?= h($applicationsLeases->unit_id) ?></td>
                <td><?= h($applicationsLeases->leasestype_id) ?></td>
                <td><?= h($applicationsLeases->start_date) ?></td>
                <td><?= h($applicationsLeases->end_date) ?></td>
                <td><?= h($applicationsLeases->automatically_end_the_lease) ?></td>
                <td><?= h($applicationsLeases->recurringcharge_id) ?></td>
                <td><?= h($applicationsLeases->next_due_date) ?></td>
                <td><?= h($applicationsLeases->rent_mount) ?></td>
                <td><?= h($applicationsLeases->security_deposit) ?></td>
                <td><?= h($applicationsLeases->security_deposit_date) ?></td>
                <td><?= h($applicationsLeases->status) ?></td>
                <td><?= h($applicationsLeases->notes) ?></td>
                <td><?= h($applicationsLeases->agreement) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'ApplicationsLeases', 'action' => 'view', $applicationsLeases->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'ApplicationsLeases', 'action' => 'edit', $applicationsLeases->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'ApplicationsLeases', 'action' => 'delete', $applicationsLeases->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applicationsLeases->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
