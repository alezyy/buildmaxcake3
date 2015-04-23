<?php 
$cuisine_array = array();
foreach ($location['Cuisine'] as $key => $c) :
    $cuisine_array []= $c['name_'.$langSuffix];
endforeach;
?> 

<li class="list-group-item result">
    <div class="row">   
        <!-- Caption Image -->

        <?php echo $this->Html->link(
            $image = $this->Image->out($location['Location']['logo'], '514x514', false, false, true,
                array(
                    "alt" => $location['Location']['name'], 
                    "title" => $location['Location']['name'], 
                    'class' => 'img-responsive restaurant_logo restaurant_view', 
                    'height' => 250,
                    'width' => 250
                )
            ), 
            array(
                'controller' => 'locations',
                'action'     => 'view',
                'location'   => $location['Location']['url'],
                'sector'     => $location['Location']['sector_slug'],
                'distance'   => (isset($location['Location']['distance']) ? $location['Location']['distance'] * 100 : '')
            ), // multiply by 100 to remove decimals
            array(
                'escape' => false,
                'class' => 'col-xs-12 col-md-4 restaurant_logo text-center'
            )
        );
        ?>

        <span class="col-xs-12 col-md-8">
            <h3 class="restaurant_name">
                <?php
                echo $this->Html->link(
                    $location['Location']['name'], array(
                    'controller' => 'locations',
                    'action'     => 'view',
                    'location'   => $location['Location']['url'],
                    'sector'     => $location['Location']['sector_slug'],
                    'distance'   => (isset($location['Location']['distance']) ? $location['Location']['distance'] * 100 : '') // multiply by 100 to remove decimals
                ));
                ?>

                

                    

                    <?php if(!empty($location['Menu']['created'])):?>
                        <?php if(strtotime($location['Menu']['created']) > (time() - (MONTH * 3))):   // if menu was created in the last 3 months, it's a new restaurant  ?> 
                            <span  class="badge new pull-right" style=""><?php echo __('NEW'); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php switch ($status_tag):
                        case NULL: 
                        break;
                        case 'close': ?>
                            <span class="badge warning pull-right glyphicon" ><?php echo __('Currently closed'); ?></span>
                        <?php break; ?>
                        <?php case 'pdf': ?>
                            <span class="badge danger pull-right glyphicon" ><?php echo __('PDF only'); ?></span>
                        <?php break; ?>
                        <?php default:?>
                            <span class="badge pull-right glyphicon" ><?php echo $status_tag; ?></span>
                        <?php break; ?>
                    <?php endswitch; ?>
                            
                    <?php if(!$ccAllowedTag): ?>
                            <span class="red pull-right glyphicon" title="<?php echo __('This restaurant is currently not accepting credit cards'); ?>"  >
                                <?php echo __('NO Credit Cards'); ?>
                            </span>  
                    <?php endif; ?>
                    
                    <?php if(!empty($location['Location']['tags'])): ?>
                        <?php foreach ($location['Location']['tags'] as $t): ?>
                            <span class="<?php echo $t['color']; ?> pull-right glyphicon" title="<?php echo $t['description']?>"  >
                                <?php echo $t['label']; ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                
            </h3>

            <!--<p><?php echo $location['Location']['description_' . $langSuffix]; ?></p>-->

            <ul class="list-group details">
                <?php if (!empty($location['Location']['delivery_average_time'])) : ?>
                    <li class="list-group-item">
                        <i class="fa fa-clock-o"></i>&nbsp;
                        <b><?php echo __('Average delivery time: '); ?></b> <?php echo $location['Location']['delivery_average_time']." " . __('minuts'); ?> 
                    </li>
                <?php endif; ?>
                <li class="list-group-item">
                    <i class="fa fa-cutlery"></i>&nbsp;
                    <?php $cuisine_list = ''; ?>
                    <?php foreach ($location['Cuisine'] as $key => $cuisine) : ?>

                        <?php if ($key == 0) : ?>
                            <?php $separator = ''; ?>
                        <?php else: ?>
                            <?php $separator = ', '; ?>
                        <?php endif; ?>

                        <?php
                        $cuisine_list .= $separator . $this->Html->tag('span', $cuisine['name'], array(
                                'class' => 'cuisine'
                        ));
                    endforeach;
                    printf('%s: %s', $this->Html->tag('b', __('Cuisines')), $cuisine_list);
                    ?>
                </li>
                <li class="list-group-item address">
                    <i class="fa fa-map-marker"></i>&nbsp;
                    <?php echo $location['Location']['building_number'] ?>&nbsp;
                    <?php echo $location['Location']['street'] ?>,
                    <?php echo ucfirst(strtolower($location['Location']['city'])) ?>&nbsp;      
                </li>
                <?php if ($location['Location']['rating'] > 0): ?> 
                    <li class="list-group-item">
                        <form><input id="input-5a" class="rating" data-disabled="true" disabled="true" value="<?php echo $location['Location']['rating'] ?>"></form>
                    </li>
                <?php endif ?>
            </ul> 
        </span>
    </div>
</li>