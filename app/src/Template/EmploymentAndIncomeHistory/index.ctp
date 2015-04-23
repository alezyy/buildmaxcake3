<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Employment And Income History'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Employment And Income History'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="employmentAndIncomeHistory index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_tenant') ?></th>
                <th><?= $this->Paginator->sort('employer_name') ?></th>
                <th><?= $this->Paginator->sort('city') ?></th>
                <th><?= $this->Paginator->sort('employer_phone') ?></th>
                <th><?= $this->Paginator->sort('employed_from') ?></th>
                <th><?= $this->Paginator->sort('employed_till') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($employmentAndIncomeHistory as $employmentAndIncomeHistory): ?>
            <tr>
                <td><?= $this->Number->format($employmentAndIncomeHistory->id) ?></td>
                    <td><?= $this->Number->format($employmentAndIncomeHistory->id_tenant) ?></td>
                <td><?= h($employmentAndIncomeHistory->employer_name) ?></td>
                <td><?= h($employmentAndIncomeHistory->city) ?></td>
                <td><?= h($employmentAndIncomeHistory->employer_phone) ?></td>
                <td><?= h($employmentAndIncomeHistory->employed_from) ?></td>
                <td><?= h($employmentAndIncomeHistory->employed_till) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $employmentAndIncomeHistory->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $employmentAndIncomeHistory->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $employmentAndIncomeHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employmentAndIncomeHistory->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
