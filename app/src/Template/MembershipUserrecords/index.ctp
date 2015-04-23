<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Membership Userrecord'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Membership Userrecords'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipUserrecords index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('tableName') ?></th>
                <th><?= $this->Paginator->sort('pkValue') ?></th>
                <th><?= $this->Paginator->sort('id_membership_user') ?></th>
                <th><?= $this->Paginator->sort('dateAdded') ?></th>
                <th><?= $this->Paginator->sort('dateUpdated') ?></th>
                <th><?= $this->Paginator->sort('id_membership_group') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($membershipUserrecords as $membershipUserrecord): ?>
            <tr>
                <td><?= $this->Number->format($membershipUserrecord->id) ?></td>
                <td><?= h($membershipUserrecord->tableName) ?></td>
                <td><?= h($membershipUserrecord->pkValue) ?></td>
                <td><?= h($membershipUserrecord->id_membership_user) ?></td>
                    <td><?= $this->Number->format($membershipUserrecord->dateAdded) ?></td>
                    <td><?= $this->Number->format($membershipUserrecord->dateUpdated) ?></td>
                    <td><?= $this->Number->format($membershipUserrecord->id_membership_group) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $membershipUserrecord->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $membershipUserrecord->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $membershipUserrecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipUserrecord->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
