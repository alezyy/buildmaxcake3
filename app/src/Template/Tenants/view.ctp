<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Tenant'), ['action' => 'edit', $tenant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tenant'), ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Tenants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tenant'), ['action' => 'add']) ?> </li>
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
                    <h6 class="subheader"><?= __('Phone') ?></h6>
                    <p><?= h($tenant->phone) ?></p>
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
                    <h6 class="subheader"><?= __('Notes') ?></h6>
                    <?= $this->Text->autoParagraph(h($tenant->notes)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
