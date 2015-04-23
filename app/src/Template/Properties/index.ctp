<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Property'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Properties'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="properties index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('property_name') ?></th>
                <th><?= $this->Paginator->sort('id_unit') ?></th>
                <th><?= $this->Paginator->sort('propertiestypes_specification_id') ?></th>
                <th><?= $this->Paginator->sort('number_of_units') ?></th>
                <th><?= $this->Paginator->sort('id_rental_owner') ?></th>
                <th><?= $this->Paginator->sort('operating_account') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($properties as $property): ?>
            <tr>
                <td><?= $this->Number->format($property->id) ?></td>
                <td><?= h($property->property_name) ?></td>
                <td><?= h($property->id_unit) ?></td>
                    <td><?= $this->Number->format($property->propertiestypes_specification_id) ?></td>
                    <td><?= $this->Number->format($property->number_of_units) ?></td>
                    <td><?= $this->Number->format($property->id_rental_owner) ?></td>
                <td><?= h($property->operating_account) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $property->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $property->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $property->id], ['confirm' => __('Are you sure you want to delete # {0}?', $property->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
