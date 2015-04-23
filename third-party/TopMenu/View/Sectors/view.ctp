<div class="container-white">	
	<div class="page-header">
	    <h1><?php echo __('Sectors'); ?></h1>
	</div>


	<div class="row directory">
	    <ul class="list-group"> 
	        <?php foreach ($sectors AS $s): ?>
                <li class="list-group-item col-xs-12 col-md-4 col-lg-3">
                    <?php
                    echo $this->Html->link(
                        __($s['Sector']['name_'.$langsuffix]),
                        Router::url(
	                        [
	                            'controller' => 'locations',
	                            'action' => 'search',
	                            'language' => $langSuffix,
	                            'nh' => $s['Sector']['url']
	                        ]
	                    )
                    );
                    ?>
                </li>
	        <?php endforeach; ?>
	    </ul>
	</div>
</div>