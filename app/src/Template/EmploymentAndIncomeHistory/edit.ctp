<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Employment And Income History'), ['action' => 'edit', $employmentAndIncomeHistory->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $employmentAndIncomeHistory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $employmentAndIncomeHistory->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Employment And Income History'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employment And Income History'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="employmentAndIncomeHistory form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($employmentAndIncomeHistory); ?>
    <fieldset>
        <legend><?= __('Edit Employment And Income History') ?></legend>
        <?php
            echo $this->Form->input('id_tenant');
            echo $this->Form->input('employer_name');
            echo $this->Form->input('city');
            echo $this->Form->input('employer_phone');
            echo $this->Form->input('employed_from');
            echo $this->Form->input('employed_till');
            echo $this->Form->input('monthly_gross_pay');
            echo $this->Form->input('occupation');
            echo $this->Form->input('additional_income_2nd_job');
            echo $this->Form->input('assets');
            echo $this->Form->input('notes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
