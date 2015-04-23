<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Tenant'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Tenants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List States'), ['controller' => 'States', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New State'), ['controller' => 'States', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alternateemails'), ['controller' => 'Alternateemails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alternateemail'), ['controller' => 'Alternateemails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounting'), ['controller' => 'Accounting', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accounting'), ['controller' => 'Accounting', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications Leases'), ['controller' => 'ApplicationsLeases', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Applications Lease'), ['controller' => 'ApplicationsLeases', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comptable1'), ['controller' => 'Comptable1', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comptable1'), ['controller' => 'Comptable1', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="tenants index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('first_name') ?></th>
                <th><?= $this->Paginator->sort('last_name') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('alternateemails_id') ?></th>
                <th><?= $this->Paginator->sort('cell_phone') ?></th>
                <th><?= $this->Paginator->sort('home_phone') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tenants as $tenant): ?>
            <tr>
                <td><?= $this->Number->format($tenant->id) ?></td>
                <td><?= h($tenant->first_name) ?></td>
                <td><?= h($tenant->last_name) ?></td>
                <td><?= h($tenant->email) ?></td>
                <td><?= h($tenant->alternateemails_id) ?></td>
                <td><?= h($tenant->cell_phone) ?></td>
                <td><?= h($tenant->home_phone) ?></td>
                    <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['action' => 'view', $tenant->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $tenant->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
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
