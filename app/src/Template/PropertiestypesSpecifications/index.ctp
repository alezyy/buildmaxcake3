<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Propertiestypes Specification'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Propertiestypes Specifications'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Propertiestypes'), ['controller' => 'Propertiestypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Propertiestype'), ['controller' => 'Propertiestypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="propertiestypesSpecifications index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('propertiestype_id') ?></th>
                <th><?= $this->Paginator->sort('propertiestypes_specification') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($propertiestypesSpecifications as $propertiestypesSpecification): ?>
            <tr>
                <td><?= $this->Number->format($propertiestypesSpecification->id) ?></td>
                <td>
                    <?= $propertiestypesSpecification->has('propertiestype') ? $this->Html->link($propertiestypesSpecification->propertiestype->id, ['controller' => 'Propertiestypes', 'action' => 'view', $propertiestypesSpecification->propertiestype->id]) : '' ?>
                </td>
            <td><?= h($propertiestypesSpecification->propertiestypes_specification) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $propertiestypesSpecification->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $propertiestypesSpecification->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $propertiestypesSpecification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiestypesSpecification->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
