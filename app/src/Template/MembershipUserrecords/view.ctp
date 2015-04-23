<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Membership Userrecord'), ['action' => 'edit', $membershipUserrecord->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Membership Userrecord'), ['action' => 'delete', $membershipUserrecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUserrecord->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Membership Userrecords'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Membership Userrecord'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="membershipUserrecords view col-lg-10 col-md-9 columns">
    <h2><?= h($membershipUserrecord->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('TableName') ?></h6>
                    <p><?= h($membershipUserrecord->tableName) ?></p>
                    <h6 class="subheader"><?= __('PkValue') ?></h6>
                    <p><?= h($membershipUserrecord->pkValue) ?></p>
                    <h6 class="subheader"><?= __('Id Membership User') ?></h6>
                    <p><?= h($membershipUserrecord->id_membership_user) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($membershipUserrecord->id) ?></p>
                    <h6 class="subheader"><?= __('DateAdded') ?></h6>
                    <p><?= $this->Number->format($membershipUserrecord->dateAdded) ?></p>
                    <h6 class="subheader"><?= __('DateUpdated') ?></h6>
                    <p><?= $this->Number->format($membershipUserrecord->dateUpdated) ?></p>
                    <h6 class="subheader"><?= __('Id Membership Group') ?></h6>
                    <p><?= $this->Number->format($membershipUserrecord->id_membership_group) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
