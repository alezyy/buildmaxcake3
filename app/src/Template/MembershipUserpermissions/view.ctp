<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Membership Userpermission'), ['action' => 'edit', $membershipUserpermission->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Membership Userpermission'), ['action' => 'delete', $membershipUserpermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUserpermission->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Membership Userpermissions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Membership Userpermission'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="membershipUserpermissions view col-lg-10 col-md-9 columns">
    <h2><?= h($membershipUserpermission->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id Membership User') ?></h6>
                    <p><?= h($membershipUserpermission->id_membership_user) ?></p>
                    <h6 class="subheader"><?= __('TableName') ?></h6>
                    <p><?= h($membershipUserpermission->tableName) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($membershipUserpermission->id) ?></p>
                    <h6 class="subheader"><?= __('AllowInsert') ?></h6>
                    <p><?= $this->Number->format($membershipUserpermission->allowInsert) ?></p>
                    <h6 class="subheader"><?= __('AllowView') ?></h6>
                    <p><?= $this->Number->format($membershipUserpermission->allowView) ?></p>
                    <h6 class="subheader"><?= __('AllowEdit') ?></h6>
                    <p><?= $this->Number->format($membershipUserpermission->allowEdit) ?></p>
                    <h6 class="subheader"><?= __('AllowDelete') ?></h6>
                    <p><?= $this->Number->format($membershipUserpermission->allowDelete) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
