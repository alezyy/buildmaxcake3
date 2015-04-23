<div class="col-xs-12 no-padding" id="content">
	<div class="col-xs-12 col-md-3 pull-left sidebar-left sidebar-parent">
		<div class="sidebar col-xs-12">
			<h1 class="page-header text-red"><strong><?php echo __('Search'); ?></strong></h1>

			<div class="list-group">
				<?php
	                echo $this->Form->create(
	                    'Location', array(
	                    'class' => 'form-inline',
	                    'url'   => array(
	                        'controller' => 'locations',
	                        'action'     => 'search'
	                    ),
	                    'id'    => 'delivery'
	                    )
	                );
	                echo $this->Form->input('postal_code1', array(
	                        'label'     => __('Enter your postal code'), array('class'=>'text-red'),
	                        'placeholder' => 'H0H',
	                        'div'       => FALSE,
	                        'no_div'    => TRUE,
	                        'class'     => 'text-center col-xs-12 col-md-8',
	                        'maxlength' => 3,
	                        'style'     => 'text-transform: uppercase;',
	                        'tabindex'  => 1,
	                        'type'      => 'text'));

	                    echo $this->Form->submit('GO !', array('class' => 'btn btn-primary col-xs-12 col-md-4', 'id' => 'postalCodeSubmit'));

	                echo $this->Form->End();
	            ?>
            </div><br/><br/>

            <div class="page-header">
				<h4 class=""></h4>
			</div>

			<?php  ?>
			<ul class="list-group scrollbar">	
		    
		        <li>
		            <?php
	                    echo $this->Html->link(
	                        __('Open'),
	                        Router::url(
	                            [
	                                
	                            ]
	                        ),
					        [
					        	'class' => ''
					        ]
	                    );
                    ?>
		        </li>   
		        <li>
		            <?php
	                    echo $this->Html->link(
	                        __('Closed'),
	                        Router::url(
	                            [
	                                
	                            ]
	                        ),
					        [
					        	'class' => ''
					        ]
	                    );
                    ?>
		        </li>   
		        <li>
		            <?php
	                    echo $this->Html->link(
	                        __('PDF Only'),
	                        Router::url(
	                            [
	                                
	                            ]
	                        ),
					        [
					        	'class' => ''
					        ]
	                    );
                    ?>
		        </li>   
		    </ul>

		    <div class="page-header">
				<h4 class=""><?php echo __('Cuisines'); ?></h4>
			</div>

			<?php  ?>
			<ul class="list-group scrollbar">	
		    <?php foreach ($cuisines as $cuisine): ?>
		        <li>
		            <?php
	                    echo $this->Html->link(
	                        __($cuisine['Cuisine']['name_'.$langSuffix]),
	                        Router::url(
	                            [
	                                'controller' => 'cuisines',
	                                'action' => 'search',
	                                'language' => $langSuffix,
	                                'cuisine' => $cuisine['Cuisine']['url']
	                            ]
	                        ),
					        [
					        	'class' => isset($this->request->params["cuisine"]) && ($this->request->params["cuisine"] == strtolower(Inflector::slug($cuisine['Cuisine']['name_'.$langSuffix], '-'))) ? 'active' : ''
					        ]
	                    );
                    ?>
		        </li>

		    <?php endforeach; ?>    
		    </ul>

		</div>
	</div><!--/left-->

	<div class="col-xs-12 col-md-9 pull-right">
		<div class="page-header results row">
            <h1><?php echo __('Restaurants offering'); ?></h1>
            <h2><i class="ion-android-restaurant"></i> <?php echo h($cuisineName) ?></h2>           
        </div>
        <div class="row">
	        
	        <?php echo $this->Html->image('http://rottnestlodge.com.au/wp-content/uploads/2011/11/the-food-banner-1.jpg',
		                //$this->Html->image('placeholder_fr_250x250.png',
		                    array(
		                        "alt" => $cuisineName, 
		                        "title" => $cuisineName, 
		                        'class' => 'img-responsive'
		                    )
		                ); ?>
        	<div class="list-group-item">
        	<?php if(empty($locations)): ?>
	            <h3><small>
	                <?php echo __('Sorry! No results where found.'); ?>
	            </small></h3> 
        	<?php endif; ?>
	       </div>

	        <ul class="list-group open">
			<?php foreach ($locations as $location): ?>
				<li class="list-group-item result">
			        <div class="row">   
			                <!-- Caption Image -->
			            <?php echo $this->Html->link(

			                // $this->Html->image((!empty($location['logo']) ? $location['logo'] : 'placeholder_fr_250x250.png'), 
			                $this->Image->out($location['logo'], '514x514', false, false, true,
			                    array(
			                        "alt" => $location['name'], 
			                        "title" => $location['name'], 
			                        'class' => 'img-responsive restaurant_logo', 
			                        'height' => 250,
			                        'width' => 250
			                    )
			                ),
			                array(
			                    'controller' => 'locations',
			                    'action'     => 'view',
			                    'location'   => $location['url'],
			                    'sector'     => $location['sector_slug'],
			                    'distance'   => (isset($location['distance']) ? $location['distance'] * 100 : '')
			                ),
			                array(
			                    'escape' => false,
			                    'class' => 'col-xs-12 col-md-4'
			                )
			            ); ?>

			            <span class="col-xs-12 col-md-8">
			                <h3 class="restaurant_name">
			                    <?php
			                    echo $this->Html->link(
			                        $location['name'], array(
			                        'controller' => 'locations',
			                        'action'     => 'view',
			                        'location'   => $location['url'],
			                        'sector'     => $location['sector_slug'],
			                        'distance'   => (isset($location['distance']) ? $location['distance'] * 100 : '') // multiply by 100 to remove decimals
			                    ));
			                    ?>

			                    

			                        

			                        <?php if(!empty($location['Menu']['created'])):?>
			                            <?php if(strtotime($location['Menu']['created']) > (time() - (MONTH * 3))):   // if menu was created in the last 3 months, it's a new restaurant  ?> 
			                                <span  class="badge new pull-right" style=""><?php echo __('NEW'); ?></span>
			                            <?php endif; ?>
			                        <?php endif; ?>

			                        
			                        <?php if(!empty($location['tags'])): ?>
			                            <?php foreach ($location['tags'] as $t): ?>
			                                <span class="<?php echo $t['color']; ?> pull-right glyphicon" title="<?php echo $t['description']?>"  >
			                                    <?php echo $t['label']; ?>
			                                </span>
			                            <?php endforeach; ?>
			                        <?php endif; ?>
			                    
			                </h3>

			                <p><?php echo $location['description_' . $langSuffix]; ?></p>

			                <ul class="list-group details">
			                    <?php if (!empty($location['delivery_average_time'])) : ?>
			                        <li class="list-group-item">
			                            <i class="fa fa-clock-o"></i>&nbsp;
			                            <b><?php echo __('Average delivery time: '); ?></b> <?php echo $location['delivery_average_time']." " . __('minuts'); ?> 
			                        </li>
			                    <?php endif; ?>
		
			                    <li class="list-group-item address">
			                        <i class="fa fa-map-marker"></i>&nbsp;
			                        <?php echo $location['building_number'] ?>&nbsp;
			                        <?php echo $location['street'] ?>,
			                        <?php echo ucfirst(strtolower($location['city'])) ?>&nbsp;      
			                    </li>
			                    <?php if ($location['rating'] > 0): ?> 
			                        <li class="list-group-item">
			                            <form><input id="input-5a" class="rating" data-disabled="true" disabled="true" value="<?php echo $location['rating'] ?>"></form>
			                        </li>
			                    <?php endif ?>
			                </ul> 
			            </span>
			        </div>
			    </li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>

</div>

<?php echo $this->element('postal_code_modal'); ?>