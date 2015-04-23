<?php
$i = 0; // $counter for collaspsing div    
$isUnCollapsed = 'in'; // flag to toggle collapse/not collapse by default. If set to = ' in' then div in open.
?>

<?php
// iterate and display menu's groups    
$even = 0;  // even or odd number
if (!empty($menu)) {
    ?>

    <div class="accordion" id="accordion2"> 
        <!-- Tip the driver -->

        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
                    <?php echo __('Tip The Driver'); ?>
                </a>
            </div>
            <div id="collapse<?php echo $i; ?>" class="accordion-body collapse in">
                <ul>
                    <?php
                    $even = 0;  // even or odd number ()
                    foreach ($tipOptions as $tipOption) {
                        $liClass = ($even % 2) ? 'even alternate' : 'odd alternate';    // odd/even li class
                        $spanClass = ($even % 2) ? 'item_name fl_left' : 'item_name fl_right';   // odd/even span class
                        $even++;
                        ?>
                        <li class="<?php echo $liClass; ?>">
                            <span class="<?php echo $spanClass; ?>">
                                <?php
                                echo $this->Html->link(
                                    $tipOption, array(
                                    'controller' => 'orders',
                                    'action' => 'add_tip',
                                    'amount' => $tipOption), array('class' => 'js-ajax'));
                                ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>


        <!-- Menu Item Grouped by Menu-groups -->
        <?php
        foreach ($categories as $category) {
            $i++;
            ?>

            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
                        <?php echo $category['MenuCategory']['name']; ?>
                    </a>
                </div>
                <div id="collapse<?php echo $i; ?>" class="accordion-body collapse">
                    <div class="category-description">
                        <p>
                            <?php echo $category['MenuCategory']['description']; ?>
                        </p>
                    </div>
                    <ul class="menu">
                        <?php
                        // iterate all the items withing this group

                        foreach ($menu as $item) {
                            foreach ($item['MenuCategory'] as $mc) {
                                if ($mc['MenuCategoriesMenuItem']['menu_category_id'] === $category['MenuCategory']['id']) {
                                    $liClass = ($even % 2) ? 'even alternate' : 'odd alternate'; // odd/even li class
                                    $spanClass = ($even % 2) ? 'item_name fl_left' : 'item_name fl_right';   // odd/ evn span class
                                    ?>

                                    <li class="<?php echo $liClass; ?>">                                      
                                        <?php
                                        // the controller will check if option exist for this item
                                        echo $this->Html->link(
                                            $item['MenuItem']['name'] . ' ' . money_format('%i', $item['MenuItem']['price']), array(
                                            'controller' => 'menuItems',
                                            'action' => 'options_modal',
                                            'item' => $item['MenuItem']['id']), array('class' => 'js-ajax'));
                                        ?>                                                                                
                                    </li>


                                    <?php $even++; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>



        <!-- // Display any items not in a category -->            

        <?php
        $titleWritten = false;
        $even = 0;

        foreach($menu as $item) {
            foreach ($item['MenuCategory'] as $mc) {
                if ($mc['MenuCategoriesMenuItem']['menu_category_id'] === $category['MenuCategory']['id']) {
                    $liClass = ($even % 2) ? 'even alternate' : 'odd alternate'; // odd/even li class
                    $spanClass = ($even % 2) ? 'item_name fl_left' : 'item_name fl_right';   // odd/ evn span class

                    if (!$titleWritten) {
                        $titleWritten = true;
                        ?>                                
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
                                    <?php echo __('Other') ?>
                                </a>
                            </div>

                            <div id="collapse<?php echo $i; ?>" class="accordion-body collapse in">
                                <?php
                            }
                            $liClass = ($even % 2) ? 'even alternate' : 'odd alternate'; // odd/even li class
                            $spanClass = ($even % 2) ? 'item_name fl_left' : 'item_name fl_right';   // odd/ evn span class
                            ?>
                            <li class="<?php echo $liClass; ?>">                                    
                                <?php
                                // the controller will check if option exist for this item
                                echo $this->Html->link(
                                    $item['MenuItem']['name'] . ' ' . money_format('%i', $item['MenuItem']['price']), array(
                                    'controller' => 'menuItems',
                                    'action' => 'menu_item_modal',
                                    'item' => $item['MenuItem']['id']), array('class' => 'js-ajax'));
                                ?>                                                                                
                            </li>
                            <?php $even++; ?>                        
                        <?php } ?>    
                    <?php } ?>    
                <?php } ?>    
            <?php } else { ?>
                <!-- No menu where found -->
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
                        <?php echo __('No menus where found'); ?>
                    </a>
                </div>
            <?php } ?>								
        </div>

    </div>
</div>
</div>