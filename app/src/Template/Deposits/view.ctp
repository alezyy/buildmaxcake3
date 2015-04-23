<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Deposit'), ['action' => 'edit', $deposit->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Deposit'), ['action' => 'delete', $deposit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deposit->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Deposits'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Deposit'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="deposits view col-lg-10 col-md-9 columns">
    <h2><?= h($deposit->id) ?></h2>
    <div class="row">
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($deposit->id) ?></p>
                    <h6 class="subheader"><?= __('Security Deposit') ?></h6>
                    <p><?= $this->Number->format($deposit->security_deposit) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
