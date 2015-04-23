<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Membership Grouppermission'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Membership Grouppermissions'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="membershipGrouppermissions index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_membership_group') ?></th>
                <th><?= $this->Paginator->sort('tableName') ?></th>
                <th><?= $this->Paginator->sort('allowInsert') ?></th>
                <th><?= $this->Paginator->sort('allowView') ?></th>
                <th><?= $this->Paginator->sort('allowEdit') ?></th>
                <th><?= $this->Paginator->sort('allowDelete') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($membershipGrouppermissions as $membershipGrouppermission): ?>
            <tr>
                <td><?= $this->Number->format($membershipGrouppermission->id) ?></td>
                    <td><?= $this->Number->format($membershipGrouppermission->id_membership_group) ?></td>
                <td><?= h($membershipGrouppermission->tableName) ?></td>
                    <td><?= $this->Number->format($membershipGrouppermission->allowInsert) ?></td>
                    <td><?= $this->Number->format($membershipGrouppermission->allowView) ?></td>
                    <td><?= $this->Number->format($membershipGrouppermission->allowEdit) ?></td>
                    <td><?= $this->Number->format($membershipGrouppermission->allowDelete) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $membershipGrouppermission->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $membershipGrouppermission->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $membershipGrouppermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membershipGrouppermission->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
