<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Reference'), ['action' => 'edit', $reference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reference'), ['action' => 'delete', $reference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reference->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List References'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reference'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="references view col-lg-10 col-md-9 columns">
    <h2><?= h($reference->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Reference First Name 1') ?></h6>
                    <p><?= h($reference->reference_first_name_1) ?></p>
                    <h6 class="subheader"><?= __('Reference Last Name 1') ?></h6>
                    <p><?= h($reference->reference_last_name_1) ?></p>
                    <h6 class="subheader"><?= __('Phone 1') ?></h6>
                    <p><?= h($reference->phone_1) ?></p>
                    <h6 class="subheader"><?= __('First Name 2') ?></h6>
                    <p><?= h($reference->first_name_2) ?></p>
                    <h6 class="subheader"><?= __('Last Name 2') ?></h6>
                    <p><?= h($reference->last_name_2) ?></p>
                    <h6 class="subheader"><?= __('Phone 2') ?></h6>
                    <p><?= h($reference->phone_2) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($reference->id) ?></p>
                    <h6 class="subheader"><?= __('Id Tenant') ?></h6>
                    <p><?= $this->Number->format($reference->id_tenant) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
