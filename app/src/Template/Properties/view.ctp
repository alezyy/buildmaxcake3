<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Property'), ['action' => 'edit', $property->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Property'), ['action' => 'delete', $property->id], ['confirm' => __('Are you sure you want to delete # {0}?', $property->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="properties view col-lg-10 col-md-9 columns">
    <h2><?= h($property->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Property Name') ?></h6>
                    <p><?= h($property->property_name) ?></p>
                    <h6 class="subheader"><?= __('Id Unit') ?></h6>
                    <p><?= h($property->id_unit) ?></p>
                    <h6 class="subheader"><?= __('Operating Account') ?></h6>
                    <p><?= h($property->operating_account) ?></p>
                    <h6 class="subheader"><?= __('Lease Term') ?></h6>
                    <p><?= h($property->lease_term) ?></p>
                    <h6 class="subheader"><?= __('Country') ?></h6>
                    <p><?= h($property->country) ?></p>
                    <h6 class="subheader"><?= __('Street') ?></h6>
                    <p><?= h($property->street) ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= h($property->City) ?></p>
                    <h6 class="subheader"><?= __('State') ?></h6>
                    <p><?= h($property->State) ?></p>
                    <h6 class="subheader"><?= __('Photo') ?></h6>
                    <p><?= h($property->photo) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($property->id) ?></p>
                    <h6 class="subheader"><?= __('Propertiestypes Specification Id') ?></h6>
                    <p><?= $this->Number->format($property->propertiestypes_specification_id) ?></p>
                    <h6 class="subheader"><?= __('Number Of Units') ?></h6>
                    <p><?= $this->Number->format($property->number_of_units) ?></p>
                    <h6 class="subheader"><?= __('Id Rental Owner') ?></h6>
                    <p><?= $this->Number->format($property->id_rental_owner) ?></p>
                    <h6 class="subheader"><?= __('Property Reserve') ?></h6>
                    <p><?= $this->Number->format($property->property_reserve) ?></p>
                    <h6 class="subheader"><?= __('Rental Amount') ?></h6>
                    <p><?= $this->Number->format($property->rental_amount) ?></p>
                    <h6 class="subheader"><?= __('Deposit Amount') ?></h6>
                    <p><?= $this->Number->format($property->deposit_amount) ?></p>
                    <h6 class="subheader"><?= __('ZIP') ?></h6>
                    <p><?= $this->Number->format($property->ZIP) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
