<div id="content_inner">
    <div class="other_center">
        <div class="gray_head_box">
            <div class="gray_head_heading">
                <h1><?php echo __("Topmenu's Support Information"); ?></h1>                
            </div>            
        </div>
        <div class="location_view">
            <ul>
                <li>
                    <a href="javascript:void(0)" onclick="return popitup('http://www.providesupport.com/?messenger=topmenuweb')"><i class="icon-comment" style="margin-right:3px;"></i>
                        <?php echo __('Chat with our customer service'); ?>
                    </a>
                </li>
                <li>
                     <?php
                    echo $this->Html->link(__('Send us an email'), 
                        array('controller' => 'contacts', 'action' => 'index'),
                        array('icon' => 'icon-envelope'));
                    ?>
                </li>
                
                 <li>
                     <?php echo $this->Html->link(
                         __("Issues with your Topmenu flyer"), 
                            array('controller' => 'contacts', 'action' => 'flyers'),
                            array('icon' => 'icon-book'));
                         ?>
                </li>               
                <li>
                    <?php 
                        echo $this->Html->link(__('FAQ'), 
                            array('controller' => 'pages', 'action' => 'user_guide'),
                            array('icon' => 'icon-question-sign'));
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        __('Add your restaurant'), 
                        array('controller' => 'restaurants','action' => 'add_restaurant'),
                        array('icon' => 'icon-plus-sign'));
                    ?>
                </li>

            </ul>
        </div>

    </div>
</div>