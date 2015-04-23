<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Reference'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List References'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="references index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_tenant') ?></th>
                <th><?= $this->Paginator->sort('reference_first_name_1') ?></th>
                <th><?= $this->Paginator->sort('reference_last_name_1') ?></th>
                <th><?= $this->Paginator->sort('phone_1') ?></th>
                <th><?= $this->Paginator->sort('first_name_2') ?></th>
                <th><?= $this->Paginator->sort('last_name_2') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($references as $reference): ?>
            <tr>
                <td><?= $this->Number->format($reference->id) ?></td>
                    <td><?= $this->Number->format($reference->id_tenant) ?></td>
                <td><?= h($reference->reference_first_name_1) ?></td>
                <td><?= h($reference->reference_last_name_1) ?></td>
                <td><?= h($reference->phone_1) ?></td>
                <td><?= h($reference->first_name_2) ?></td>
                <td><?= h($reference->last_name_2) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $reference->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $reference->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $reference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reference->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
