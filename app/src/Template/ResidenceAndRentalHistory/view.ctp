<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Residence And Rental History'), ['action' => 'edit', $residenceAndRentalHistory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Residence And Rental History'), ['action' => 'delete', $residenceAndRentalHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $residenceAndRentalHistory->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Residence And Rental History'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Residence And Rental History'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="residenceAndRentalHistory view col-lg-10 col-md-9 columns">
    <h2><?= h($residenceAndRentalHistory->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Address') ?></h6>
                    <p><?= h($residenceAndRentalHistory->address) ?></p>
                    <h6 class="subheader"><?= __('Landlord Or Manager Name') ?></h6>
                    <p><?= h($residenceAndRentalHistory->landlord_or_manager_name) ?></p>
                    <h6 class="subheader"><?= __('Landlord Or Manager Phone') ?></h6>
                    <p><?= h($residenceAndRentalHistory->landlord_or_manager_phone) ?></p>
                    <h6 class="subheader"><?= __('Reason For Leaving') ?></h6>
                    <p><?= h($residenceAndRentalHistory->reason_for_leaving) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($residenceAndRentalHistory->id) ?></p>
                    <h6 class="subheader"><?= __('Id Tenant') ?></h6>
                    <p><?= $this->Number->format($residenceAndRentalHistory->id_tenant) ?></p>
                    <h6 class="subheader"><?= __('Monthly Rent') ?></h6>
                    <p><?= $this->Number->format($residenceAndRentalHistory->monthly_rent) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Date Of Residency From') ?></h6>
                    <p><?= h($residenceAndRentalHistory->date_of_residency_from) ?></p>
                    <h6 class="subheader"><?= __('Date Of Residency To') ?></h6>
                    <p><?= h($residenceAndRentalHistory->date_of_residency_to) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Notes') ?></h6>
                    <?= $this->Text->autoParagraph(h($residenceAndRentalHistory->notes)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
