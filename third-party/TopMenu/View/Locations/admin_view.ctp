<?php
$this->Html->addCrumb(__('Locations'), array(
    'controller' => 'locations',
    'action'     => 'index'
));
$this->Html->addCrumb(__('View Location'));
?>
<div class="locations view span8">
    <br/>
    <h2>   
        <?php
        echo $this->Image->out(
            $location['Location']['logo'], '120x120'
        );
        ?>
        &nbsp;
        <?php echo h($location['Location']['name']); ?>
    </h2>
    <br/>

    <h3><?php echo __("Information"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th style="width: 120px;"><?php echo __('Id'); ?></th>
            <td colspan="4"><?php echo h($location['Location']['id']); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Name (fr)'); ?></th>
            <td colspan="4"><?php echo h($location['Location']['name_fr']); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Name (en)'); ?></th>
            <td colspan="4"><?php echo h($location['Location']['name_en']); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Status'); ?></th>
            <td colspan="4"><?php echo h($location['Location']['status']); ?></td>
        </tr>
        <tr>            
            <th><?php echo __('PDF Menu'); ?></th>
            <td colspan="4">
                <?php
                echo $this->PDF->out(
                    $location['Location']['url']
                );
                ?>
            </td>
        </tr>
        <tr>
            <th><?php echo __('Phone'); ?></th>
            <td colspan="4">
                <?php echo h($location['Location']['phone']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><?php echo __('Phone 2'); ?></th>
            <td colspan="4">
                <?php echo h($location['Location']['phone2']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>
            <th><?php echo __('Owner'); ?></th>
            <td colspan="4">
                <?php echo h($location['Location']['owner_name']); ?>
                &nbsp;
            </td>
        </tr>
        <tr>		
            <th><?php echo __('Email'); ?></th>
            <td colspan="4">
                <?php echo h($location['Location']['email']); ?>
                &nbsp;
            </td>
        </tr>
    </table>




    <h3><?php echo __("Contracts"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th style="width: 120px;"><?php echo __('Contract Number'); ?></th>
            <td colspan="4"><?php echo h($location['Location']['contract_number']); ?></td>
        </tr>   
        <tr>
            <th><?php echo __('File Name'); ?></th>

            <th><?php echo __('File Description'); ?></th>                    

            <th><?php echo __('PDF'); ?></th>                    

            <th><?php echo __('Link'); ?></th>                    

            <th><?php echo __('Doc Id'); ?></th>                    
        </tr>
        <?php foreach ($location['LocationDocument'] as $k => $value) : ?>
            <tr>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['description'] ?></td>
                <td>
                    <?php
                    echo $this->PDF->out(
                        $value['file']
                    );
                    ?>          
                </td>
                <td><?php echo $value['link'] ?></td>
                <td><?php echo $value['number'] ?></td>
            </tr>
        <?php endforeach; ?>  
    </table>


    <h3><?php echo __("Address"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th style="width: 120px;"><?php echo __('Building Number'); ?></th>
            <td>
                <?php echo h($location['Location']['building_number']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('Street'); ?></th>
            <td>
                <?php echo h($location['Location']['street']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('City'); ?></th>
            <td>
                <?php echo h($location['Location']['city']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('Province'); ?></th>
            <td>
                <?php echo h($location['Location']['province']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('Postal Code'); ?></th>
            <td>
                <?php echo h($location['Location']['postal_code']); ?>
                &nbsp;
            </td>
        </tr>
    </table>



    <h3><?php echo __("Descriptions"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th style="width: 120px;">
                <?php echo __('English'); ?></th>
            <td>
                <?php echo h($location['Location']['description_en']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('French'); ?></th>
            <td>
                <?php echo h($location['Location']['description_fr']); ?>
                &nbsp;
            </td>
        </tr>
    </table>
    
    <h3><?php echo __("Cuisine Types"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <?php foreach ($location['Cuisine'] as $k => $value) : ?>
        <tr>
            <td style="width: 120px;">
                <?php echo $value['name'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    

    <h3><?php echo __("Online Ordering"); ?></h3>
    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th style="width: 120px;"><?php echo __('Delivery'); ?></th>
            <td>
                <?php echo ($location['Location']['delivery']) ? __("Yes") : __("No"); ?>
            </td>
        </tr><tr>
            <th><?php echo __('Pickup'); ?></th>
            <td>
                <?php echo ($location['Location']['pickup']) ? __("Yes") : __("No"); ?>
            </td>
        </tr><tr>            
        </tr><tr>
            <th><?php echo __('Delivery Minimum'); ?></th>
            <td>
                <?php echo $this->Number->currency($location['Location']['delivery_min_order'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
            </td>
        </tr><tr>            
            <th><?php echo __('Delivery Commission %'); ?></th>
            <td>
                <?php echo h($location['Location']['delivery_commission']); ?>
                &nbsp;
            </td>
        </tr><tr>
            <th><?php echo __('Pickup Commission %'); ?></th>
            <td>
                <?php echo h($location['Location']['pickup_commission']); ?>
                &nbsp;
            </td>
        </tr>
    </table>
</div>

<div class="actions pull-right">
    <h3><?php echo __('Actions'); ?></h3>
    <ul class="nav nav-tabs nav-stacked">
        <li><?php echo $this->Html->link(__('Edit Location'), array('action' => 'edit', $location['Location']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Location'), array('action' => 'delete', $location['Location']['id']), null, __('Are you sure you want to delete # %s?', $location['Location']['id'])); ?> </li>
        <li>
            <?php echo $this->Html->link(__('Printers'), array('controller' => 'devices', 'action' => 'location_index', $location['Location']['id'])); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Schedule'), array('controller' => 'schedules', 'action' => 'index', $location['Location']['id'])); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Delivery Areas'), array('controller' => 'delivery_areas', 'action' => 'index', $location['Location']['id'])); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Gallery'), array('controller' => 'location_galleries', 'action' => 'index', $location['Location']['id'])); ?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Menu'), array('controller' => 'menus', 'action' => 'index', $location['Location']['id'])); ?>
        </li>
        <li>
            <?php
            echo $this->Html->link(
                __('Restaurant Page'), array(
                'controller' => 'locations',
                'action'     => 'view',
                'location'   => $location['Location']['url'],
                'sector'     => $location['Location']['sector_slug'],
                'admin'      => false
                )
            );
            ?>
        </li>
    </ul>
</div>