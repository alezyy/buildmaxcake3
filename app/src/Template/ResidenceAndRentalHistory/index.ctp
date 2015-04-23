<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Residence And Rental History'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Residence And Rental History'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="residenceAndRentalHistory index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('id_tenant') ?></th>
                <th><?= $this->Paginator->sort('address') ?></th>
                <th><?= $this->Paginator->sort('landlord_or_manager_name') ?></th>
                <th><?= $this->Paginator->sort('landlord_or_manager_phone') ?></th>
                <th><?= $this->Paginator->sort('monthly_rent') ?></th>
                <th><?= $this->Paginator->sort('date_of_residency_from') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($residenceAndRentalHistory as $residenceAndRentalHistory): ?>
            <tr>
                <td><?= $this->Number->format($residenceAndRentalHistory->id) ?></td>
                    <td><?= $this->Number->format($residenceAndRentalHistory->id_tenant) ?></td>
                <td><?= h($residenceAndRentalHistory->address) ?></td>
                <td><?= h($residenceAndRentalHistory->landlord_or_manager_name) ?></td>
                <td><?= h($residenceAndRentalHistory->landlord_or_manager_phone) ?></td>
                    <td><?= $this->Number->format($residenceAndRentalHistory->monthly_rent) ?></td>
                <td><?= h($residenceAndRentalHistory->date_of_residency_from) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $residenceAndRentalHistory->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $residenceAndRentalHistory->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $residenceAndRentalHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $residenceAndRentalHistory->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
