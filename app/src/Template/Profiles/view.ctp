<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Profile'), ['action' => 'edit', $profile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Profile'), ['action' => 'delete', $profile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $profile->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Profiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Profile'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="profiles view col-lg-10 col-md-9 columns">
    <h2><?= h($profile->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= h($profile->id) ?></p>
                    <h6 class="subheader"><?= __('First Name') ?></h6>
                    <p><?= h($profile->first_name) ?></p>
                    <h6 class="subheader"><?= __('Last Name') ?></h6>
                    <p><?= h($profile->last_name) ?></p>
                    <h6 class="subheader"><?= __('Phone') ?></h6>
                    <p><?= h($profile->phone) ?></p>
                    <h6 class="subheader"><?= __('Language') ?></h6>
                    <p><?= h($profile->language) ?></p>
                    <h6 class="subheader"><?= __('Image') ?></h6>
                    <p><?= h($profile->image) ?></p>
                    <h6 class="subheader"><?= __('Timezone') ?></h6>
                    <p><?= h($profile->timezone) ?></p>
                    <h6 class="subheader"><?= __('Gender') ?></h6>
                    <p><?= h($profile->gender) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Date Of Birth') ?></h6>
                    <p><?= h($profile->date_of_birth) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
