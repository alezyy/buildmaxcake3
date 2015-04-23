<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Membership User'), ['action' => 'edit', $membershipUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Membership User'), ['action' => 'delete', $membershipUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUser->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Membership Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Membership User'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="membershipUsers view col-lg-10 col-md-9 columns">
    <h2><?= h($membershipUser->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= h($membershipUser->id) ?></p>
                    <h6 class="subheader"><?= __('PassMD5') ?></h6>
                    <p><?= h($membershipUser->passMD5) ?></p>
                    <h6 class="subheader"><?= __('Email') ?></h6>
                    <p><?= h($membershipUser->email) ?></p>
                    <h6 class="subheader"><?= __('Pass Reset Key') ?></h6>
                    <p><?= h($membershipUser->pass_reset_key) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id Membership Group') ?></h6>
                    <p><?= $this->Number->format($membershipUser->id_membership_group) ?></p>
                    <h6 class="subheader"><?= __('IsBanned') ?></h6>
                    <p><?= $this->Number->format($membershipUser->isBanned) ?></p>
                    <h6 class="subheader"><?= __('IsApproved') ?></h6>
                    <p><?= $this->Number->format($membershipUser->isApproved) ?></p>
                    <h6 class="subheader"><?= __('Pass Reset Expiry') ?></h6>
                    <p><?= $this->Number->format($membershipUser->pass_reset_expiry) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('SignupDate') ?></h6>
                    <p><?= h($membershipUser->signupDate) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Custom1') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipUser->custom1)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Custom2') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipUser->custom2)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Custom3') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipUser->custom3)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Custom4') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipUser->custom4)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Comments') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipUser->comments)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
