<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users view col-lg-10 col-md-9 columns">
    <h2><?= h($user->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Email') ?></h6>
                    <p><?= h($user->email) ?></p>
                    <h6 class="subheader"><?= __('Username') ?></h6>
                    <p><?= h($user->username) ?></p>
                    <h6 class="subheader"><?= __('Password') ?></h6>
                    <p><?= h($user->password) ?></p>
                    <h6 class="subheader"><?= __('Salt') ?></h6>
                    <p><?= h($user->salt) ?></p>
                    <h6 class="subheader"><?= __('Group') ?></h6>
                    <p><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Role') ?></h6>
                    <p><?= h($user->role) ?></p>
                    <h6 class="subheader"><?= __('Last Ip') ?></h6>
                    <p><?= h($user->last_ip) ?></p>
                    <h6 class="subheader"><?= __('Old Salt') ?></h6>
                    <p><?= h($user->old_salt) ?></p>
                    <h6 class="subheader"><?= __('Old Hash') ?></h6>
                    <p><?= h($user->old_hash) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($user->id) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Created') ?></h6>
                    <p><?= h($user->created) ?></p>
                    <h6 class="subheader"><?= __('Modified') ?></h6>
                    <p><?= h($user->modified) ?></p>
                    <h6 class="subheader"><?= __('Last Login') ?></h6>
                    <p><?= h($user->last_login) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Is Active') ?></h6>
                    <p><?= $user->is_active ? __('Yes') : __('No'); ?></p>
                    <h6 class="subheader"><?= __('Force Reset') ?></h6>
                    <p><?= $user->force_reset ? __('Yes') : __('No'); ?></p>
                    <h6 class="subheader"><?= __('Fraudulent') ?></h6>
                    <p><?= $user->fraudulent ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related Posts') ?></h4>
    <?php if (!empty($user->posts)): ?>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Post File') ?></th>
                <th><?= __('Publish Date') ?></th>
                <th><?= __('Is Published') ?></th>
                <th><?= __('Parent Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Content') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->posts as $posts): ?>
            <tr>
                <td><?= h($posts->id) ?></td>
                <td><?= h($posts->title) ?></td>
                <td><?= h($posts->slug) ?></td>
                <td><?= h($posts->post_file) ?></td>
                <td><?= h($posts->publish_date) ?></td>
                <td><?= h($posts->is_published) ?></td>
                <td><?= h($posts->parent_id) ?></td>
                <td><?= h($posts->user_id) ?></td>
                <td><?= h($posts->created) ?></td>
                <td><?= h($posts->modified) ?></td>
                <td><?= h($posts->content) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'Posts', 'action' => 'view', $posts->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'Posts', 'action' => 'edit', $posts->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'Posts', 'action' => 'delete', $posts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $posts->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
