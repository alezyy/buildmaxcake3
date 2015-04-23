<div class="other_left_cntnr" id="right_col">
    <div class="right_frst_row">

        <div class="gray_head_box followMeBar">
            <div class="gray_head_heading">
                <h1><?php echo h($query); ?></h1>
                <?php if (empty($open_locations) && !empty($close_locations)): ?>
                    <span style="font-size: .7em ">
                        <?php echo __('(Presently, restaurant offering online ordering are all closed)'); ?>
                    </span>
                <?php elseif(empty($open_locations) && !empty($pdf_locations)): ?>
                    <span style="font-size: .7em ">
                        <?php echo __('(Presently, no restaurant in this sector offer online ordering. They offer PDF menus)'); ?>
                    </span>
                <?php endif; ?>
            </div>            
        </div>
        <div class="featured_restaurants">
            <?php if (!empty($cuisineDescription)): ?>
            <div class="noRecords" id="cuisineDescription" style="         
                 text-align: justify;
                 overflow: hidden;
                 text-overflow: ellipsis;">
                <?php echo $cuisineDescription; ?>
            </div>
            <div id="cuisineDescriptionShowMore" style="display:none; text-align: right; padding: 5px 20px 0 20px">
                <a href="javascript:void(0);" id="cuisineDescriptionMoreLink"><?php echo __('Show More'); ?></a>
            </div>
            <div id="cuisineDescriptionShowLess" style="display:none; text-align: right; padding: 5px 20px 0 20px">
                <a href="javascript:void(0);" id="cuisineDescriptionLessLink"><?php echo __('Show Less'); ?></a>
            </div>
            <div class="separator_horizontal_dim mT20 mB20"></div>
            <?php endif; ?>

            <?php if (empty($close_locations) && empty($open_locations) && empty($pdf_locations)) : ?>
                <div class="noRecords">
                    <?php echo __('Sorry! No results where found.'); ?>
                </div>                
            <?php else : ?>

                <?php if (!empty($open_locations)): ?>
                    <ul class="list">
                        <?php $len = count($open_locations); ?>
                        <?php $i   = 0; ?>
                        <?php foreach ($open_locations as $location) : ?>
                            <?php $i++; ?>
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => NULL)); ?>
                            <?php if ($i < $len): ?>
                                <div class="separator_horizontal_dim mT20 mB20"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </ul>            
                <?php endif; ?>
                <?php if (!empty($close_locations)): ?>
                    <?php if(!empty($open_locations)): ?>
                    <div class="followMeBar subSearchResultTitle">
                        <h2 class="search_section_title">
                            <?php echo __('The following restaurants are presently closed'); ?>
                            <?php echo (empty($page))?'': __(" (Page %s) ", $page); ?>
                        </h2>                        
                    </div>
                    <?php endif;?>

                    <ul class="list list resto_closed_ul">
                        <?php $len = count($close_locations);?>
                        <?php $i   = 0;?>
                        <?php foreach ($close_locations as $location) : ?>
                        <?php $i++; ?>
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => 'close')); ?>
                            <?php if ($i < $len): ?>
                                <div class="separator_horizontal_dim mT20 mB20"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if (!empty($pdf_locations)): ?>

                    <?php if(!empty($open_locations) || !empty($close_locations)): ?>
                    <div class="followMeBar subSearchResultTitle">				
                        <h2 class="search_section_title">
                            <?php echo __('The following restaurants do not offer online orders'); ?>
                            <?php echo (empty($page))?'': __(" (Page %s) ", $page); ?>
                        </h2>
                    </div>
                    <?php endif; ?>

                    <ul class="list resto_pdf_ul">
                        <?php $len = count($pdf_locations); ?>
                        <?php $i   = 0; ?>

                        <?php foreach ($pdf_locations as $location) : ?>
                        <?php $i++; ?>
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => 'pdf')); ?>
                            <?php if ($i < $len): ?>
                                <div class="separator_horizontal_dim mT20 mB20"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $this->Html->script('search_results_descriptions');