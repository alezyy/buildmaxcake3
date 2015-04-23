<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Rental Owner'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Rental Owners'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="rentalOwners index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('first_name') ?></th>
                <th><?= $this->Paginator->sort('last_name') ?></th>
                <th><?= $this->Paginator->sort('company_name') ?></th>
                <th><?= $this->Paginator->sort('date_of_birth') ?></th>
                <th><?= $this->Paginator->sort('primary_email') ?></th>
                <th><?= $this->Paginator->sort('alternate_email') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rentalOwners as $rentalOwner): ?>
            <tr>
                <td><?= $this->Number->format($rentalOwner->id) ?></td>
                <td><?= h($rentalOwner->first_name) ?></td>
                <td><?= h($rentalOwner->last_name) ?></td>
                <td><?= h($rentalOwner->company_name) ?></td>
                <td><?= h($rentalOwner->date_of_birth) ?></td>
                <td><?= h($rentalOwner->primary_email) ?></td>
                <td><?= h($rentalOwner->alternate_email) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $rentalOwner->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $rentalOwner->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $rentalOwner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rentalOwner->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
