
<?php //var_dump($close_locations); ?>
        <div class="page-header results row">
                <h1><?php echo __('Restaurants delivering in'); ?></h1>
                <h2><i class="fa fa-map-marker fa-3"></i> <?php echo h($query) ?></h2>
                <?php if (empty($open_locations) && !empty($close_locations)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo __('Presently, restaurant offering online ordering are all closed'); ?>
                    </div>
                <?php elseif(empty($open_locations) && !empty($pdf_locations)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo __('Presently, no restaurant in this sector offer online ordering. They offer PDF menus'); ?>
                    </div>
                <?php endif; ?>           
        </div>
        <div class="row">

            <?php if (empty($close_locations) && empty($open_locations) && empty($pdf_locations)) : ?>
                <h3><small>
                    <?php echo __('Sorry! No results where found.'); ?>
                </small></h3>              
            <?php else : ?>

                <?php if (!empty($open_locations)): ?>
                    <ul class="list-group open">
                        <?php $len = count($open_locations); ?>
                        <?php $i   = 0; ?>
                        <?php foreach ($open_locations as $location) : ?>
                            
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => NULL)); ?>
                            
                        <?php endforeach; ?>

                    </ul>            
                <?php endif; ?>
                <?php if (!empty($close_locations)): ?>
                    <?php if(!empty($open_locations)): ?>
                    <div class="page-header results closed">
                        <h2 class="">
                            <?php echo __('The following restaurants are presently closed'); ?>
                            <?php echo (empty($page))?'': __(" (Page %s) ", $page); ?>
                        </h2>                        
                    </div>
                    <?php endif;?>

                    <ul class="list-group closed">
                        <?php $len = count($close_locations);?>
                        <?php $i   = 0;?>
                        <?php foreach ($close_locations as $location) : ?>
                        
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => 'close')); ?>
                            
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <br/>
                <?php if (!empty($pdf_locations)): ?>

                    <?php if(!empty($open_locations) || !empty($close_locations)): ?>
                    <div class="page-header results pdf">				
                        <h2 class="search_section_title">
                            <?php echo __('The following restaurants do not offer online orders'); ?>
                            <?php echo (empty($page))?'': __(" (Page %s) ", $page); ?>
                        </h2>
                    </div>
                    <?php endif; ?>

                    <ul class="list-group pdf">
                        <?php $len = count($pdf_locations); ?>
                        <?php $i   = 0; ?>

                        <?php foreach ($pdf_locations as $location) : ?>
                        
                            <?php echo $this->element('search/result_row', array('location' => $location, 'status_tag' => 'pdf')); ?>
                            
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
        </div>

