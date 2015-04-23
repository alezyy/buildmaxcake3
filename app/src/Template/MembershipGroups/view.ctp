<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Membership Group'), ['action' => 'edit', $membershipGroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Membership Group'), ['action' => 'delete', $membershipGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipGroup->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Membership Groups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Membership Group'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="membershipGroups view col-lg-10 col-md-9 columns">
    <h2><?= h($membershipGroup->name) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Name') ?></h6>
                    <p><?= h($membershipGroup->name) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($membershipGroup->id) ?></p>
                    <h6 class="subheader"><?= __('AllowSignup') ?></h6>
                    <p><?= $this->Number->format($membershipGroup->allowSignup) ?></p>
                    <h6 class="subheader"><?= __('NeedsApproval') ?></h6>
                    <p><?= $this->Number->format($membershipGroup->needsApproval) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Description') ?></h6>
                    <?= $this->Text->autoParagraph(h($membershipGroup->description)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
