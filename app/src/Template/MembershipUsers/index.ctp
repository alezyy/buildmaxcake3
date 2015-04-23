<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Membership User'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Membership Users'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipUsers index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('passMD5') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('signupDate') ?></th>
                <th><?= $this->Paginator->sort('id_membership_group') ?></th>
                <th><?= $this->Paginator->sort('isBanned') ?></th>
                <th><?= $this->Paginator->sort('isApproved') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($membershipUsers as $membershipUser): ?>
            <tr>
            <td><?= h($membershipUser->id) ?></td>
                <td><?= h($membershipUser->passMD5) ?></td>
                <td><?= h($membershipUser->email) ?></td>
                <td><?= h($membershipUser->signupDate) ?></td>
                    <td><?= $this->Number->format($membershipUser->id_membership_group) ?></td>
                    <td><?= $this->Number->format($membershipUser->isBanned) ?></td>
                    <td><?= $this->Number->format($membershipUser->isApproved) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $membershipUser->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $membershipUser->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $membershipUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUser->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
