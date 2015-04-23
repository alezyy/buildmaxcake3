<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Rental Owner'), ['action' => 'edit', $rentalOwner->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rental Owner'), ['action' => 'delete', $rentalOwner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalOwner->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Rental Owners'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rental Owner'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="rentalOwners view col-lg-10 col-md-9 columns">
    <h2><?= h($rentalOwner->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('First Name') ?></h6>
                    <p><?= h($rentalOwner->first_name) ?></p>
                    <h6 class="subheader"><?= __('Last Name') ?></h6>
                    <p><?= h($rentalOwner->last_name) ?></p>
                    <h6 class="subheader"><?= __('Company Name') ?></h6>
                    <p><?= h($rentalOwner->company_name) ?></p>
                    <h6 class="subheader"><?= __('Primary Email') ?></h6>
                    <p><?= h($rentalOwner->primary_email) ?></p>
                    <h6 class="subheader"><?= __('Alternate Email') ?></h6>
                    <p><?= h($rentalOwner->alternate_email) ?></p>
                    <h6 class="subheader"><?= __('Phone') ?></h6>
                    <p><?= h($rentalOwner->phone) ?></p>
                    <h6 class="subheader"><?= __('Country') ?></h6>
                    <p><?= h($rentalOwner->country) ?></p>
                    <h6 class="subheader"><?= __('Street') ?></h6>
                    <p><?= h($rentalOwner->street) ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= h($rentalOwner->city) ?></p>
                    <h6 class="subheader"><?= __('State') ?></h6>
                    <p><?= h($rentalOwner->state) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($rentalOwner->id) ?></p>
                    <h6 class="subheader"><?= __('Zip') ?></h6>
                    <p><?= $this->Number->format($rentalOwner->zip) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Date Of Birth') ?></h6>
                    <p><?= h($rentalOwner->date_of_birth) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Comments') ?></h6>
                    <?= $this->Text->autoParagraph(h($rentalOwner->comments)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
