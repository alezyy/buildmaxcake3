
<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Tenant'), ['action' => 'edit', $tenant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tenant'), ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alternateemails'), ['controller' => 'Alternateemails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alternateemail'), ['controller' => 'Alternateemails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting'), ['controller' => 'Accounting', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting'), ['controller' => 'Accounting', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comptable1'), ['controller' => 'Comptable1', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comptable1'), ['controller' => 'Comptable1', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="tenants view col-lg-10 col-md-9 columns">
    <h2><?= h($tenant->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('First Name') ?></h6>
                    <p><?= h($tenant->first_name) ?></p>
                    <h6 class="subheader"><?= __('Last Name') ?></h6>
                    <p><?= h($tenant->last_name) ?></p>
                    <h6 class="subheader"><?= __('Email') ?></h6>
                    <p><?= h($tenant->email) ?></p>
                    <h6 class="subheader"><?= __('Alternateemails Id') ?></h6>
                    <p><?= h($tenant->alternateemails_id) ?></p>
                    <h6 class="subheader"><?= __('Cell Phone') ?></h6>
                    <p><?= h($tenant->cell_phone) ?></p>
                    <h6 class="subheader"><?= __('Home Phone') ?></h6>
                    <p><?= h($tenant->home_phone) ?></p>
                    <h6 class="subheader"><?= __('Work Phone') ?></h6>
                    <p><?= h($tenant->work_phone) ?></p>
                    <h6 class="subheader"><?= __('Fax') ?></h6>
                    <p><?= h($tenant->fax) ?></p>
                    <h6 class="subheader"><?= __('Country') ?></h6>
                    <p><?= $tenant->has('country') ? $this->Html->link($tenant->country->name, ['controller' => 'Countries', 'action' => 'view', $tenant->country->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('State') ?></h6>
                    <p><?= $tenant->has('state') ? $this->Html->link($tenant->state->id, ['controller' => 'States', 'action' => 'view', $tenant->state->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= $tenant->has('city') ? $this->Html->link($tenant->city->id, ['controller' => 'Cities', 'action' => 'view', $tenant->city->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Driver License Number') ?></h6>
                    <p><?= h($tenant->driver_license_number) ?></p>
                    <h6 class="subheader"><?= __('Driver License State') ?></h6>
                    <p><?= h($tenant->driver_license_state) ?></p>
                    <h6 class="subheader"><?= __('Total Number Of Occupants') ?></h6>
                    <p><?= h($tenant->total_number_of_occupants) ?></p>
                    <h6 class="subheader"><?= __('Unit Or Address Applying For') ?></h6>
                    <p><?= h($tenant->unit_or_address_applying_for) ?></p>
                    <h6 class="subheader"><?= __('Requested Lease Term') ?></h6>
                    <p><?= h($tenant->requested_lease_term) ?></p>
                    <h6 class="subheader"><?= __('Status') ?></h6>
                    <p><?= h($tenant->status) ?></p>
                    <h6 class="subheader"><?= __('Emergency Contact') ?></h6>
                    <p><?= h($tenant->emergency_contact) ?></p>
                    <h6 class="subheader"><?= __('Emergency Contact Email') ?></h6>
                    <p><?= h($tenant->emergency_contact_email) ?></p>
                    <h6 class="subheader"><?= __('Emergency Contact Phone') ?></h6>
                    <p><?= h($tenant->emergency_contact_phone) ?></p>
                    <h6 class="subheader"><?= __('Relationship To Tenant') ?></h6>
                    <p><?= h($tenant->relationship_to_tenant) ?></p>
                    <h6 class="subheader"><?= __('Co Signer Details') ?></h6>
                    <p><?= h($tenant->co_signer_details) ?></p>
                    <h6 class="subheader"><?= __('Photo') ?></h6>
                    <p><?= h($tenant->photo) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($tenant->id) ?></p>
                    <h6 class="subheader"><?= __('Zip') ?></h6>
                    <p><?= $this->Number->format($tenant->zip) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Birth Date') ?></h6>
                    <p><?= h($tenant->birth_date) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Street') ?></h6>
                    <?= $this->Text->autoParagraph(h($tenant->street)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Notes') ?></h6>
                    <?= $this->Text->autoParagraph(h($tenant->notes)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Alternateemails') ?></h4>
    <?php if (!empty($tenant->alternateemails)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Tenant Id') ?></th>
                <th><?= __('Alternate Email') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tenant->alternateemails as $alternateemails): ?>
            <tr>
                <td><?= h($alternateemails->id) ?></td>
                <td><?= h($alternateemails->tenant_id) ?></td>
                <td><?= h($alternateemails->alternate_email) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Alternateemails', 'action' => 'view', $alternateemails->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Alternateemails', 'action' => 'edit', $alternateemails->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Alternateemails', 'action' => 'delete', $alternateemails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alternateemails->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Accounting') ?></h4>
    <?php if (!empty($tenant->accounting)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Tenant Id') ?></th>
                <th><?= __('Payment Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tenant->accounting as $accounting): ?>
            <tr>
                <td><?= h($accounting->id) ?></td>
                <td><?= h($accounting->tenant_id) ?></td>
                <td><?= h($accounting->payment_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Accounting', 'action' => 'view', $accounting->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Accounting', 'action' => 'edit', $accounting->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Accounting', 'action' => 'delete', $accounting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accounting->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related ApplicationsLeases') ?></h4>
    <?php if (!empty($tenant->applications_leases)): ?>
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
            <?php foreach ($tenant->applications_leases as $applicationsLeases): ?>
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
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Comptable1') ?></h4>
    <?php if (!empty($tenant->comptable1)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('ID') ?></th>
                <th><?= __('Tenant Id') ?></th>
                <th><?= __('Payment Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tenant->comptable1 as $comptable1): ?>
            <tr>
                <td><?= h($comptable1->ID) ?></td>
                <td><?= h($comptable1->tenant_id) ?></td>
                <td><?= h($comptable1->payment_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Comptable1', 'action' => 'view', $comptable1->ID], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Comptable1', 'action' => 'edit', $comptable1->ID], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Comptable1', 'action' => 'delete', $comptable1->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $comptable1->ID), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
