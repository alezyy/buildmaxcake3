<li class="result_row">

    <table border="0" width="100%" cellpadding="0" cellspacing="0">

        <tbody>
            <tr>
                <td class="image">
                    <?php
                    echo $this->Html->link($this->Image->out($location['Location']['logo'], '250x250'), array(
                        'controller' => 'locations',
                        'action'     => 'view',
                        'location'   => $location['Location']['url'],
                        'sector'     => $location['Location']['sector_slug'],
                        'distance'   => (isset($location['Location']['distance']) ? $location['Location']['distance'] * 100 : '')), // multiply by 100 to remove decimals
                                               array(
                        'escape' => false));
                    ?>
                </td>               
                <td width="100%" style="vertical-align: top;padding-left: 10px;">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="results">
                        <tbody>
                            <tr>
                                <td class="restaurant_title">
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
                                            <a  class="button_new" style=""><?php echo __('NEW'); ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                        
                                    <?php if ($location['Location']['rating'] > 0): ?>	
                                        <div class="rating" style="float:right;">
                                            <div id="location_header-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                                <?php
                                                echo $this->element('rating_stars_readonly', array(
                                                    'stars'      => $location['Location']['rating'],
                                                    'locationId' => $location['Location']['id'],
                                                    'userId'     => $this->Session->read('Auth.User.id')));
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <div class="resto_decription">
                                        <?php echo $location['Location']['description_' . $langSuffix]; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul class="resto_info_srp">
                                        <?php if (!empty($location['Location']['delivery_average_time'])) : ?>
                                            <li>
                                                <?php echo __('Average delivery time: %s minutes', $location['Location']['delivery_average_time']); ?>
                                            </li>
                                        <?php endif; ?>
                                            <li class="cusineTypesTd">
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
                                        <li>
                                            <?php echo $location['Location']['building_number'] ?>&nbsp;
                                            <?php echo $location['Location']['street'] ?>,
                                            <?php echo ucfirst(strtolower($location['Location']['city'])) ?>&nbsp;		
                                        </li>
                                    </ul> 
                                </td>

                            </tr> 
                            <!--
                            <?php if (!empty($location['Location']['delivery_fee'])): ?>
                                <?php if ($location['Location']['delivery_fee']['delivery_min'] > 0): ?>
                                                                            <tr>
                                                                                <td>
                                    <?php echo __('Delivery minimum amount: ') ?>
                                    <?php echo $this->Number->currency($location['Location']['delivery_fee']['delivery_min'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2')); ?>
                                                                                </td>
                                                                            </tr>
                                <?php endif; ?>
                                                                <tr>
                                                                    <td>
                                <?php
                                if ($location['Location']['delivery_fee']['delivery_charge'] > 0):
                                    echo __('Delivery Fee: ');
                                    echo $this->Number->currency($location['Location']['delivery_fee']['delivery_charge'], $this->request->language . '_' . Configure::read('I18N.COUNTRY_CODE_2'));
                                else:
                                    echo __('Free delivery');
                                endif;
                                ?>
                                                                    </td>
                                                                </tr> 
                            <?php endif; ?>
                            -->

                        </tbody>
                    </table>
                    <ul class="tags">
                        
                        <?php switch ($status_tag):
                            case NULL: 
                            break;
                            case 'close': ?>
                                <li><a class="gray" ><?php echo __('Currently closed'); ?></a></li>
                            <?php break; ?>
                            <?php case 'pdf': ?>
                                <li><a class="green" ><?php echo __('PDF only'); ?></a></li>
                            <?php break; ?>
                            <?php default:?>
                                <li><a class="gray" ><?php echo $status_tag; ?></a></li>
                            <?php break; ?>
                        <?php endswitch; ?>
                                
                        <?php if(!$ccAllowedTag): ?>
                            <li>
                                <a class="red" title="<?php echo __('This restaurant is currently not accepting credit cards'); ?>"  >
                                    <?php echo __('NO Credit Cards'); ?>
                                </a>
                            </li>    
                        <?php endif; ?>
                        
                        <?php if(!empty($location['Location']['tags'])): ?>
                            <?php foreach ($location['Location']['tags'] as $t): ?>
                            <li>
                                <a class="<?php echo $t['color']; ?>" title="<?php echo $t['description']?>"  >
                                    <?php echo $t['label']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</li>