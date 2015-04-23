<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Applications Lease'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Applications Leases'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="applicationsLeases index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('tenant_id') ?></th>
                <th><?= $this->Paginator->sort('property_id') ?></th>
                <th><?= $this->Paginator->sort('unit_id') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th><?= $this->Paginator->sort('end_date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($applicationsLeases as $applicationsLease): ?>
            <tr>
                <td><?= $this->Number->format($applicationsLease->id) ?></td>
                    <td><?= $this->Number->format($applicationsLease->tenant_id) ?></td>
                    <td><?= $this->Number->format($applicationsLease->property_id) ?></td>
                    <td><?= $this->Number->format($applicationsLease->unit_id) ?></td>
                <td><?= h($applicationsLease->type) ?></td>
                <td><?= h($applicationsLease->start_date) ?></td>
                <td><?= h($applicationsLease->end_date) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $applicationsLease->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $applicationsLease->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $applicationsLease->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applicationsLease->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
