<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Propertiestypes Specification'), ['action' => 'edit', $propertiestypesSpecification->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Propertiestypes Specification'), ['action' => 'delete', $propertiestypesSpecification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiestypesSpecification->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Propertiestypes Specifications'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Propertiestypes Specification'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Propertiestypes'), ['controller' => 'Propertiestypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Propertiestype'), ['controller' => 'Propertiestypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Properties'), ['controller' => 'Properties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Property'), ['controller' => 'Properties', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="propertiestypesSpecifications view col-lg-10 col-md-9 columns">
    <h2><?= h($propertiestypesSpecification->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Propertiestype') ?></h6>
                    <p><?= $propertiestypesSpecification->has('propertiestype') ? $this->Html->link($propertiestypesSpecification->propertiestype->id, ['controller' => 'Propertiestypes', 'action' => 'view', $propertiestypesSpecification->propertiestype->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Propertiestypes Specification') ?></h6>
                    <p><?= h($propertiestypesSpecification->propertiestypes_specification) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($propertiestypesSpecification->id) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Properties') ?></h4>
    <?php if (!empty($propertiestypesSpecification->properties)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Property Name') ?></th>
                <th><?= __('Id Unit') ?></th>
                <th><?= __('Propertiestypes Specification Id') ?></th>
                <th><?= __('Number Of Units') ?></th>
                <th><?= __('Id Rental Owner') ?></th>
                <th><?= __('Operating Account') ?></th>
                <th><?= __('Property Reserve') ?></th>
                <th><?= __('Rental Amount') ?></th>
                <th><?= __('Deposit Amount') ?></th>
                <th><?= __('Lease Term') ?></th>
                <th><?= __('Country') ?></th>
                <th><?= __('Street') ?></th>
                <th><?= __('City') ?></th>
                <th><?= __('State') ?></th>
                <th><?= __('ZIP') ?></th>
                <th><?= __('Photo') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($propertiestypesSpecification->properties as $properties): ?>
            <tr>
                <td><?= h($properties->id) ?></td>
                <td><?= h($properties->property_name) ?></td>
                <td><?= h($properties->id_unit) ?></td>
                <td><?= h($properties->propertiestypes_specification_id) ?></td>
                <td><?= h($properties->number_of_units) ?></td>
                <td><?= h($properties->id_rental_owner) ?></td>
                <td><?= h($properties->operating_account) ?></td>
                <td><?= h($properties->property_reserve) ?></td>
                <td><?= h($properties->rental_amount) ?></td>
                <td><?= h($properties->deposit_amount) ?></td>
                <td><?= h($properties->lease_term) ?></td>
                <td><?= h($properties->country) ?></td>
                <td><?= h($properties->street) ?></td>
                <td><?= h($properties->City) ?></td>
                <td><?= h($properties->State) ?></td>
                <td><?= h($properties->ZIP) ?></td>
                <td><?= h($properties->photo) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Properties', 'action' => 'view', $properties->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Properties', 'action' => 'edit', $properties->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Properties', 'action' => 'delete', $properties->id], ['confirm' => __('Are you sure you want to delete # {0}?', $properties->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
