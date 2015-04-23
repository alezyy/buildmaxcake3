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
                    <h6 class="subheader"><?= __('Country Id') ?></h6>
                    <p><?= $this->Number->format($tenant->country_id) ?></p>
                    <h6 class="subheader"><?= __('State Id') ?></h6>
                    <p><?= $this->Number->format($tenant->state_id) ?></p>
                    <h6 class="subheader"><?= __('City Id') ?></h6>
                    <p><?= $this->Number->format($tenant->city_id) ?></p>
                    <h6 class="subheader"><?= __('Zip') ?></h6>
                    <p><?= $this->Number->format($tenant->zip) ?></p>
                    <h6 class="subheader"><?= __('Marital Status Id') ?></h6>
                    <p><?= $this->Number->format($tenant->marital_status_id) ?></p>
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
