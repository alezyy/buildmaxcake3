<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Employment And Income History'), ['action' => 'edit', $employmentAndIncomeHistory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employment And Income History'), ['action' => 'delete', $employmentAndIncomeHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employmentAndIncomeHistory->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Employment And Income History'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employment And Income History'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="employmentAndIncomeHistory view col-lg-10 col-md-9 columns">
    <h2><?= h($employmentAndIncomeHistory->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Employer Name') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->employer_name) ?></p>
                    <h6 class="subheader"><?= __('City') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->city) ?></p>
                    <h6 class="subheader"><?= __('Employer Phone') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->employer_phone) ?></p>
                    <h6 class="subheader"><?= __('Occupation') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->occupation) ?></p>
                    <h6 class="subheader"><?= __('Additional Income 2nd Job') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->additional_income_2nd_job) ?></p>
                    <h6 class="subheader"><?= __('Assets') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->assets) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($employmentAndIncomeHistory->id) ?></p>
                    <h6 class="subheader"><?= __('Id Tenant') ?></h6>
                    <p><?= $this->Number->format($employmentAndIncomeHistory->id_tenant) ?></p>
                    <h6 class="subheader"><?= __('Monthly Gross Pay') ?></h6>
                    <p><?= $this->Number->format($employmentAndIncomeHistory->monthly_gross_pay) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Employed From') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->employed_from) ?></p>
                    <h6 class="subheader"><?= __('Employed Till') ?></h6>
                    <p><?= h($employmentAndIncomeHistory->employed_till) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row texts">
        <div class="columns col-lg-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Notes') ?></h6>
                    <?= $this->Text->autoParagraph(h($employmentAndIncomeHistory->notes)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
