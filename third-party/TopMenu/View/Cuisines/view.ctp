<div class="container-white">
    <div class="page-header">
    	<h1><?php echo __('Cuisines Types'); ?></h1>
    </div>


    <div class="row directory">

    	<ul class="list-group">	
    	<?php foreach ($cuisines as $cuisine): ?>
            <li class="list-group-item col-xs-12 col-md-4 col-lg-3">
                <?php
                    echo $this->Html->link(
                        __($cuisine['Cuisine']['name']),
                        Router::url(
                            [
                                'controller' => 'cuisines',
                                'action' => 'search',
                                'language' => $langSuffix,
                                'cuisine' => $cuisine['Cuisine']['url']
                            ]
                        )
                    );
                ?>
            </li>
        <?php endforeach; ?> 
    	</ul>
    </div>
</div>