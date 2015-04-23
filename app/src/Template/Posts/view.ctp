<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Post'), ['action' => 'edit', $post->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="posts view col-lg-10 col-md-9 columns">
    <h2><?= h($post->title) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Title') ?></h6>
                    <p><?= h($post->title) ?></p>
                    <h6 class="subheader"><?= __('Slug') ?></h6>
                    <p><?= h($post->slug) ?></p>
                    <h6 class="subheader"><?= __('Post File') ?></h6>
                    <p><?= h($post->post_file) ?></p>
                    <h6 class="subheader"><?= __('Parent Id') ?></h6>
                    <p><?= h($post->parent_id) ?></p>
                    <h6 class="subheader"><?= __('User') ?></h6>
                    <p><?= $post->has('user') ? $this->Html->link($post->user->id, ['controller' => 'Users', 'action' => 'view', $post->user->id]) : '' ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($post->id) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Publish Date') ?></h6>
                    <p><?= h($post->publish_date) ?></p>
                    <h6 class="subheader"><?= __('Created') ?></h6>
                    <p><?= h($post->created) ?></p>
                    <h6 class="subheader"><?= __('Modified') ?></h6>
                    <p><?= h($post->modified) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Is Published') ?></h6>
                    <p><?= $post->is_published ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Content') ?></h6>
                    <?= $this->Text->autoParagraph(h($post->content)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
