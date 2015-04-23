<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Membership Grouppermission'), ['action' => 'edit', $membershipGrouppermission->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Membership Grouppermission'), ['action' => 'delete', $membershipGrouppermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipGrouppermission->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Membership Grouppermissions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Membership Grouppermission'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="membershipGrouppermissions view col-lg-10 col-md-9 columns">
    <h2><?= h($membershipGrouppermission->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('TableName') ?></h6>
                    <p><?= h($membershipGrouppermission->tableName) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->id) ?></p>
                    <h6 class="subheader"><?= __('Id Membership Group') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->id_membership_group) ?></p>
                    <h6 class="subheader"><?= __('AllowInsert') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->allowInsert) ?></p>
                    <h6 class="subheader"><?= __('AllowView') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->allowView) ?></p>
                    <h6 class="subheader"><?= __('AllowEdit') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->allowEdit) ?></p>
                    <h6 class="subheader"><?= __('AllowDelete') ?></h6>
                    <p><?= $this->Number->format($membershipGrouppermission->allowDelete) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
