<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit City'), ['action' => 'edit', $city->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete City'), ['action' => 'delete', $city->id], ['confirm' => __('Are you sure you want to delete # {0}?', $city->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['controller' => 'Tenants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['controller' => 'Tenants', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="cities view col-lg-10 col-md-9 columns">
    <h2><?= h($city->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Country') ?></h6>
                    <p><?= $city->has('country') ? $this->Html->link($city->country->name, ['controller' => 'Countries', 'action' => 'view', $city->country->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('State') ?></h6>
                    <p><?= $city->has('state') ? $this->Html->link($city->state->id, ['controller' => 'States', 'action' => 'view', $city->state->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= h($city->city) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($city->id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Tenants') ?></h4>
    <?php if (!empty($city->tenants)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('First Name') ?></th>
                <th><?= __('Last Name') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Alternateemails Id') ?></th>
                <th><?= __('Cell Phone') ?></th>
                <th><?= __('Home Phone') ?></th>
                <th><?= __('Work Phone') ?></th>
                <th><?= __('Fax') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('State Id') ?></th>
                <th><?= __('Street') ?></th>
                <th><?= __('City Id') ?></th>
                <th><?= __('Zip') ?></th>
                <th><?= __('Birth Date') ?></th>
                <th><?= __('Driver License Number') ?></th>
                <th><?= __('Driver License State') ?></th>
                <th><?= __('Total Number Of Occupants') ?></th>
                <th><?= __('Unit Or Address Applying For') ?></th>
                <th><?= __('Requested Lease Term') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Emergency Contact') ?></th>
                <th><?= __('Emergency Contact Email') ?></th>
                <th><?= __('Emergency Contact Phone') ?></th>
                <th><?= __('Relationship To Tenant') ?></th>
                <th><?= __('Co Signer Details') ?></th>
                <th><?= __('Notes') ?></th>
                <th><?= __('Photo') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($city->tenants as $tenants): ?>
            <tr>
                <td><?= h($tenants->id) ?></td>
                <td><?= h($tenants->first_name) ?></td>
                <td><?= h($tenants->last_name) ?></td>
                <td><?= h($tenants->email) ?></td>
                <td><?= h($tenants->alternateemails_id) ?></td>
                <td><?= h($tenants->cell_phone) ?></td>
                <td><?= h($tenants->home_phone) ?></td>
                <td><?= h($tenants->work_phone) ?></td>
                <td><?= h($tenants->fax) ?></td>
                <td><?= h($tenants->country_id) ?></td>
                <td><?= h($tenants->state_id) ?></td>
                <td><?= h($tenants->street) ?></td>
                <td><?= h($tenants->city_id) ?></td>
                <td><?= h($tenants->zip) ?></td>
                <td><?= h($tenants->birth_date) ?></td>
                <td><?= h($tenants->driver_license_number) ?></td>
                <td><?= h($tenants->driver_license_state) ?></td>
                <td><?= h($tenants->total_number_of_occupants) ?></td>
                <td><?= h($tenants->unit_or_address_applying_for) ?></td>
                <td><?= h($tenants->requested_lease_term) ?></td>
                <td><?= h($tenants->status) ?></td>
                <td><?= h($tenants->emergency_contact) ?></td>
                <td><?= h($tenants->emergency_contact_email) ?></td>
                <td><?= h($tenants->emergency_contact_phone) ?></td>
                <td><?= h($tenants->relationship_to_tenant) ?></td>
                <td><?= h($tenants->co_signer_details) ?></td>
                <td><?= h($tenants->notes) ?></td>
                <td><?= h($tenants->photo) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Tenants', 'action' => 'view', $tenants->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Tenants', 'action' => 'edit', $tenants->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Tenants', 'action' => 'delete', $tenants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenants->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>