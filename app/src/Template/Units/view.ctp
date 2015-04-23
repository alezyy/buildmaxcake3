<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Unit'), ['action' => 'edit', $unit->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Unit'), ['action' => 'delete', $unit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unit->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="units view col-lg-10 col-md-9 columns">
    <h2><?= h($unit->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Unit Number') ?></h6>
                    <p><?= h($unit->unit_number) ?></p>
                    <h6 class="subheader"><?= __('Country') ?></h6>
                    <p><?= h($unit->country) ?></p>
                    <h6 class="subheader"><?= __('Street') ?></h6>
                    <p><?= h($unit->street) ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= h($unit->city) ?></p>
                    <h6 class="subheader"><?= __('State') ?></h6>
                    <p><?= h($unit->state) ?></p>
                    <h6 class="subheader"><?= __('Postal Code') ?></h6>
                    <p><?= h($unit->postal_code) ?></p>
                    <h6 class="subheader"><?= __('Bedrooms') ?></h6>
                    <p><?= h($unit->bedrooms) ?></p>
                    <h6 class="subheader"><?= __('Status') ?></h6>
                    <p><?= h($unit->status) ?></p>
                    <h6 class="subheader"><?= __('Photo') ?></h6>
                    <p><?= h($unit->photo) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($unit->id) ?></p>
                    <h6 class="subheader"><?= __('Id Property') ?></h6>
                    <p><?= $this->Number->format($unit->id_property) ?></p>
                    <h6 class="subheader"><?= __('Size') ?></h6>
                    <p><?= $this->Number->format($unit->size) ?></p>
                    <h6 class="subheader"><?= __('Market Rent') ?></h6>
                    <p><?= $this->Number->format($unit->market_rent) ?></p>
                    <h6 class="subheader"><?= __('Bath') ?></h6>
                    <p><?= $this->Number->format($unit->bath) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Description') ?></h6>
                    <?= $this->Text->autoParagraph(h($unit->description)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Features') ?></h6>
                    <?= $this->Text->autoParagraph(h($unit->features)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
