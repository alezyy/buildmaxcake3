<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Propertiestype'), ['action' => 'edit', $propertiestype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Propertiestype'), ['action' => 'delete', $propertiestype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $propertiestype->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Propertiestypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Propertiestype'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="propertiestypes view col-lg-10 col-md-9 columns">
    <h2><?= h($propertiestype->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= h($propertiestype->id) ?></p>
                    <h6 class="subheader"><?= __('Type') ?></h6>
                    <p><?= h($propertiestype->type) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
